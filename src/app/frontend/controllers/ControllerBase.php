<?php

namespace controllers;


use Phalcon\Mvc\Dispatcher;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public $lang_id;
    public $lang_name;
    public $t;
    public $count_cart;

    public function init() {
        $this->lang_id = $this->seoUrl->getLangId();
        $this->lang_name = $this->seoUrl->getLangName();
        $this->t = $this->languages->getTranslation();

        $this->count_cart = 0;
        if($this->session->has('in_cart') && $cart = $this->session->get('in_cart')) {
            foreach ($cart as $item) {
                $this->count_cart += $item['count_items'];
            }
        }

    }

    public function beforeExecuteRoute(Dispatcher $dispatcher) {

        $this->init();

        if($this->session->has('id')) {
            $customer = $this->models->getCustomers()->getOneData($this->session->get('id'))['0'];
            $this->view->setVar('customer', $customer);
        }

        if($this->session->get('special_users_id') != null) {

            $orders = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );

            foreach($orders as $key => $value) {
                $orders[$key]['created_date'] = date('d', strtotime($value['created_date'])).'.'.
                    date('m', strtotime($value['created_date'])).'.'.
                    date('Y', strtotime($value['created_date']));
                $orders_sum = !empty($this->models->getOrders()->getOrdersSumById( $value['id'] )[0]) ? $this->models->getOrders()->getOrdersSumById( $value['id'] )[0] : 0;
                $orders[$key]['price'] = $orders_sum['price'];
                $orders[$key]['status'] = \config::get( 'global#status/'.$this->lang_id.'/'.$value['status'] );
            }

            $this->view->setVar('orders', $orders);
        }

        $compare        = $this->session->get('compare', []);
        $count          = 0;

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
                if( !empty($catalogs[$key] ) )
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
        }
        $this->view->setVar('count_cart', $this->count_cart);
        $this->view->setVar('t', $this->t);
        $this->view->setVar('lang_id', $this->lang_id);
        $this->view->setVar('lang', explode( '/', $this->request->get('_url')));
        $this->view->setVar('month_names', $this->t->_("month_list"));
        $this->view->setVar('compare', $compare);
        $this->view->setVar('compare_', !empty($compare_) ? $compare_ : null);
        $this->view->setVar('count', $count);
    }
}