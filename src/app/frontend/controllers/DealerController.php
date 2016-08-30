<?php

namespace controllers;

use Phalcon\Exception;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

class DealerController extends \controllers\ControllerBase
{

    public function initialize() {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        $this->view->setVar('action', $dispatcher->getActionName());
        parent::beforeExecuteRoute($dispatcher);

        if($this->session->get('special_users_id') == null) {
            return $this->response->redirect([
                'for' => 'customer_login',
                'language' => $this->lang_name,
                'controller' => 'customer'
            ]);
        }
    }

    public function indexAction()
    {
        $titlecmp = function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        };

        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }
        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];

        $catalog = $this->common->getTypeSubtype1( NULL, $this->lang_id )['catalog'];
        foreach($catalog as $k => $v){
            usort($v['sub'] , $titlecmp);
            $catalog[$k] = $v;
        }
        $catalog_first = $catalog['1'];
        unset($catalog['1']);
        usort($catalog_first['sub'], $titlecmp);

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'catalog_first' => $catalog_first,
            'catalog' => $catalog
        ]);
    }

    public function uploadAction()
    {
        $this->view->disable();
        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file) {

                $allowed_filetypes = array('.jpg', '.JPG');

                $ext = substr($file->getName(), strpos($file->getName(), '.'), strlen($file->getName()) - 1);

                if(in_array($ext, $allowed_filetypes)){

                    $avatar = $this->models->getCustomers()->getCustomerAvatar($this->session->get('id'))[0]['avatar'];

                    if(!empty($avatar)) {
                        $imageOriginal = $this->storage->getPhotoPath('dealers', $avatar, 'original');
                        $imageResize = $this->storage->getPhotoPath('dealers', $avatar, '160x');
                        if(file_exists($imageOriginal))
                            unlink($imageOriginal);
                        if(file_exists($imageResize))
                            unlink($imageResize);
                    }
                    $path = $file->getTempName();

                    $md5_file = md5_file($path);
                    $image_path = $this->storage->getPhotoPath('dealers', $md5_file, 'original');

                    if(!file_exists(substr($image_path , 0, strlen($image_path) - 13))) {
                        $this->storage->mkdir('dealers', $md5_file);
                    }

                    $file->moveTo($image_path);
                    $this->storage->imageCut($md5_file, 'dealers');
                    $this->models->getCustomers()->editCustomerPhoto($this->session->get('id'), $md5_file);

                } else {
                    $this->flash->error('Произошла ошибка. Не верный формат файла.');
                }
            }
        } else {
            throw new Exception();
        }
        echo json_encode(strstr($this->storage->getPhotoPath('dealers', $md5_file, '160x'), '/dealers'));
    }

    public function usefulMaterialsAction() {
        $lang_url = $this->seoUrl->getChangeLangUrl();
        $params = $this->dispatcher->getParams();
        $page = isset($params['page']) && !empty($params['page']) ? $params['page'] : 1;
        $rub = isset($params['rub']) && !empty($params['rub']) ? $params['rub'] : 0;

        $this->lang_id = $this->seoUrl->getLangId();
        $tips = $this->models->getNews()->getTips( $this->lang_id, $page, $rub );

        foreach( $tips as $k => $n )
        {
            $tips[$k]['image']  = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '180x120' ) : '';
            $tips[$k]['link']   = $this->url->get([ 'for' => 'one_useful_material', 'tips_id' => $n['id'], 'tips_alias' => $n['alias'] ]);
        }

        $total = $this->models->getNews()->getTotalTips( $this->lang_id,$rub );

        $meta_title =
            [
                '1' => 'Поради професіоналів | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Советы профессионалов | Интернет магазин семян Semena.in.ua'
            ];

        $meta_description =
            [
                '1' => 'Поради професійних агрономів та фермерів на сайті Semena.in.ua.',
                '2' => 'Советы профессиональных агрономов и фермеров на сайте Semena.in.ua.'
            ];
        if(empty($params['rub'])) $params['rub'] = '';
        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => \config::get( 'limits/news', 5),
                'total_items'       => $total['0']['count'],
                'url_for'           => [ 'for' => ((!empty($params['rub'])) ? 'useful_materials_rubric_paginate' : 'useful_materials_paginate'), 'page' => $page,'rub'=>$params['rub'] ],
                'index_page'       => 'useful_materials'
            ], true
        );

        $meta_link_next =
            [
                '1' =>isset($paginate['meta_link_next']) ? $paginate['meta_link_next'] : ''
            ];

        $meta_link_prev =
            [
                '1' =>isset($paginate['meta_link_prev']) ? $paginate['meta_link_prev'] : ''
            ];

        $this->view->setVars([
            'change_lang_url'   => $lang_url,
            'rubrics' 			=> $this->models->getRubricsNews()->getAllRubrics($this->lang_id),
            'tips'              => $tips,
            'page'              => $page,
            'total'             => $total['0']['count'],
            'meta_title'        => $meta_title[$this->lang_id],
            'meta_description'  => $meta_description[$this->lang_id],
            'meta_link_next'    => $meta_link_next[1],
            'meta_link_prev'    => $meta_link_prev[1],
            'paginate'          => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    public function oneUsefulMaterialAction() {
        $params = $this->dispatcher->getParams();
        $tips_id = $params['tips_id'];

        $one_news                   = $this->models->getNews()->getOneNews( $this->lang_id, $tips_id );

        if( !empty( $one_news ) )
        {
            $one_news['0']['link']      = $this->url->get([ 'for' => 'one_tips', 'tips_id' => $one_news['0']['id'], 'tips_alias' => $one_news['0']['alias'] ]);
            $one_news['0']['image']     = $this->storage->getPhotoUrl( $one_news['0']['cover'], 'news', '400x265' );

            $news2groups_ids_           = $this->etc->int2arr($one_news['0']['group_id']);

            $news2groups                = [];
            $pages_news2groups          = '';

            if( !empty( $news2groups_ids_ ) )
            {
                $news2groups_ids            = array_chunk( $news2groups_ids_, \config::get( 'limits/groups2news' ) );
                $total_groups               = count($news2groups_ids_);
                $news2groups_               = $this->models->getItems()->getNews2Groups( $this->lang_id, $news2groups_ids['0'] );

                $news2groups                = $this->common->getGroups( $this->lang_id, $news2groups_ );


                $pages_news2groups          =
                    $total_groups%\config::get( 'limits/groups2news' )==0
                        ?
                        $total_groups/\config::get( 'limits/groups2news' )
                        :
                        floor( $total_groups/\config::get( 'limits/groups2news' ) )+1;

            }
            if( !empty( $one_news['0']['photogallery'] ) )
            {
                $one_news['0']['photos'] = $this->etc->int2arr($one_news['0']['photogallery']);
            }

            $meta_title =
                [
                    '1' => $one_news['0']['title'].' | Інтернет магазин насіння Semena.in.ua',
                    '2' => $one_news['0']['title'].' | Интернет магазин семян Semena.in.ua '
                ];

            $meta_description =
                [
                    '1' => $one_news['0']['title'].' Актуально на Semena.in.ua.',
                    '2' => $one_news['0']['title'].' Актуально на Semena.in.ua.'
                ];


            $this->view->setVars([
                'one_news'          => $one_news['0'],
                'meta_title'        => $meta_title[$this->lang_id],
                'meta_description'  => $meta_description[$this->lang_id],
                'news2groups'       => $news2groups,
                'pages_news2groups' => $pages_news2groups,
            ]);
        }
        else
        {
            $this->dispatcher->forward([
                'controller'    => 'page',
                'action'        => 'error404'
            ]);
        }
    }

    public function topItemsAction() {
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page'] ) ? $params['page'] : 1;
        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];


        $top_items = $this->models->getItems()->getTopGroupsByCustomer($this->lang_id, $this->session->get('id'));
        $top_items = $this->common->explodeAlias($top_items);
        $top_items_ = $this->common->getGroups1($this->lang_id, $top_items);
        $total_top_items = count($top_items_);

        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => 50,
                'total_items'       => $total_top_items,
                'url_for'           => [ 'for' => 'top_items_paginate', 'page' => $page ],
                'index_page'       => 'top_orders'
            ], true
        );

        $this->view->pick('dealer/items');

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'items' => $top_items_,
            'total_items' => $total_top_items[0]['total'],
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : ''
        ]);
    }

    public function topDealerItemsAction() {
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];


        $top_items = $this->models->getItems()->getDealersTopGroups($this->lang_id);

        $top_items = $this->common->explodeAlias($top_items);
        $top_items_ = $this->common->getGroups1($this->lang_id, $top_items);
        $total_top_items = count($top_items_);



        if($this->session->get('special_users_id') != null) {
            $special_users_id = $this->session->get('special_users_id');
            $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
        }




        if(isset($special_user)){
            foreach($top_items_ as $k => $top_items){

                foreach($top_items['items'] as $i => $top_item){

                    $top_items_[$k]['price'] = number_format($top_items_[$k]['items'][0]['prices'][$special_user['status']], 2, '.', '' );

                }

            }
        }

        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => 50,
                'total_items'       => $total_top_items,
                'url_for'           => [ 'for' => 'top_items_paginate', 'page' => $page ],
                'index_page'       => 'top_dealer_orders'
            ], true
        );

        $this->view->pick('dealer/items');

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'items' => $top_items_,
            'total_items' => $total_top_items,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : ''
        ]);
    }

    public function recommendedItemsAction() {

        if($this->session->has('id') && $this->session->get('users_group_id') != null) {
            $users_group = $this->models->getUsersGroup()->getOneData($this->session->get('users_group_id'));
            $users_group_name = $users_group['0']['name'];
        } else {
            $users_group_name = \config::get('frontend#defaults/default_users_group');
        }

        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];

        if($users_group_name != \config::get('frontend#defaults/default_users_group')) {
            $recommended_items = $this->models->getItems()->getRecommendedGroupsByUsersGroup($this->lang_id, $users_group_name);
            $total_recommended_items = $this->models->getItems()->getTotalRecommendedItemsByUsersGroup($users_group_name);
        } else {
            $recommended_items = $this->models->getItems()->getRecommendedGroups($this->lang_id, \config::get( 'limits/top_items' ));
            $total_recommended_items = $this->models->getItems()->getTotalRecommendedItems();
        }

        $recommended_items = $this->common->explodeAlias($recommended_items);
        $recommended_items_ = $this->common->getGroups1($this->lang_id, $recommended_items);

        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => 50,
                'total_items'       => $total_recommended_items[0]['total'],
                'url_for'           =>  [ 'for' => 'recommended_items_paginate', 'page' => $page ],
                'index_page'       => 'recommended_items'
            ], true
        );

        $this->view->pick('dealer/items');

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'items' => $recommended_items_,
            'total_items' => $total_recommended_items[0]['total'],
            'paginate' => $paginate
        ]);
    }

    public function newItemsAction() {
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];
        $new_items = $this->models->getItems()->getNewGroups($this->lang_id);
        $new_items = $this->common->explodeAlias($new_items);
        $new_items_ = $this->common->getGroups1($this->lang_id, $new_items);
        $total_new_items = $this->models->getItems()->getTotalNewItems();


        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => 50,
                'total_items'       => $total_new_items[0]['total'],
                'url_for'           =>  [ 'for' => 'recommended_items_paginate', 'page' => $page ],
                'index_page'       => 'recommended_items'
            ], true
        );

        $this->view->pick('dealer/items');

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'items' => $new_items_,
            'total_items' => $total_new_items[0]['total'],
            'paginate' => $paginate
        ]);
    }

    public function cartAction()
    {
        /*
        $file = '/home/dev/www/semena/www/images/action1.jpg';

        $md5_file = md5_file($file);
        for($j = 1; $j < 4; $j++)
        for($i = 0; $i < $j; $i++) {
            $data['discount'] = 2 * ($i+$j);
            $data['cover'] = $md5_file;
            $data['action_id'] = $j;
            $this->models->getActions()->addActionDiscount($data);
        }
        die();
        $this->models->getActions().addActionDiscount();
        $image_path = $this->storage->getPhotoPath( 'actions', $md5_file, 'original' );
        if(!file_exists($image_path))
        {
            $this->storage->mkdir( 'actions', $md5_file );
            copy($file, $image_path);
        }


        die();
        */


        if($this->session->has('id') && !empty($this->session->get('users_group_id'))) {
            $users_group = $this->models->getUsersGroup()->getOneData($this->session->get('users_group_id'));
            $users_group_name = $users_group['0']['name'];
        } else {
            $users_group_name = \config::get('frontend#defaults/default_users_group');
        }

        $top_items          = $this->models->getItems()->getTopGroups($this->lang_id, \config::get( 'limits/top_items' ));
        $top_items          = $this->common->explodeAlias($top_items);
        $top_items_         = $this->common->getGroups1( $this->lang_id, $top_items );

        $total_top_items    = $this->models->getItems()->getTotalTopItems($this->lang_id);
        $new_items          = $this->models->getItems()->getNewGroups($this->lang_id, \config::get( 'limits/top_items' ));
        $new_items          = $this->common->explodeAlias($new_items);
        $new_items_         = $this->common->getGroups1( $this->lang_id, $new_items );
        $pages_top_items    = $total_top_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_top_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_top_items['0']['total']/\config::get( 'limits/top_items' ) )+1);
        $total_new_items    = $this->models->getItems()->getTotalNewItems();
        $pages_new_items    =  $total_new_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_new_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_new_items['0']['total']/\config::get( 'limits/top_items' ) )+1);

        if($users_group_name != \config::get('frontend#defaults/default_users_group')) {
            $recommended_items = $this->models->getItems()->getRecommendedGroupsByUsersGroup($this->lang_id, $users_group_name);
            $total_recommended_items = $this->models->getItems()->getTotalRecommendedItemsByUsersGroup($users_group_name);
        } else {
            $recommended_items = $this->models->getItems()->getRecommendedGroups($this->lang_id, \config::get( 'limits/top_items' ));
            $total_recommended_items = $this->models->getItems()->getTotalRecommendedItems();
        }

        $recommended_items          = $this->common->explodeAlias($recommended_items);
        $recommended_items_         = $this->common->getGroups1( $this->lang_id, $recommended_items );

        $pages_recommended_items    = $total_recommended_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_recommended_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_recommended_items['0']['total']/\config::get( 'limits/top_items' ) )+1);
        $stock_items        = $this->models->getItems()->getStockGroups($this->lang_id, \config::get( 'limits/top_items' ));
        $stock_items        = $this->common->explodeAlias($stock_items);
        $stock_items_       = $this->common->getGroups1( $this->lang_id, $stock_items );
        $total_stock_items  = $this->models->getItems()->getTotalStockItems();
        $pages_stock_items  = $total_stock_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_stock_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_stock_items['0']['total']/\config::get( 'limits/top_items' ) )+1);

        $this->view->setVars([
            'top_items' => $top_items_,
            'new_items' => $new_items_,
            'recommended_items' => $recommended_items_,
            'stock_items' => $stock_items_,
            'pages_top_items' => $pages_top_items,
            'pages_new_items' => $pages_new_items,
            'pages_recommended_items' => $pages_recommended_items,
            'pages_stock_items' => $pages_stock_items,
        ]);

        $lang_url = $this->seoUrl->getChangeLangUrl();
        $in_cart        = $this->session->get('in_cart', []);

        $this->session->set( 'return_url', 'basket' ); // для redirect после авторизации на соц сетях

        $items          = [];
        $total_price    = 0;
        $err            = 0;

        $special_users_id = $this->session->get('special_users_id');

        $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
        $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id);


        if ( !empty( $in_cart ) )
        {
            $cart = $this->common->getCartItems($in_cart, $this->lang_id, $special_user);

            $items = $cart['items'];

            $total_price = $cart['total_price'];
        }

        $static_page_alias = '/basket'. $this->lang_name;
        $meta_title         = 'Кошик | '.\config::get( 'global#title' );

        $actions = $this->models->getActions()->getAllInfo();
        $action_id = 1;
        $action_discount = $this->models->getActions()->getActionDiscountByActionId($action_id);

        $preorders = $this->models->getPreOrders()->getPreOrderByCustomerId($this->session->get('id'));
        if(!empty($preorders)) {
            $preorder = $this->models->getPreOrders()->getPreOrdersByPreOrderId($preorders[0]['id'], $this->lang_id);
        }
        $total_preorder_price = 0;

        if(!empty($preorder)) {
            $item_ids = $this->common->array_column($preorder, 'item_id');
            $preorder_items = $this->models->getItems()->getItemsByIds($this->lang_id, $item_ids);

            for($i = 0; $i < count($preorder_items); $i++) {
                $preorder_items[$i]['prices'] = $this->common->getPricesArray($preorder_items[$i]);
            }

            foreach ($preorder_items as $k => $p) {
                $preorder_items[$k]['cover'] = !empty($p['group_cover']) ? $this->storage->getPhotoUrl($p['item_cover'], 'avatar', '128x') : '/images/packet.jpg';
                $preorder_items[$k]['total_price'] = round($preorder[$k]['item_count'] * $p['price2'], 1);




                $preorder_items[$k]['count'] = $preorder[$k]['item_count'];
                $total_preorder_price += $preorder[$k]['item_count'] * $p['price2'];
            }

            $total_preorder_price = round($total_preorder_price, 1);
        }

        $stock_availability =  \config::get( 'frontend#stock_availability' );

        $this->view->setVars([
            'change_lang_url'    => $lang_url,
            'items'              => $items,
            'preorder_items'     => !empty($preorder_items) ? $preorder_items : [],
            'total_price'        => $total_price,
            'static_page_alias'  => $static_page_alias,
            'meta_title'         => $meta_title,
            'no_robots'          => 1,
            'actions'            => $actions,
            'action_discount'    => $action_discount,
            'total_preorder_price'=> $total_preorder_price,
            'special_users'     => $special_users,
            'special_user'      => $special_user,
            'stock_availability' => $stock_availability
        ]);
    }

    public function emailSettingsAction()
    {

        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }

        $customer   = $this->models->getCustomers()->getCustomer( $this->session->get('id') );
        $orders     = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );
        $emailSettings     = $this->models->getEmailSettings()->getSettings( $this->session->get('id') );


        if( $this->request->isPost() )
        {
            $email_settings['delivery_status'] = $this->request->getPost('delivery_status', 'int',0);
            $email_settings['section_one']     = $this->request->getPost('section_one', 'int',0);
            $email_settings['section_two']     = $this->request->getPost('section_two', 'int',0);
            $email_settings['section_three']   = $this->request->getPost('section_three', 'int',0);
            $email_settings['section_four']    = $this->request->getPost('section_four', 'int',0);
            $email_settings['section_five']    = $this->request->getPost('section_five', 'int',0);
            $email_settings['section_six']     = $this->request->getPost('section_six', 'int',0);
            $email_settings['events']          = $this->request->getPost('events', 'int',0);
            $email_settings['novelty']         = $this->request->getPost('novelty', 'int',0);
            $email_settings['materials']       = $this->request->getPost('materials', 'int',0);
            $email_settings['user_id']         = $this->session->get('id');
            $email_settings['frequency']       = $this->request->getPost('frequency', 'string');
            $email_settings['confirm_key']     = md5( $customer[0]['email'].'just_sum_text' );
            $email_settings['cancel_reason']   = '';

            if($emailSettings){
                $this->models->getEmailSettings()->updateData( $email_settings );
            }else {
                $this->models->getEmailSettings()->addData( $email_settings );
            }
        }

        $this->view->setVars([
            'email_settings'      => $emailSettings[0],
            'orders'        => $orders
        ]);
    }

    public function equipmentAction() {

        $meta_title =
            [
                '1' => 'Професійне насіння | Кабінет | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена | Кабинет | Интернет магазин семян Semena.in.ua'
            ];

        $ids =  \config::get( 'equipment' );
        $sort = [6];
        $page = 1;
        $equipment = $this->models->getItems()->getGroupsByCatalogId($this->lang_id, $ids[1], $page, $sort);
        $equipment = $this->common->explodeAlias($equipment);
        $equipment_ = $this->common->getGroups1($this->lang_id, $equipment);
        $total_equipment = count($equipment_);

        $this->view->pick('dealer/items');

        $this->view->setVars([
            'meta_title' => $meta_title[$this->lang_id],
            'items' => $equipment_,
            'total_items' => $total_equipment,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : ''
        ]);
    }

    public function personalDataAction() {
        $special_users = $this->models->getSpecialUsers()->getOneDataByLang($this->session->get('special_users_id'), $this->lang_id);
        $next_special_users = $this->models->getSpecialUsers()->getOneDataByStatus($special_users[0]['status'] + 1, $this->lang_id);

        $users_groups = $this->models->getUsersGroup()->getAllDataWithGoods($this->lang_id);

        foreach($users_groups as $users_group) {
            if ($this->session->get('users_group_id') == $users_group['users_groups_id']) {
                $recommended['goods'] = $users_group['goods_description'];
                $recommended['id'] = $users_group['users_groups_id'];
            }
        }

        $this->view->setVars([
            'special_users' => $special_users[0],
            'next_special_users' => $next_special_users,
            'users_groups' => $users_groups,
            'recommended' => !empty($recommended)? $recommended : null
        ]);
    }

    public function shipmentHistoryAction() {
        $this->view->pick('dealer/onlineOrderHistory');
    }

    public function onlineOrderHistoryAction() {
        //in init function of ControllerBase
    }

    public function singleOrderAction($order_id) {
        $this->getOrder($order_id);
    }

    public function printOrderAction($order_id) {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->getOrder($order_id);
    }

    public function wholesalePricesAction() {
        $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id);
        $status = $this->models->getSpecialUsers()->getOneData($this->session->get('special_users_id'), $this->lang_id)[0]['status'];
        $this->view->setVars([
            'special_users' => $special_users,
            'status' => $status
        ]);
    }

    public function priceListAction() {
        $prices = $this->models->getPrices()->getAllData($this->lang_id);
        foreach($prices as $key => $value) {
            $prices[$key]['update_date'] = date('d', strtotime($value['update_date'])).'.'.
                date('m', strtotime($value['update_date'])).'.'.
                date('Y', strtotime($value['update_date']));
            $prices[$key]['file'] = $this->storage->getPriceURL($value['file'], 'prices', 'price');
        }
        $this->view->setVar('prices', $prices);
    }

    public function helpAction() {
        if($this->request->isPost()) {
            $idea = $this->request->getPost('idea_text');
            $this->models->getCustomerIdeas()->addIdea(['idea_text' => trim($idea), 'customer_id' => $this->session->get('id')]);
        }
        $special_users = $this->models->getSpecialUsers()->getOneDataByLang($this->session->get('special_users_id'), $this->lang_id);
        $this->view->setVar('special_users', $special_users[0]);
    }

    public function itemAction($type, $subtype, $group_alias, $item_id) {
        $looked         = $this->session->get('looking_items', []);
        $looked[]       = $item_id;
        $looked         = array_unique( $looked );
        $looked         = array_reverse( $looked );
        $looked         = array_chunk( $looked, 5 );
        $this->session->set( 'looking_items', array_reverse($looked['0']) );

        $params         = $this->dispatcher->getParams();
        $type = $params['type'];
        $subtype = $params['subtype'];
        $group_alias = $params['group_alias'];
        $item_id = $params['item_id'];

        $lang_url = $this->seoUrl->getChangeLangUrl(array($type,$subtype,$group_alias));

        if( strpos( $params['type'], '--' ) )
        {
            $type               = mb_substr( $params['type'], 0, strpos( $params['type'], '--' ) );
            $type_child         = trim( mb_substr( $params['type'], strpos( $params['type'], '--' ) ), '-' );
            $catalog_elements[] = $type;
            $catalog_elements[] = $type_child;
        }
        else
        {
            $type = $params['type'];
            $catalog_elements[] = $type;
        }

        $catalog_elements[] = $subtype;

        if( !empty( $type_child ) )
        {
            $type_alias     = $type.'--'.$type_child;

        }
        else
        {
            $type_alias     = $type;
        }

        $subtype_alias              = $subtype;
        $params['type_alias']       = $type_alias;
        $params['subtype_alias']    = $subtype_alias;


        $catalog        = $this->common->getTypeSubtype1( $catalog_elements, $this->lang_id );

        $catalog_id     = empty( $type_child ) ? $catalog['catalog']['sub']['id'] : $catalog['catalog']['sub']['sub']['id'];

        $item           = $this->models->getItems()->getOneItem( $this->lang_id, $item_id );

        if( !empty( $item ) ) {
            $properties = $this->models->getProperties()->getPropertiesByItemId($this->lang_id, $item_id);
            $filters = $this->models->getFilters()->getFiltersByItemId($this->lang_id, $item_id);
            $colors_info = $this->models->getItems()->getColorsInfoByColorId($this->lang_id, $item['0']['color_id']);

            $item['0']['color_title'] = NULL;
            $item['0']['absolute_color'] = NULL;

            if (!empty($colors_info)) {
                $item['0']['color_title'] = $colors_info['0']['color_title'];
                $item['0']['absolute_color'] = $colors_info['0']['absolute_color'];
            }

            $item['0']['images'] = $this->etc->int2arr($item['0']['photogallery']);

            if (!empty($properties['0']['value_value'])) {
                $properties['0']['value_value'] = nl2br($properties['0']['value_value']);
            }

            foreach ($filters as $f) {
                if ($f['key_value'] == $this->languages->getTranslation()->_("producer")) {
                    $item['0']['brand'] = $f['value_value'];
                }
            }

            $sizes = $this->models->getItems()->getSizesByGroupId($this->lang_id, $item['0']['group_id']);
            $sizes_colors = [];
            $sizes_colors__ = [];

            foreach ($sizes as $k => &$s) {
                $s['link'] = $this->url->get(['for' => 'item', 'type' => $type_alias, 'subtype' => $subtype_alias, 'group_alias' => $group_alias, 'item_id' => $s['id']]);
                $s['image'] = !empty($s['cover']) ? $this->storage->getPhotoUrl($s['cover'], 'avatar', 'color') : '';

                if (!empty($s['color_id'])) {
                    $sizes_colors['sizes'][] = $s['size'];
                    $sizes_colors['colors'][] = $s['color_id'];
                    $sizes_colors__[$s['color_id']][$s['size']] = $s;

                }
            }

            if (!empty($sizes_colors['sizes'])) {
                $sizes_colors['sizes'] = array_unique($sizes_colors['sizes']);
            }
            if (!empty($sizes_colors['sizes'])) {
                $sizes_colors['colors'] = array_unique($sizes_colors['colors']);
            }

            // get news

            $news = $this->models->getNews()->getNewsByGroupId($this->lang_id, $item['0']['group_id']);

            foreach ($news as $k => $n) {
                $news[$k]['image'] = !empty($n['cover']) ? $this->storage->getPhotoUrl($n['cover'], 'news', '180x120') : '';
                $news[$k]['link'] = $this->url->get(['for' => 'one_news', 'news_id' => $n['id'], 'news_alias' => $n['alias']]);
            }



            $seo = $this->seoUrl->getSeoData($this->models->getSeoInfo()->getAllSeo());
            $catalog_name = '';

            $meta_title =
                [
                    '1' => isset($seo['title']) && !empty($seo['title']) ? $seo['title'] : $catalog_name . ' ' . $item['0']['title'] . ' в Києві | Купити ' . $catalog_name . ' ' . $item['0']['title'] . ' ціна оптом Львів | Інтернет магазин насіння Semena.in.ua',
                    '2' => isset($seo['title']) && !empty($seo['title']) ? $seo['title'] : $catalog_name . ' ' . $item['0']['title'] . ' в Киеве | Купить ' . $catalog_name . ' ' . $item['0']['title'] . ' цена оптом Львов | Интернет магазин семян Semena.in.ua',
                ];

            $meta_description =
                [
                    '1' => isset($seo['description']) && !empty($seo['description']) ? $seo['description'] : 'Професіонали рекомендують ' . $catalog_name . ' ' . $item['0']['title'] . ' в інтернет магазині насіння Semena.in.ua.',
                    '2' => isset($seo['description']) && !empty($seo['description']) ? $seo['description'] : 'Профессионалы рекомендуют ' . $catalog_name . ' ' . $item['0']['title'] . ' в интернет магазине семян Semena.in.ua.'
                ];
            $recommended_items = $this->models->getItems()->getRecommendedGroups($this->lang_id, \config::get( 'limits/top_items' ));
            $recommended_items = $this->common->explodeAlias($recommended_items);
            $popular_groups_ = $this->common->getGroups1($this->lang_id, $recommended_items);

            if($this->session->get('special_users_id') != null) {
                $special_users_id = $this->session->get('special_users_id');
                $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
            }


            if(isset($special_user)){
                foreach($popular_groups_ as $k => $popular_groups){

                    foreach($popular_groups['items'] as $i => $popular_group){

                        $popular_groups_[$k]['price'] = number_format($popular_groups_[$k]['items'][0]['prices'][$special_user['status']], 2, '.', '' );

                    }

                }
            }


            $special_users_id = $this->session->get('special_users_id');

            $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
            $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id);

            $item[0]['prices'] = $this->common->getPricesArray($item[0]);

            $stock_availability =  \config::get( 'frontend#stock_availability' );

            $this->view->setVars([
                'change_lang_url'   => $lang_url,
                'catalog'           => $catalog,
                'item'              => $item['0'],
                'group_alias'       => $group_alias,
                'item_id'           => $item_id,
                'properties'        => $properties,
                'filters'           => $filters,
                'sizes'             => $sizes,
                'sizes_colors'      => $sizes_colors,
                'sizes_colors__'    => $sizes_colors__,
                'seo'               => $seo,
                'news'              => $news,
                'meta_title'        => $meta_title[$this->lang_id],
                'meta_description'  => $meta_description[$this->lang_id],
                'catalog_id'        => $catalog_id,
                'group_id'          => $item[0]['group_id'],
                'type_alias'                => $type_alias,
                'subtype_alias'             => $subtype_alias,
                'special_users'     => $special_users,
                'special_user'      => $special_user,
                'popular_groups'    => $popular_groups_,
                'stock_availability' => $stock_availability
            ]);
        }
        else
        {
            $this->dispatcher->forward([
                'controller'    => 'page',
                'action'        => 'error404'
            ]);
        }
    }

    public function deletePreOrderItemAction() {
        $this->view->disable();
        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id = $this->request->getPost( 'item_id', 'int', '' );
            $this->models->getPreOrders()->removePreOrderItem($item_id);
        }
    }

    public function catalogAction($type, $subtype, $sort = 0, $page = '') {

        $seo = $this->seoUrl->getSeoData($this->models->getSeoInfo()->getAllSeo());
        $params         = $this->dispatcher->getParams();
        $subtype        = $params['subtype'];
        $page           = !empty( $params['page']  ) ? $params['page']                  : 1;
        $sort           = !empty( $params['sort']  ) ? explode( '-', $params['sort'] )  : [0,3];
        sort($sort);
        $type_child     = NULL;

        $lang_url = $this->seoUrl->getChangeLangUrl(array($type,$subtype));

        if( strpos( $params['type'], '--' ) )
        {
            $type               = mb_substr( $params['type'], 0, strpos( $params['type'], '--' ) );
            $type_child         = trim( mb_substr( $params['type'], strpos( $params['type'], '--' ) ), '-' );
            $catalog_elements[] = $type;
            $catalog_elements[] = $type_child;
        }
        else
        {
            $type = $params['type'];
            $catalog_elements[] = $type;
        }

        $catalog_elements[] = $subtype;

        if( !empty( $type_child ) )
        {
            $type_alias     = $type.'--'.$type_child;
        }
        else
        {
            $type_alias     = $type;
        }

        $subtype_alias              = $subtype;
        $params['type_alias']       = $type_alias;
        $params['subtype_alias']    = $subtype_alias;

        $catalog        = $this->common->getTypeSubtype1( $catalog_elements, $this->lang_id );

        $breadcrumbs    = $this->common->buildBreadcrumbs( $catalog );

        if( !empty( $catalog ) )
        {
            $current_url    = empty( $type_child ) ? $catalog['catalog']['sub']['alias'] : $catalog['catalog']['sub']['sub']['alias'];
            $catalog_id    = $catalog['catalog']['sub']['id'] = empty( $type_child ) ? $catalog['catalog']['sub']['id'] : $catalog['catalog']['sub']['sub']['id'];

            $sort_default_1 = 0;
            $sort_default_2 = 3;

            if( !empty( $sort ) )
            {
                if( count( $sort ) == 1 )
                {
                    if( in_array($sort, [0,1,3]) )
                    {
                        $sort_default_1 = $sort['0'];
                    }
                    else
                    {
                        $sort_default_2 = $sort['0'];
                    }
                }
                elseif( count( $sort ) == 2 )
                {
                    $sort_default_1 = $sort['0'];
                    $sort_default_2 = $sort['1'];
                }
            }

            $current_url_without_price = $current_url.'/';

            $filters_ = $this->models->getFilters()->getFiltersWithCatalogId( $this->lang_id, $catalog_id );

            $filters            = [];
            $filters_with_urls  = [];

            if( !empty( $filters_ ) )
            {
                $filters_with_urls = $this->common->seo_important( $filters_, [], $current_url, NULL, $sort );

                foreach( $filters_with_urls as &$f )
                {
                    $f['options_']          = !empty( $f['options'] ) ? $this->etc->hstore2arr($f['options']) : '';
                    $f['is_seo_important']  = !empty( $f['options'] ) ? $f['options_']['is_seo_important'] : '';

                    unset($f['options']);
                    unset($f['options_']);
                    $filters[$f['filter_key_value']][] = $f;
                }
            }

            $limit = ((isset($_GET['all'])) ? 10000 : \config::get( 'limits/dealer_catalog', 5));
            $groups = $this->models->getItems()->getGroupsByCatalogId( $this->lang_id, $catalog_id, $page, $sort, $limit );

            foreach( $groups as $k => $g )
            {
                $groups[$k]['type_alias']      = $type_alias;
                $groups[$k]['subtype_alias']   = $subtype_alias;
            }

            $paginate = '';

            if( !empty( $groups ) )
            {
                $groups_ = $this->common->getGroups1( $this->lang_id, $groups );
            }

            $page_url_for_sort      = $this->common->getUrlForSort( $params, $sort_default_1, $sort_default_2 );
            $max_min_price          = $this->models->getItems()->getMaxMinPriceWithCatalogId( $catalog_id );

            $total                  = $this->models->getItems()->getAllItemsWithCatalogId( $this->lang_id, $catalog_id );

            if($sort[1]>0 && $sort[1]>0) {
                $page_url_for_filter = ['for' => 'dealer_catalog_paged_sort', 'type' => $type_alias, 'subtype' => $subtype_alias, 'page' => $page, 'sort0' => $sort[0], 'sort' => $sort[1]];
            }

            if( $total['0']['items'] > \config::get( 'limits/dealer_catalog') )
            {

                $paginate = $this->common->paginate(
                    [
                        'page'              => $page,
                        'items_per_page'    => ((isset($_GET['all'])) ? 10000 : \config::get( 'limits/dealer_catalog', 5)),
                        'total_items'       => $total['0']['items'],
                        'url_for'           => isset( $page_url_for_filter ) ? $page_url_for_filter : [ 'for' => 'dealer_catalog_paged', 'type' => $type_alias, 'subtype' => $subtype_alias, 'page' => $page ],
                        'index_page'        => 'dealer_catalog'
                    ], true
                );
            }

            $meta_title =
                [
                    '1' => (isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : $catalog['catalog']['title'].' Київ | Купити '.$catalog['catalog']['title'].' поштою оптом Львів | Інтернет магазин насіння Semena.in.ua').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : ''),
                    '2' => (isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : $catalog['catalog']['title'].' Киев | Купить '.$catalog['catalog']['title'].' почте оптом Львов | Интернет магазин семян Semena.in.ua').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : '')
                ];
            $meta_link_next =
                [
                    '1' =>isset($paginate['meta_link_next']) ? $paginate['meta_link_next'] : '',
                    '2' =>isset($paginate['meta_link_next']) ? $paginate['meta_link_next'] : ''
                ];

            $meta_link_prev =
                [
                    '1' =>isset($paginate['meta_link_prev']) ? $paginate['meta_link_prev'] : '',
                    '2' =>isset($paginate['meta_link_prev']) ? $paginate['meta_link_prev'] : ''
                ];
            $meta_description =
                [
                    '1' => (isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] : 'Замовити '.$catalog['catalog']['title'].' у Києві за найкращою ціною. Якість товара підтверджена професіоналами.').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : ''),
                    '2' => (isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] : 'Заказать '.$catalog['catalog']['title'].' в Киеве по лучшей цене. Качество товара подтверждена профессионалами.').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : '')
                ];

            $special_users_id = $this->session->get('special_users_id');

            $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
            $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id, 0);

            $cart = $this->session->get('in_cart');
            if(!empty($cart)) {
                $cart = $this->common->getCartItems($cart, $this->lang_id);
                foreach ($groups_ as $group_key => $item_group) {
                    foreach ($groups_[$group_key]['items'] as $k => $item) {
                        foreach ($cart['items'] as $j => $cart_item)
                            if ($cart_item['id'] == $item['id']) {
                                $cart[$j]['group_id'] = $item['group_id'];
                                $groups_[$group_key]['items'][$k]['count_cart'] = $cart_item['count'];
                                $groups_[$group_key]['in_cart'] = 1;
                            }
                    }
                }
            }

            $stock_availability =  \config::get( 'frontend#stock_availability' );

            $this->view->setVars([
                'change_lang_url'           => $lang_url,
                'seo'                       => $seo,
                'catalog'                   => $catalog['catalog'],
                'breadcrumbs'               => $breadcrumbs,
                'groups'                    => $groups_,
                'filters'                   => $filters,
                'max_min_price'             => $max_min_price['0'],
                'total'                     => $total['0']['items'],
                'page'                      => $page,
                'current_url'               => $current_url,
                'current_url_without_price' => $current_url_without_price,
                'page_url_for_sort'         => $page_url_for_sort,
                'sort_default_1'            => $sort_default_1,
                'sort_default_2'            => $sort_default_2,
                'sort'                      => $sort,
                'filters_with_urls'         => $filters_with_urls,
                'meta_title'                => $meta_title[$this->lang_id],
                'meta_description'          => $meta_description[$this->lang_id],
                'meta_link_next'            => $meta_link_next[1],
                'meta_link_prev'            => $meta_link_prev[1],
                'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '' ,
                'type_alias'                => $type_alias,
                'subtype_alias'             => $subtype_alias,
                'special_users'             => $special_users,
                'special_user'              => $special_user,
                'cart'                      => json_encode(!empty($cart['items']) ? $cart['items'] : null),
                'stock_availability'        => $stock_availability
            ]);
        }
        else
        {
            $this->dispatcher->forward([
                'controller'    => 'page',
                'action'        => 'error404'
            ]);
        }
    }

    public function searchAction($search = '', $page = 1) {

        $search = $this->request->get('search', 'string', NULL );

        $groups = $this->models->getItems()->getGroupsBySearch( $this->lang_id, $search );
        $groups = $this->common->explodeAlias($groups);

        if( !empty( $groups ) )
        {
            $groups_ = $this->common->getGroups1( $this->lang_id, $groups );

        }

        $special_users_id = $this->session->get('special_users_id');

        $cart = $this->session->get('in_cart');
        if(!empty($cart)) {
            $cart = $this->common->getCartItems($cart, $this->lang_id);
            foreach ($groups_ as $group_key => $item_group) {
                foreach ($groups_[$group_key]['items'] as $k => $item) {
                    foreach ($cart['items'] as $j => $cart_item)
                        if ($cart_item['id'] == $item['id']) {
                            $cart[$j]['group_id'] = $item['group_id'];
                            $groups_[$group_key]['items'][$k]['count_cart'] = $cart_item['count'];
                            $groups_[$group_key]['in_cart'] = 1;
                        }
                }
            }
        }
        $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
        $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id, 0);
        $stock_availability =  \config::get( 'frontend#stock_availability' );
        $this->view->setVars([
            'groups' => isset($groups_) ? $groups_ : null,
            'total' => count($groups),
            'special_user' => $special_user,
            'special_users' => $special_users,
            'cart'          => json_encode($cart),
            'stock_availability' => $stock_availability
        ]);

        $this->view->pick('dealer/catalog');
    }

    public function filtersAction( $type, $subtype, $filter_ids = '', $filter_alias = '', $price = '', $sort = '', $page = 1 )
    {
        $params         = $this->dispatcher->getParams();
        $type = $params['type'];
        $subtype = $params['subtype'];

        $lang_url = $this->seoUrl->getChangeLangUrl(array($type,$subtype));

        $filter_ids     = isset( $params['filter_ids'] )    && !empty( $params['filter_ids'] )      ? $params['filter_ids']             : '';
        $filter_alias   = isset( $params['filter_alias'] )  && !empty( $params['filter_alias'] )    ? $params['filter_alias']           : '';
        $price          = isset( $params['price'] )         && !empty( $params['price'] )           ? $params['price']                  : '';
        $page           = !empty( $params['page']  )                                                ? $params['page']                   : 1;
        $sort           = !empty( $params['sort']  )                                                ? explode( '-', $params['sort'] )   : [0,3];
        sort($sort);
        $price_array    = !empty( $price ) ? explode( '-', $price ) : [];

        $sort_default_1 = 0;
        $sort_default_2 = 3;

        if( !empty( $sort ) )
        {
            if( count( $sort ) == 1 )
            {
                if( in_array($sort, [0,1,3]) )
                {
                    $sort_default_1 = $sort['0'];
                }
                else
                {
                    $sort_default_2 = $sort['0'];
                }
            }
            elseif( count( $sort ) == 2 )
            {
                $sort_default_1 = $sort['0'];
                $sort_default_2 = $sort['1'];
            }
        }

        if( strpos( $params['type'], '--' ) )
        {
            $type               = mb_substr( $params['type'], 0, strpos( $params['type'], '--' ) );
            $type_child         = trim( mb_substr( $params['type'], strpos( $params['type'], '--' ) ), '-' );
            $catalog_elements[] = $type;
            $catalog_elements[] = $type_child;
        }
        else
        {
            $type = $params['type'];
            $catalog_elements[] = $type;
        }

        $catalog_elements[] = $subtype;

        if( !empty( $type_child ) )
        {
            $type_alias     = $type.'--'.$type_child;

        }
        else
        {
            $type_alias     = $type;
        }

        $subtype_alias              = $subtype;
        $params['type_alias']       = $type_alias;
        $params['subtype_alias']    = $subtype_alias;

        $catalog        = $this->common->getTypeSubtype1( $catalog_elements, $this->lang_id );
        $breadcrumbs    = $this->common->buildBreadcrumbs($catalog);

        $catalog_id     = empty( $type_child ) ? $catalog['catalog']['sub']['id'] : $catalog['catalog']['sub']['sub']['id'];

        $current_url_without_price  = trim('/'.$type_alias.'/'.$subtype_alias.'/'.$filter_ids.$filter_alias, '--');
        $current_url_without_sort   = trim('/'.$type_alias.'/'.$subtype_alias.'/'.trim($filter_ids.$filter_alias.(!empty($price) ? '--price-'.$price : ''), '--') );
        $current_url                = trim('/'.$type_alias.'/'.$subtype_alias.'/'.trim($filter_ids.$filter_alias.(!empty($price) ? '--price-'.$price : ''), '--'), '--').( !empty($sort) ? '/sort-'.join('-', $sort) : '' );

        $filter_ids_                = trim( $filter_ids, '-' );
        $filter_applied_ids_array   = !empty( $filter_ids ) ? explode( '-', $filter_ids_ ) : [];

        $filters_                     = $this->models->getFilters()->getFiltersWithCatalogId( $this->lang_id, $catalog_id, $filter_applied_ids_array );

        $filters                    = [];
        $filters_applied            = [];

        if( !empty( $filters_ ) )
        {
            $url = '/'.$type_alias.'/'.$subtype_alias;

            $filters_with_urls = $this->common->seo_important( $filters_, $filter_applied_ids_array, $url, $price, $sort );

            foreach( $filters_with_urls as &$f )
            {
                $f['options_']          = !empty( $f['options'] ) ? $this->etc->hstore2arr($f['options']) : '';
                $f['is_seo_important']  = !empty( $f['options'] ) ? $f['options_']['is_seo_important'] : '';
                $f['checked']           = in_array( $f['id'], $filter_applied_ids_array ) ? '1' : '';

                unset($f['options']);
                unset($f['options_']);

                $filters[$f['filter_key_value']][] = $f;

                if( in_array( $f['id'], $filter_applied_ids_array ) )
                {
                    $filters_applied[$f['id']] = $f;
                }
            }
        }

        $groups_by_filters = $this->models->getItems()->getGroupsByFiltersWithCatalog( $filter_applied_ids_array, $price_array, $catalog_id );

        $groups_by_key_id = array();
        foreach( $groups_by_filters as $g )
        {
            $groups_by_key_id[$g['key_id']][]   = $g['group_id'];
            $groups_by_key_id[$g['key_id']]     = array_unique($groups_by_key_id[$g['key_id']]);
        }

        sort($groups_by_key_id);
        $result_groups = array();
        if( count( $groups_by_key_id ) > 1 )
        {
            $result_groups = call_user_func_array('array_intersect',$groups_by_key_id);
        }
        elseif(isset($groups_by_key_id['0']))
        {
            $result_groups = $groups_by_key_id['0'];
        }

        $groups_ = [];
        if( !empty( $result_groups ) )
        {
            $groups     = $this->models->getItems()->getResultGroups( $this->lang_id, $result_groups, $filter_applied_ids_array, $price_array, $sort, $page );

            foreach( $groups as $k => $g )
            {
                $groups[$k]['type_alias']      = $type_alias;
                $groups[$k]['subtype_alias']   = $subtype_alias;
            }

            $groups_ = $this->common->getGroups1( $this->lang_id, $groups );
        }

        $total      = count($result_groups);

        $page_url_for_filter = $this->common->getUrlForFilter( $params, $page );
        $page_url_for_sort   = $this->common->getUrlForSort( $params, $sort_default_1, $sort_default_2 );

        $max_min_price       = $this->models->getItems()->getMaxMinPriceWithCatalogId( $catalog_id );

        $paginate = '';

        if( $total > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/items', 5),
                    'total_items'       => $total,
                    'url_for'           => isset( $page_url_for_filter ) ? $page_url_for_filter : [ 'for' => 'catalog_paged', 'type' => $catalog['type_alias'], 'subtype' => $catalog['subtype_alias'], 'page' => $page ],
                    'index_page'       => 'dealer_catalog'
                ], true
            );
        }


        $seo = $this->seoUrl->getSeoData($this->models->getSeoInfo()->getAllSeo());
        $meta_title =
            [
                '1' => (isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : $catalog['catalog']['title'].' Київ | Купити '.$catalog['catalog']['title'].' поштою оптом Львів | Інтернет магазин насіння Semena.in.ua').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : ''),
                '2' => (isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : $catalog['catalog']['title'].' Киев | Купить '.$catalog['catalog']['title'].' почте оптом Львов | Интернет магазин семян Semena.in.ua').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : '')
            ];
        $meta_link_next =
            [
                '1' =>isset($paginate['meta_link_next']) ? $paginate['meta_link_next'] : '',
                '2' =>isset($paginate['meta_link_next']) ? $paginate['meta_link_next'] : ''
            ];

        $meta_link_prev =
            [
                '1' =>isset($paginate['meta_link_prev']) ? $paginate['meta_link_prev'] : '',
                '2' =>isset($paginate['meta_link_prev']) ? $paginate['meta_link_prev'] : ''
            ];
        $meta_description =
            [
                '1' => (isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] : 'Замовити '.$catalog['catalog']['title'].' у Києві за найкращою ціною. Якість товара підтверджена професіоналами.').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : ''),
                '2' => (isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] : 'Заказать '.$catalog['catalog']['title'].' в Киеве по лучшей цене. Качество товара подтверждена профессионалами.').(isset( $page ) && !empty( $page ) && $page != '1' ? ' страница '.$page : '')
            ];

        $this->view->pick('dealer/catalog');

        $special_users_id = $this->session->get('special_users_id');

        $cart = $this->session->get('in_cart');
        if(!empty($cart)) {
            $cart = $this->common->getCartItems($cart, $this->lang_id);
            foreach ($groups_ as $group_key => $item_group) {
                foreach ($groups_[$group_key]['items'] as $k => $item) {
                    foreach ($cart['items'] as $j => $cart_item)
                        if ($cart_item['id'] == $item['id']) {
                            $cart[$j]['group_id'] = $item['group_id'];
                            $groups_[$group_key]['items'][$k]['count_cart'] = $cart_item['count'];
                            $groups_[$group_key]['in_cart'] = 1;
                        }
                }
            }
        }

        $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
        $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id, 0);

        $this->view->setVars([
            'change_lang_url'           => $lang_url,
            'seo'                       => $seo,
            'catalog'                   => $catalog['catalog'],
            'breadcrumbs'               => $breadcrumbs,
            'groups'                    => $groups_,
            'filters'                   => $filters,
            'filters_applied'           => $filters_applied,
            'max_min_price'             => $max_min_price['0'],
            'total'                     => $total,
            'page'                      => $page,
            'current_url_without_price' => $current_url_without_price,
            'current_url_without_sort'  => $current_url_without_sort,
            'current_url'               => $current_url,
            'price_array'               => $price_array,
            'page_url_for_filter'       => $page_url_for_filter,
            'page_url_for_sort'         => $page_url_for_sort,
            'sort_default_1'            => $sort_default_1,
            'sort_default_2'            => $sort_default_2,
            'sort'                      => $sort,
            'no_robots'                 => 1,
            'minPrice'					=> isset($price_array[0])?$price_array[0]:0,
            'maxPrice'					=> isset($price_array[1])?$price_array[1]:0,
            'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '',
            'type_alias'                => $type_alias,
            'subtype_alias'             => $subtype_alias,
            'meta_title'                => $meta_title[$this->lang_id],
            'meta_description'          => $meta_description[$this->lang_id],
            'meta_link_next'            => $meta_link_next[1],
            'meta_link_prev'            => $meta_link_prev[1],
            'special_user'              => $special_user,
            'special_users'             => $special_users,
            'cart'                      => json_encode($cart)
        ]);
    }

    public function orderAction() {
        $in_cart = $this->session->get('in_cart', []);

        if($this->session->has('action_id')) {
            $firm_total = $this->session->get('firm_total');
            $this->view->setVar('firm_total', $firm_total);
        }

        $items = [];
        $total_price = 0;
        $err = 0;
        $special_users_id = $this->session->get('special_users_id');

        $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];

        if ( !empty( $in_cart ) )
        {
            $cart = $this->common->getCartItems($in_cart, $this->lang_id, $special_user);
            $items = $cart['items'];
            $total_price = $cart['total_price'];
            $items_ = $cart['items_'];
        }

        if($this->request->isPost()) {

            if($this->session->has('action_id')) {
                $action_id = $this->session->get('action_id');
                $this->session->remove('action_id');
                $this->session->remove('firm_total');
            }

            $order['name'] = $this->request->getPost('order_name', 'string', NULL);
            $order['phone'] = $this->request->getPost('order_phone', 'string', NULL);
            $order['delivery'] = $this->request->getPost('order_delivery', 'string', NULL);
            $order['pay'] = $this->request->getPost('order_pay', 'string', NULL);

            foreach( $items_ as $key => $val )
            {
                $items_[$key]['is'] = ($val['status'] == 1) ? $this->t->_('in_stock') : $this->t->_('missing');
                $order['items'][] = $items_[$key];

            }

            $order['total_sum'] = round($total_price, 1 );

            $this->session->set( 'in_cart', $in_cart );

            foreach ($order['items'] as $key => $o)
            {
                if (empty($o))
                {
                    $err = 1;
                }
                $order['items'][$key]['cover'] = $this->storage->getPhotoURL($o['item_cover'], 'avatar', '400x');
                $order['items'][$key]['alias'] = $o['catalog_alias'].'/'.$o['group_alias'].'-'.$o['id'];
            }

            // submit order
            if( empty( $err ) )
            {
                $order['city']              =
                    ( $order['delivery'] == 3 || $order['delivery'] == 4 )
                        ?
                        $this->request->getPost('order_city_novaposhta', 'string', NULL )
                        :
                        $this->request->getPost('order_city', 'string', NULL );

                $order['city_ref']          = $this->request->getPost('order_city_ref', 'string', NULL );
                $order['store_address']     = $this->request->getPost('store_address', 'string', NULL );
                $order['store_ref']         = $this->request->getPost('order_store_address_ref', 'string', NULL );

                $address                    = $this->request->getPost('order_address', 'string', NULL );

                $order['address']           = !empty( $address ) ? $address : $order['store_address'];
                $order['email']             = $this->request->getPost('order_email', 'string', NULL );
                $order['email']             = $order['email'] ? $order['email'] : NULL;
                $order_get_info             = $this->request->getPost('order_get_info', 'string', NULL );
                $order['subscribed']        = empty( $order_get_info ) ? 0 : 1;
                $order['comments']          = $this->request->getPost('order_comments', 'string', NULL );
                $passwd_                    = $this->common->generatePasswd(10);
                $order['passwd_']           = $passwd_;
                $order['passwd']            = $this->common->hashPasswd( $passwd_ );

                if(isset($action_id) && isset($firm_total)) {
                    $order['action_id'] = $action_id;
                    $order['firm_total'] = $firm_total;
                }
                // save order
                $proposal_number            = $this->models->getOrders()->addOrder($order);
                $order['proposal_number']   = $proposal_number['proposal_number'];
                $order['confirmed']         = $proposal_number['confirmed'];
                $order['customer_new']      = $proposal_number['new'];

                $sms_text = "Vash zakaz prinyat. #:".$proposal_number['proposal_number']." V blijayshee vremya menedjer svyajetsya s Vami (044) 581-67-15";
                $this->sms->sendSMS($order['phone'], $sms_text);

                // novaposhta
                if (!empty($proposal_number['novaposhta_tnn']))
                {
                    $order['novaposhta_tnn']    = $proposal_number['novaposhta_tnn'];
                }


                if( !empty( $order['email'] ) )
                {
                    $this->sendmail->addCustomer( 1, $order );

                    if( empty( $order['confirmed'] ) && !empty( $order['customer_new'] ) ) // new customer
                    {
                        $this->sendmail->addCustomer( 3, $order );
                    }
                }

                if( !empty( $order['proposal_number'] ) )
                {
                    $this->sendmail->addCustomer( 2, $order );

                    $this->session->set( 'in_cart', []);

                    $this->session->set( 'order_data', array(
                        'oid' => $order['proposal_number'],
                        'pay' => $order['pay'],
                        'amount' => $total_price,
                        'items'=>$items,
                    ));

                    return $this->response->redirect([ 'for' => 'basket_completed', 'language' => $this->lang_name ]);
                }
                else
                {
                    $this->flash->error( $this->t->_("error_send_message") );
                    return $this->response->redirect([ 'for' => 'basket', 'language' => $this->lang_name ]);
                }
            }

        }
    }

    public function financialCalculationsAction() {
        $callback['id']  = $customer_id = $this->session->get('id');

        if( $this->request->isPost() )
        {


            $callback['name']               = $this->request->getPost('name', 'string', NULL );
            $email                          = $this->request->getPost('email', 'string', NULL );
            $callback['date']          		= $this->request->getPost('date', 'string', NULL );
            $callback['phone']          	= $this->request->getPost('phone', 'string', NULL );
            $callback['comments']          	= $this->request->getPost('comments', 'string', NULL );
            $callback['email']              = filter_var( $email, FILTER_VALIDATE_EMAIL );


            if( !empty( $callback['name'] ) && !empty( $callback['date'] ) && ( !empty( $callback['email'] ) || !empty( $callback['phone'] ) ) )
            {
                if( $callback_id = $this->models->getCallback()->addCallback($callback) )
                {
                    $callback['callback_id'] = $callback_id['0']['id'];

                    if( !empty( $callback['email'] ) )
                    {
                        $data = $this->models->getManagerMail()->getData();
                        $this->sendmail->addCustomer( 9, $callback,$data );
                    }


                    setcookie("callback", '1', time()+3600);

                    $this->flash->success($this->languages->getTranslation()->_("please_change_the_password"));
                }
            }
//            else
//            {
//                $this->session->set( 'callback', $callback );
//                $this->flash->error( $this->languages->getTranslation()->_("required_error"));
//                return $this->response->redirect([ 'for' => 'callback_errors', 'language' => $this->lang_name ]);
//            }
        }

        $payment = $this->models->getPayment()->getPaymentByCustomer($customer_id);

        $sum_order = 0;
        $sum_paid = 0;
        foreach ($payment as $val) {
            if($val['amount'] > 0) {
                $sum_order += $val['amount'];
            } else {
                $sum_paid += -$val['amount'];
            }
        }

        $this->view->setVar('payment', $payment);
        $this->view->setVar('sum_order', $sum_order);
        $this->view->setVar('sum_paid', $sum_paid);
    }

    private function getOrder( $order_id ) {
        $items = $this->models->getOrders()->getOrdersByOrderId( $order_id, $this->lang_id );

        $order['groups'] = $this->getGroups($items);
        $order['total_price'] = 0;
        foreach($order['groups'] as $k => $g) {
            foreach ($g['items'] as $key => $value) {
                $order['groups'][$k]['items'][$key]['cover'] = $this->storage->getPhotoURL($value['cover'], 'avatar', '128x');
                $order['groups'][$k]['items'][$key]['alias'] = '/' . $value['type_alias'] . '/' . $value['subtype_alias'] . '/' . $value['group_alias'] . '-' . $value['group_id'];
                $order['total_price'] += $value['price2'] * $value['item_count'];
            }
        }

        $this->view->setVar('order', $order);
        $this->view->setVar('order_id', $order_id);
    }

    private function getGroups($items) {
        $groups = [];
        foreach($items as $i) {
            $title = $this->models->getItems()->getTitleByAlias($this->lang_id, $i['subtype_alias'])[0];
            $hasMatch = false;
            foreach($groups as $k => $g) {
                if($g['title'] == $title['title']) {
                    $hasMatch = true;
                    $groups[$k]['items'][] = $i;
                    break;
                }
            }
            if(!$hasMatch) {
                $title['items'][] = $i;
                $groups[] = $title;
            }
        }

        return $groups;
    }

}