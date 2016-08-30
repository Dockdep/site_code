<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

use Phalcon\Mvc\Dispatcher;

class MenuController extends \controllers\ControllerBase
{

	public function orderAction()
	{
		if($this->session->get('special_users_id') != null) {
			return $this->response->redirect('dealer/cart');
		}

        $lang_url = $this->seoUrl->getChangeLangUrl();
		$in_cart        = $this->session->get('in_cart', []);
		$customer_id    = $this->session->get('id');
		$customer_email = $this->session->get('customer_email');

		$session_promo_code = $this->session->get('promo_code');

		$customer       = !empty( $customer_id ) ? $this->models->getCustomers()->getCustomer( $customer_id ) : [];
		$this->session->set( 'return_url', 'basket' ); // для redirect после авторизации на соц сетях
		
		$items          = [];
		$total_price    = 0;
		$err            = 0;
		
		$cities_ = $this->novaposhta->city();
		
		foreach( $cities_->city as $c )
		{
			$cities[strval($c->id)] = strval($c->nameUkr);
		}

		if ( !empty( $in_cart ) )
		{
			$cart = $this->common->getCartItems($in_cart, $this->lang_id);

			if(!empty($session_promo_code)) {
				if($this->common->applyPromoCode($session_promo_code, $cart['items'])) {
					$this->common->countOrderSum($cart);
					$cart['total_price'] = $cart['total_sum'];
				}
			}
			$total_price = $cart['total_price'];
			$items = $cart['items'];
			$items_ = $cart['items_'];

		}


		if ( $this->request->isPost() )
		{
			$order['email']             = $this->request->getPost('login_email', 'string', NULL );
			$order['passwd']            = $this->request->getPost('login_passwd', 'string', NULL );

			$promo_code 				= $this->request->getPost('promo_code', 'string', NULL );

			if(empty($session_promo_code)) {
				$promo_code = $this->models->getPromoCodes()->getOneDataByCode($promo_code);
			} else {
				$promo_code = [$session_promo_code];
			}

			$order['promo_code']  		= !empty($promo_code) ? $promo_code[0]['code'] : null;

			$order_items                = $this->request->getPost('count_items', NULL, [] );
			$order_color                = $this->request->getPost('color', NULL, [] );
			$order_size                = $this->request->getPost('size', NULL, [] );
			$order_is                = $this->request->getPost('is', NULL, [] );
			$order['total_sum']         = 0;

			foreach( $order_items as $key => $val )
			{
				$items_[$key]['count']          = $val;
				$items_[$key]['total_price']    = round($val*$items_[$key]['price2'], 1);

				if(isset($order_color[$key]))
					$items_[$key]['color']               = $order_color[$key];

				$items_[$key]['size']               = $order_size[$key];
				$items_[$key]['is']               = $order_is[$key];
				
				$order['items'][]               = $items_[$key];
				$order['total_sum']             += $items_[$key]['total_price'];
				
				
				$item_id_in_cart                = $this->common->array_column( $in_cart, 'item_id' );
				
				if( in_array( $key, $item_id_in_cart ) )
				{
					foreach( $in_cart as &$c )
					{
						if( $c['item_id'] == $key )
						{
							$c['count_items'] = $val;
						}
					}
				}
			}

			$order['total_sum']             = round( $order['total_sum'], 1 );
			
			$this->session->set( 'in_cart', $in_cart );
			if ( !empty( $order['email'] ) && !empty( $order['passwd'] ) )
			{

				$order['passwd'] = $this->common->hashPasswd( $order['passwd'] );
				switch( $this->models->getCustomers()->customerLogin( $order ) )
				{
					case 1:
						// OK
						// redirect
						$this->session->set( 'customer_email',  NULL );
						$this->session->remove('customer_email');
						return $this->response->redirect([ 'for' => 'basket', 'language' => $this->lang_name ]);
					case -1:
						$this->flash->error($this->languages->getTranslation()->_("incorrect_login_or_password"));
						$this->session->set( 'customer_email', $order['email'] );
						return $this->response->redirect([ 'for' => 'basket', 'language' => $this->lang_name ]);
					case 2: // user with status 0
					default:
						$this->flash->success($this->languages->getTranslation()->_("please_change_the_password"));
						$this->session->set( 'customer_email', $order['email'] );
						return $this->response->redirect([ 'for' => 'finish_registration', 'language' => $this->lang_name ]);
						
					
				}
			}
			
			unset($order['email']);
			unset($order['passwd']);
			
			$order['name']              = $this->request->getPost('order_name', 'string', NULL );
			$order['phone']             = $this->request->getPost('order_phone', 'string', NULL );
			$order['delivery']          = $this->request->getPost('order_delivery', 'string', NULL );
			$order['pay']               = $this->request->getPost('order_pay', 'string', NULL );
			
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

				// save order
				$proposal_number            = $this->models->getOrders()->addOrder($order);
				$order['proposal_number']   = $proposal_number['proposal_number'];
				$order['confirmed']         = $proposal_number['confirmed'];
				$order['customer_new']      = $proposal_number['new'];
				
				$sms_text = "Vash zakaz prinyat. #:".$proposal_number['proposal_number']." V blijayshee vremya menedjer svyajetsya s Vami (044) 581-67-15";
				$this->sms->sendSMS($order['phone'], $sms_text);

				if(!empty($promo_code)) {
					if($this->common->applyPromoCode($promo_code[0], $order['items']))
						$this->common->countOrderSum($order);
				}

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

					$this->session->remove('promo_code');
					
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
					$this->flash->error( $this->languages->getTranslation()->_("error_send_message") );
					return $this->response->redirect([ 'for' => 'basket', 'language' => $this->lang_name ]);
				}
			}

		}
		
		$static_page_alias = '/basket'. $this->lang_name;
		$meta_title         = 'Кошик | '.\config::get( 'global#title' );

		$this->view->setVars([
            'change_lang_url'   => $lang_url,
			'items'              => $items,
			'total_price'        => $total_price,
			'static_page_alias'  => $static_page_alias,
			'meta_title'         => $meta_title,
			'customer'           => !empty($customer['0']) ? $customer['0'] : '' ,
			'customer_email'     => $customer_email,
			'cities'             => $cities,
			'no_robots'          => 1,
			'promo_code'		 => $session_promo_code
		]);
	}

	
	public function orderCompletedAction() {
		$completed = $this->languages->getTranslation()->_("successfully_realized_order");
		
		// order data
		if ($data = $this->session->get('order_data'))
		{
			// type / liqpay
			if ($data['pay'] == 2)
			{
				$completed = '';
				
				$result = $this->liqpay->api("payment/status", array('order_id' => $data['oid']));
				if (!empty($result->status) && $result->status == 'success')
				{
					setcookie("order", '1', time()+3600);
					$this->session->remove('order_data');
					return $this->response->redirect([ 'for' => 'homepage' , 'language' => $this->lang_name ]);
				}
				else
				{
					$liqpay = $this->liqpay->cnb_form(array(
						'amount'      => $data['amount'],
						'currency'    => 'UAH',
						'description' => 'Оплата заказа №' . $data['oid'] . ' | ' . \config::get( 'global#domains/www' ),
						'order_id'    => $data['oid'],
						'return_url'  => 'http://semena.dev.artwebua.com.ua/basket/completed',
						'language'    => 'ru',
						'type'        => 'buy'
					));
				}
			}

		}
		else
		{
			$this->dispatcher->forward([
				'controller' => 'page',
				'action'     => 'error404'
			]);
		}
		
		// vars
		$this->lang_id = 1;
		$static_page_alias = '/basket/completed';
		$meta_title = 'Кошик | '.\config::get( 'global#title' );
		
		// output
		$this->view->setVars([
			'data'=>$data,
			'static_page_alias' => $static_page_alias,
			'completed' => sprintf($completed,$data['oid']),
			'liqpay' => !empty($liqpay) ? $liqpay : '' ,
			'meta_title' => $meta_title,
			'no_robots' => 1
		]);
	}


    public function getCitiesAction( )
    {
        header('Content-Type: application/json; charset=utf8');

        $term       = $this->request->getPost('term', 'string', '' );
        $length     = strlen($term);
        $cities_    = $this->novaposhta->city();

        foreach( $cities_->city as $c )
        {
            $cities[strval($c->id)] = strval($c->nameUkr);

            if( mb_strtolower( substr( strval($c->nameUkr), 0, $length ), 'utf-8' ) == mb_strtolower( $term, 'utf-8' ) )
            {
                $selected_cities[] =
                    [
                        'label' => strval($c->nameUkr),
                        'value' => strval($c->nameUkr),
                        'id'    => strval($c->id),
                        'ref'   => strval($c->ref)
                    ];
            }
        }

        die( json_encode( $selected_cities ) );
    }


    public function getOfficesAction( )
    {
        header('Content-Type: application/json; charset=utf8');

        $city       = $this->request->getPost('city', 'string', '' );
        $offices_   = $this->novaposhta->warenhouse( $city );

        foreach( $offices_->warenhouse as $c )
        {
            $offices[] =
                [
                    'number'    => strval($c->number),
                    'address'   => strval($c->address),
                    'store_ref' => strval($c->ref)
                ];
        }

        die( json_encode( $offices ) );
    }


	public function addProductBasketAction(){
		$item_id        = $_GET['productID'];
		$count_items    = $_GET['productCount'];
		$in_cart[]       =
			[
				'item_id'       => $item_id,
				'count_items'   => $count_items
			];
		$this->session->set( 'in_cart', $in_cart );
		return $this->response->redirect([ 'for' => 'basket']);
	}

	public function getCartItemsAction() {
		$this->view->disable();

		$in_cart = $this->session->get('in_cart', []);



		$cart_items = $this->common->getCartItems($in_cart, $this->lang_id);



		if($this->session->get('special_users_id') != null) {
			$special_users_id = $this->session->get('special_users_id');
			$special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
		}

		foreach($cart_items['items'] as $k => $item) {

			$cart_items['items'][$k]['group_sizes'] = $this->models->getItems()->getSizesByGroupId( $this->lang_id, $item['group_id'] );
			$cart_items['items'][$k]['prices'] = $this->common->getPricesArray($item);

            $cart_items['new_total_price'] = 0;

			if(isset($special_user)) {
				$cart_items['items'][$k]['price'] = number_format(
					isset($cart_items['items'][$k]['prices'][$special_user['status']])
					? $cart_items['items'][$k]['prices'][$special_user['status']]
					: $item['price2'], 2, '.', ''
				);

				$cart_items['items'][$k]['total_price'] = $cart_items['items'][$k]['price'] * $item['count'];

                $cart_items['new_total_price'] += $cart_items['items'][$k]['total_price'];

                $cart_items['total_price'] = $cart_items['new_total_price'];

			} else {
				$cart_items['items'][$k]['price'] = $item['price2'];
			}
		}

		echo json_encode($cart_items);
	}


	public function addToBasketAction()
    {
        $count = 0;

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id        = $this->request->getPost( 'item_id', 'int', '' );
            $count_items    = $this->request->getPost( 'count_items', 'int', '' );

            $in_cart         = $this->session->get('in_cart', []);
            $item_id_in_cart = $this->common->array_column( $in_cart, 'item_id' );

            if( in_array( $item_id, $item_id_in_cart ) )
            {
                die( json_encode( 0 ) );
            }

            $in_cart[]       =
                [
                    'item_id'       => $item_id,
                    'count_items'   => $count_items
                ];
            $this->session->set( 'in_cart', $in_cart );

            $count = count($in_cart);
        }

        die( json_encode( $count ) );
    }

    ///////////////////////////////////////////////////////////////////////////

    public function deleteFromBasketAction()
    {
        $count = 0;

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id = $this->request->getPost( 'item_id', 'int', '' );
            $in_cart = $this->session->get('in_cart', []);

            foreach( $in_cart as $key => $value )
            {
                if( $value['item_id'] == $item_id )
                {
                    unset( $in_cart[$key] );
                }
            }

            $this->session->set( 'in_cart', $in_cart );

            $count = count($in_cart);
        }

        die( json_encode( $count ) );
    }

    ///////////////////////////////////////////////////////////////////////////

    public function changeCountBasketAction()
    {
        $count = 0;

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id        = $this->request->getPost( 'item_id', 'int', '' );
            $count_items    = $this->request->getPost( 'count_items', 'int', '' );
            $in_cart         = $this->session->get('in_cart', []);

            foreach( $in_cart as $k => $v )
            {
                if( $v['item_id'] == $item_id )
                {
					$in_cart[$k]['count_items'] = $count_items;
                }
            }

            $this->session->set( 'in_cart', $in_cart );
		}

        die( json_encode( $in_cart ) );
    }

    ///////////////////////////////////////////////////////////////////////////

    public function staticPageAction(  )
    {
		$params = $this->dispatcher->getParams();
        $page_id = $params['page_id'];

        $lang_url = $this->seoUrl->getChangeLangUrl();

        $page = $this->models->getPages()->getPage( $page_id, $this->lang_id );

        if( !empty( $page ) )
        {
            $meta_title         = $page['0']['meta_title'];
            $meta_keywords      = $page['0']['meta_keywords'];
            $meta_description   = $page['0']['meta_description'];
            $this->view->setVars([
                'change_lang_url'   => $lang_url,
                'page' => $page['0'],
                'meta_title'        => $meta_title,
                'meta_keywords'     => $meta_keywords,
                'meta_description'  => $meta_description,
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

    ///////////////////////////////////////////////////////////////////////////

    public function newsAction()
    {
		$meta_title =
			[
				'1' => 'Новини та акції | Інтернет магазин насіння Semena.in.ua',
				'2' => 'Новости и акции | Интернет магазин семян Semena.in.ua'
			];

		$meta_description =
			[
				'1' => 'Останні новини та актуальні акції інтернет магазину насіння Semena.in.ua',
				'2' => 'Последние новости и актуальные акции интернет магазина семян Semena.in.ua'
			];

		$css = [
			'https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic',
			'/landing_sales/animation.css',
			'/landing_sales/style.css'
		];

		$js = [
			'/landing_sales/script.js'
		];

		$lang_url = $this->seoUrl->getChangeLangUrl();

		$active_sales = $this->models->getSales()->getActiveSales($this->lang_id);
		$future_sales = $this->models->getSales()->getFutureSales($this->lang_id);
		$recent_sales = array_merge($active_sales, $future_sales);

		foreach( $recent_sales as $k => $n )
		{
			$recent_sales[$k]['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $n['id'], 'news_alias' => $n['alias'] ]);
		}

		$active_seasonal = $this->models->getSales()->getActiveSeasonalSales($this->lang_id);
		$future_seasonal = $this->models->getSales()->getFutureSeasonalSales($this->lang_id);

		$seasonal_sales = array_merge($active_seasonal, $future_seasonal);

		foreach( $seasonal_sales as $k => $n )
		{
			$seasonal_sales[$k]['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $n['id'], 'news_alias' => $n['alias'] ]);
		}

		$reviews = $this->models->getReviews()->getActiveReviews();

		$this->view->setVars([
			'css' => $css,
			'js' => $js,
			'change_lang_url' => $lang_url,
			'meta_title' => $meta_title[$this->lang_id],
			'meta_description' => $meta_description[$this->lang_id],
			'classic_sales' => $recent_sales,
			'seasonal_sales' => $seasonal_sales,
			'reviews' => $reviews
		]);

		$this->view->pick('menu/sales');

		/*
		$lang_url = $this->seoUrl->getChangeLangUrl();
        $params = $this->dispatcher->getParams();
        $page = isset($params['page']) && !empty($params['page']) ? $params['page'] : 1;

        $this->lang_id = $this->seoUrl->getLangId();
        $news = $this->models->getNews()->getNews( $this->lang_id, $page );

        foreach( $news as $k => $n )
        {
            $news[$k]['image']  = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '180x120' ) : '';
            $news[$k]['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $n['id'], 'news_alias' => $n['alias'] ]);
        }

        $total = $this->models->getNews()->getTotalNews( $this->lang_id );



        if( $total['0']['count'] > \config::get( 'limits/news') )
        {
            $paginate =  $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/news', 5),
                    'total_items'       => $total['0']['count'],
                    'url_for'           => [ 'for' => 'news_paginate', 'page' => $page ],
                    'index_page'       => 'news'
                ], true
            );
        }

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
            'news'              => $news,
            'page'              => $page,
            'total'             => $total['0']['count'],
            'page_title'        => 'news',
            'meta_title'        => $meta_title[$this->lang_id],
            'meta_description'  => $meta_description[$this->lang_id],
            'meta_link_next'            => $meta_link_next[1],
            'meta_link_prev'            => $meta_link_prev[1],
            'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);*/
    }

	public function oneNewsAction($news_alias, $news_id)
	{
		$meta_title =
			[
				'1' => 'Новини та акції | Інтернет магазин насіння Semena.in.ua',
				'2' => 'Новости и акции | Интернет магазин семян Semena.in.ua'
			];

		$meta_description =
			[
				'1' => 'Останні новини та актуальні акції інтернет магазину насіння Semena.in.ua',
				'2' => 'Последние новости и актуальные акции интернет магазина семян Semena.in.ua'
			];

		$css = [
			'https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic',
			'/landing_sales/style.css',
			'/landing_sales/flipclock.css'
		];

		$js = [
			'/landing_sales/flipclock.min.js',
			'/landing_sales/script.js'
		];

		$lang_url = $this->seoUrl->getChangeLangUrl();

		$current_sale = $this->models->getSales()->getOneDataByLang($news_id, $this->lang_id)[0];
		$current_sale['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $current_sale['id'], 'news_alias' => $current_sale['alias'] ]);
		$current_sale['group_ids'] = $this->common->parseArray($current_sale['group_ids']);
		$sale_groups = $this->models->getItems()->getGroupsByGroups($this->lang_id, $current_sale['group_ids']);
		$sale_groups   = $this->common->explodeAlias($sale_groups);
		$sale_groups_  = $this->common->getGroups1( $this->lang_id, $sale_groups );

		$now = time();
		$current_year = date('Y');
		$current_month = date('m');
		$current_day = date('d');
		$left_date = $current_sale['active']
			? (new \DateTime($current_sale['end_date']))->add(new \DateInterval('P1D'))
			: new \DateTime($current_sale['start_date']);
		$d = $left_date->format('d');
		$m = $left_date->format('m');
		if($current_month > $m || ($current_month == $m && $current_day > $d))
			$current_year++;
		$left_date->setDate($current_year , $m , $d);
		$timestamp_left = $left_date->getTimestamp();
		$seconds_left = $timestamp_left - $now;

		$active_sales = $this->models->getSales()->getActiveSalesExceptCurrent($this->lang_id, $current_sale['id']);
		$future_sales = $this->models->getSales()->getFutureSalesExceptCurrent($this->lang_id, $current_sale['id']);
		$recent_sales = array_merge($active_sales, $future_sales);

		foreach( $recent_sales as $k => $n )
		{
			$recent_sales[$k]['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $n['id'], 'news_alias' => $n['alias'] ]);
		}

		$this->view->setVars([
			'css' => $css,
			'js' => $js,
			'change_lang_url' => $lang_url,
			'meta_title' => $meta_title[$this->lang_id],
			'meta_description' => $meta_description[$this->lang_id],
			'classic_sales' => $recent_sales,
			'current_sale' => $current_sale,
			'time_left' => $seconds_left,
			'groups' => $sale_groups_
		]);

		$this->view->pick('menu/oneSale');
		/*$this->lang_id = $this->seoUrl->getLangId();
		$params = $this->dispatcher->getParams();
		$news_id = $params['news_id'];

		$one_news                   = $this->models->getNews()->getOneNews( $this->lang_id, $news_id );

		if( !empty( $one_news ) )
		{
			$one_news['0']['link']      = $this->url->get([ 'for' => 'one_news', 'news_id' => $one_news['0']['id'], 'news_alias' => $one_news['0']['alias'] ]);
			$one_news['0']['image']     = $this->storage->getPhotoUrl( $one_news['0']['cover'], 'news', '400x265' );

			$news2groups_ids_           = $this->etc->int2arr($one_news['0']['group_id']);
			$news2groups                = [];
			$pages_news2groups          = '';

			if( !empty( $news2groups_ids_ ) )
			{
				$news2groups_ids            = array_chunk( $news2groups_ids_, \config::get( 'limits/groups2news' ) );
				$news2groups_               = $this->models->getItems()->getNews2Groups( $this->lang_id, $news2groups_ids['0'] );
				$news2groups                = $this->common->getGroups( $this->lang_id, $news2groups_ );

				$total_groups               = count($news2groups_ids_);
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
					'2' => $one_news['0']['title'].' Актуально на Semena.in.ua. '
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
		}*/
	}

	public function oneNewsItemsAction($news_alias, $news_id)
	{
		$meta_title =
			[
				'1' => 'Новини та акції | Інтернет магазин насіння Semena.in.ua',
				'2' => 'Новости и акции | Интернет магазин семян Semena.in.ua'
			];

		$meta_description =
			[
				'1' => 'Останні новини та актуальні акції інтернет магазину насіння Semena.in.ua',
				'2' => 'Последние новости и актуальные акции интернет магазина семян Semena.in.ua'
			];

		$lang_url = $this->seoUrl->getChangeLangUrl();

		$current_sale = $this->models->getSales()->getOneDataByLang($news_id, $this->lang_id)[0];
		$current_sale['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $current_sale['id'], 'news_alias' => $current_sale['alias'] ]);
		$current_sale['group_ids'] = $this->common->parseArray($current_sale['group_ids']);
		$sale_groups = $this->models->getItems()->getGroupsByGroups($this->lang_id, $current_sale['group_ids']);
		$sale_groups   = $this->common->explodeAlias($sale_groups);
		$sale_groups_  = $this->common->getGroups1( $this->lang_id, $sale_groups );


		$this->view->setVars([
			'change_lang_url' => $lang_url,
			'meta_title' => $meta_title[$this->lang_id],
			'meta_description' => $meta_description[$this->lang_id],
			'current_sale' => $current_sale,
			'items' => $sale_groups_
		]);

		$this->view->pick('menu/oneSaleItems');
	}


	public function videoAction( )
    {
        $lang_url = $this->seoUrl->getChangeLangUrl();
		$params = $this->dispatcher->getParams();
        $page = isset($params['page']) && !empty($params['page']) ? $params['page'] : 1;
		$rub = isset($params['rub']) && !empty($params['rub']) ? $params['rub'] : 0;

        $this->lang_id = $this->seoUrl->getLangId();
        $tips = $this->models->getNews()->getVideo( $this->lang_id, $page, $rub, \config::get( 'dealer_rubric' ) );

        foreach( $tips as $k => $n )
        {
            $tips[$k]['image']  = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '180x120' ) : '';
            $tips[$k]['link']   = $this->url->get([ 'for' => 'one_tips', 'tips_id' => $n['id'], 'tips_alias' => $n['alias'] ]);
        }

        $total = $this->models->getNews()->getTotalVideo( $this->lang_id, $rub );

        $meta_title =
            [
                '1' => 'Відео | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Видео | Интернет магазин семян Semena.in.ua'
            ];

        $meta_description =
            [
                '1' => 'Відео агрономів та фермерів на сайті Semena.in.ua.',
                '2' => 'Видео агрономов и фермеров на сайте Semena.in.ua.'
            ];
		if(empty($params['rub']))$params['rub'] = '';
        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => \config::get( 'limits/news', 5),
                'total_items'       => $total['0']['count'],
                'url_for'           => [ 'for' => 'video_paginate', 'page' => $page,'rub'=>$params['rub'] ],
                'index_page'       => 'video'
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
            'meta_link_next'            => $meta_link_next[1],
            'meta_link_prev'            => $meta_link_prev[1],
            'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////	

    ///////////////////////////////////////////////////////////////////////////

    public function profTipsAction( )
    {
        $lang_url = $this->seoUrl->getChangeLangUrl();
		$params = $this->dispatcher->getParams();
        $page = isset($params['page']) && !empty($params['page']) ? $params['page'] : 1;
		$rub = isset($params['rub']) && !empty($params['rub']) ? $params['rub'] : 0;

        $this->lang_id = $this->seoUrl->getLangId();
        $tips = $this->models->getNews()->getTips( $this->lang_id, $page, $rub, \config::get( 'dealer_rubric' ) );

        foreach( $tips as $k => $n )
        {
            $tips[$k]['image']  = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '180x120' ) : '';
            $tips[$k]['link']   = $this->url->get([ 'for' => 'one_tips', 'tips_id' => $n['id'], 'tips_alias' => $n['alias'] ]);
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
		if(empty($params['rub']))$params['rub'] = '';
        $paginate = $this->common->paginate(
            [
                'page'              => $page,
                'items_per_page'    => \config::get( 'limits/news', 5),
                'total_items'       => $total['0']['count'],
                'url_for'           => [ 'for' => ((!empty($params['rub'])) ? 'prof_tips_rubric_paginate' : 'prof_tips_paginate'), 'page' => $page,'rub'=>$params['rub'] ],
                'index_page'       => 'prof_tips'
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
            'meta_link_next'            => $meta_link_next[1],
            'meta_link_prev'            => $meta_link_prev[1],
            'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }


    public function oneTipsAction( $tips_alias, $tips_id )
    {
        $this->lang_id = $this->seoUrl->getLangId();
        $params = $this->dispatcher->getParams();
        $tips_id = $params['tips_id'];

        $one_news                   = $this->models->getNews()->getOneNews( $this->lang_id, $tips_id, \config::get( 'dealer_rubric' ) );

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

    ///////////////////////////////////////////////////////////////////////////

    public function partnersAction(  )
    {
        $this->lang_id = $this->seoUrl->getLangId();
        $partners = $this->models->getPartners()->getPartners( $this->lang_id );

        foreach( $partners as $p )
        {
            $partners_[$p['shop_type']][] = $p;
        }

        $internet_shops = $partners_['1'];

        foreach( $partners_['2'] as $p )
        {
               $dillers[$p['district']][] = $p;
        }

        $meta_title =
            [
                '1' => 'Партнери та дилери | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Партнеры и дилеры | Интернет магазин семян Semena.in.ua'
            ];

        $meta_description =
            [
                '1' => 'Контактна інформація, телефони дилерів та партнерів нашого магазину',
                '2' => 'Контактная информация, телефоны дилеров и партнеров нашего магазина'
            ];

        $this->view->setVars([
            'internet_shops'    => $internet_shops,
            'dillers'           => $dillers,
            'meta_title'        => $meta_title[$this->lang_id],
            'meta_description'  => $meta_description[$this->lang_id],
            'page_title'        => 'partners'
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function contactsAction()
    {
        $this->lang_id = $this->seoUrl->getLangId();
        $shops = $this->models->getPartners()->getContactsShops( $this->lang_id );
        $lang_url = $this->seoUrl->getChangeLangUrl();

        $meta_title =
            [
                '1' => 'Контакти, адреса, телефон ТМ «Професійне насіння» | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Контакты, адрес, телефон ТМ «Профессиональное семян» | Интернет магазин семян Semena.in.ua'
            ];

        $meta_description =
            [
                '1' => 'Контактна інформація, та як до нас доїхати.',
                '2' => 'Контактная информация и как к нам доехать.'
            ];

        $this->view->setVars([
            'change_lang_url'   => $lang_url,
            'shops'             => $shops,
            'meta_title'        => $meta_title[$this->lang_id],
            'meta_description'  => $meta_description[$this->lang_id],
            'page_title'        => 'partners'
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function callbackAction( )
    {
        $this->lang_id = $this->seoUrl->getLangId();
        $callback['id'] = $this->session->get('id');
        $callback['id'] = !empty( $callback['id'] ) ? $callback['id'] : 0;
        $customer       = [];

        if( !empty( $callback['id'] ) )
        {
            $customer   = $this->models->getCustomers()->getCustomer($callback['id']);
        }

        if( $this->request->isPost() )
        {
            $callback['name']               = $this->request->getPost('name', 'string', NULL );
            $email                          = $this->request->getPost('email', 'string', NULL );
            $callback['comments']           = $this->request->getPost('comments', 'string', NULL );
            $callback['email']              = filter_var( $email, FILTER_VALIDATE_EMAIL );
            $callback['phone']              = empty( $callback['email'] ) ? $email : NULL;
            $callback['email']              = !empty( $callback['email'] ) ? $callback['email'] : NULL;

            if( !empty( $callback['name'] ) && !empty( $callback['comments'] ) && ( !empty( $callback['email'] ) || !empty( $callback['phone'] ) ) )
            {
                if( $callback_id = $this->models->getCallback()->addCallback($callback) )
                {
                    $callback['callback_id'] = $callback_id['0']['id'];

                    if( !empty( $callback['email'] ) )
                    {
                        $this->sendmail->addCustomer( 8, $callback );
                    }

                    $this->sendmail->addCustomer( 7, $callback );

                    setcookie("callback", '1', time()+3600);

                    return $this->response->redirect([ 'for' => 'homepage', 'language' => $this->lang_name ]);
                }
            }
            else
            {
                $this->session->set( 'callback', $callback );
                $this->flash->error( $this->languages->getTranslation()->_("required_error"));
                return $this->response->redirect([ 'for' => 'callback_errors', 'language' => $this->lang_name ]);
            }
        }

        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);

        $this->view->setVars([
            'customer'  => $customer,
            'no_robots' => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function callbackErrorsAction( )
    {
        $callback_session   = $this->session->get( 'callback' );
        $callback['id']     = $this->session->get('id');
        $customer           = [];

        if( !empty( $callback['id'] ) )
        {
            $customer       = $this->models->getCustomers()->getCustomer($callback['id']);
        }

        if( $this->request->isPost() )
        {
            $callback['name']               = $this->request->getPost('name', 'string', NULL );
            $email                          = $this->request->getPost('email', 'string', NULL );
            $callback['comments']           = $this->request->getPost('comments', 'string', NULL );
            $callback['email']              = filter_var( $email, FILTER_VALIDATE_EMAIL );
            $callback['phone']              = empty( $callback['email'] ) ? $email : NULL;
            $callback['email']              = !empty( $callback['email'] ) ? $callback['email'] : NULL;

            if( !empty( $callback['name'] ) && !empty( $callback['comments'] ) && ( !empty( $callback['email'] ) || !empty( $callback['phone'] ) ) )
            {
                if( $callback_id = $this->models->getCallback()->addCallback($callback) )
                {
                    $callback['callback_id'] = $callback_id['0']['id'];

                    if( !empty( $callback['email'] ) )
                    {
                        $this->sendmail->addCustomer( 8, $callback );
                    }

                    $this->sendmail->addCustomer( 7, $callback );

                    setcookie("callback", '1', time()+3600);

                    return $this->response->redirect([ 'for' => 'homepage', 'language' => $this->lang_name ]);
                }
            }
        }

        $this->view->setVars([
            'callback_session'  => $callback_session,
            'customer'          => $customer,
            'no_robots'         => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////
}