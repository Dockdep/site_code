<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
use \Phalcon\Mvc\View;

class AjaxController extends \controllers\ControllerBase
{
    ///////////////////////////////////////////////////////////////////////////

    public function getItemsAction(  )
    {
        header('Content-Type: application/json; charset=utf8');
       
        $term       = $this->request->getPost('term', 'string', '' );

        $items_     = $this->models->getItems()->getItemsByTermFromCatalog( $term, 'items_dropdown', 1, $this->lang_id );
        if(!$items_) {
            $items_     = $this->models->getItems()->getItemsByTerm( $term, 'items_dropdown', 1, $this->lang_id );
        }

        $items      = [];
        if( !empty( $items_ ) )
        {
            $items_ids  = $this->common->array_column( $items_, 'item_id' );

            $items      = $this->models->getItems()->getItemsByIds( $this->lang_id, $items_ids );
            foreach( $items as &$i )
            {
                $i['cover']         = !empty( $i['group_cover'] ) ? $this->storage->getPhotoUrl( $i['group_cover'], 'avatar', '200x' ) : '/images/packet.jpg';
                $i['alias']         = $this->seoUrl->setUrl($this->url->get([ 'for' => 'item', 'subtype' => $i['catalog_alias'], 'group_alias' => $i['group_alias'], 'item_id' => $i['id'] ]));
            }
        }

        die( json_encode( $items ) );
    }


    public function addItemsForCompareAction( )
    {
        header('Content-Type: application/json; charset=utf8');

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_properties    = $this->request->getPost( 'item_id', 'string', '' );
            $item_properties    = explode( '-', $item_properties );
            $check              = $this->request->getPost( 'check', 'int', '' );

            $type_id            = $item_properties['0'];
            $subtype_id         = $item_properties['1'];
            $item_id            = $item_properties['2'];

            $compare            = $this->session->get('compare', []);

            if( !isset($compare[$type_id][$subtype_id]) || ( isset($compare[$type_id][$subtype_id]) && !in_array( $item_id, $compare[$type_id][$subtype_id] ) ) )
            {
                $compare[$type_id][$subtype_id][] = $item_id;
            }

            elseif( isset($compare[$type_id][$subtype_id]) && in_array( $item_id, $compare[$type_id][$subtype_id] ) )
            {
                foreach( $compare[$type_id][$subtype_id] as $k => $v )
                {
                    if( $v == $item_id )
                    {

                        unset( $compare[$type_id][$subtype_id][$k] );

                        if( empty( $compare[$type_id][$subtype_id] ) )
                        {
                            unset($compare[$type_id][$subtype_id]);
                        }
                        if( empty( $compare[$type_id] ) )
                        {
                            unset($compare[$type_id]);
                        }

                    }
                }
            }

            $count = 0;
            $compare_ = [];

            if( !empty( $compare ) )
            {

                foreach( $compare as $key => $comp )
                {
                    $type_ids[] = $key;

                    foreach( $comp as $k => $c )
                    {
                        $subtype_ids[] = $k;

                        $count += count($c);
                    }
                }
                $catalogs = $this->common->getTypeSubtype2( $this->lang_id );

                foreach( $compare as $key => $comp )
                {
                    foreach( $comp as $k => $c )
                    {
                        $compare_[$key][$k] =
                            [
                                'title' => $catalogs[$k]['title'],
                                'count' => count($c),
                                'items' => $c,
                                'url'       => $this->url->get([ 'for' => 'compare_items',  'subtype' => $catalogs[$k]['alias'], 'compare_ids' => join('-', $c) ]),
								'url_del'   => $this->url->get([ 'for' => 'compare_items_del',  'subtype' => $catalogs[$k]['alias'], 'compare_ids' => join('-', $c) ])

							];
                    }
                }
            }

            $this->session->set( 'compare', $compare );
        }

        die(json_encode($compare_));
    }

    public function toggleCabinetAction() {
        $this->view->disable();
        if( $this->request->isAjax() ) {
            if(!$this->session->has('isToggled')) {
                $this->session->set('isToggled', true);
            } else {
                if($this->session->get('isToggled')) {
                    $this->session->set('isToggled', false);
                } else {
                    $this->session->set('isToggled', true);
                }
            }

        }
        echo json_encode($this->session->get('isToggled'));
    }

    public function getActionDiscountAction($action_id) {
        if($this->request->isAjax()) {
            $action_discount = $this->models->getActions()->getActionDiscountByActionId($action_id);
        }
        $this->view->setVar('action_discount', $action_discount);
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    public function setActionDiscountAction() {
        $this->view->disable();
        if($this->request->isAjax()) {
            $action_id = $this->request->getPost('action_id', 'string', '' );
            $firm_total = $this->request->getPost('firm_total', 'string', '');

            $this->session->set('action_id', $action_id);
            $this->session->set('firm_total', $firm_total);
        }
    }

    public function getItemGroupAction() {
        $this->view->disable();
        $group_id = $this->request->getPost( 'group_id', 'int', '' );
        $item_id = $this->request->getPost('item_id', 'int', '');
        if(isset($item_id) && !empty($item_id)) {
            $item = $this->models->getItems()->getOneItem($this->lang_id, $item_id);
        } else {
            $item = $this->models->getItems()->getSizesByGroupId($this->lang_id, $group_id);
        }
        echo json_encode($item[0]);
    }

    public function applyPromoCodeAction() {
        $this->view->disable();
        $in_cart = $this->session->get('in_cart', []);
        $cart = $this->common->getCartItems($in_cart, $this->lang_id);

        $promo_code = $this->request->getPost( 'promo_code', 'string', '' );

        $promo_code	= $this->models->getPromoCodes()->getOneDataByCode($promo_code);

        if(!empty($promo_code)) {
            if($this->common->applyPromoCode($promo_code[0], $cart['items'])) {
                $this->session->set('promo_code', $promo_code[0]);
                $this->common->countOrderSum($cart);
                echo json_encode($cart);
                return;
            }
        }
        return null;
    }
}
 