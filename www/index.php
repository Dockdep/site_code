<?php
ini_set ( 'session.gc_maxlifetime'  , 360000);
error_reporting(0);
$cat = array('nasinnja_ovochiv','nasinnja_kvitiv','dobriva_ta_zasobi_zakhistu','gazonni_travi','kvitkovi_sumishi','biopreparati','dobriva_ta_zakhist_roslin');

$url_path = explode('/',$_SERVER['QUERY_STRING']);
foreach($cat as $c){

	if($url_path[1]==$c){
		header("HTTP/1.1 301 Moved Permanently");
		if(empty($url_path[2]))header('location:/'.$c.'_1c0');
		elseif(empty($url_path[3])) header('location:/'.$c.'_1c0/'.$url_path[2].'_1c1');
		else header('location:/'.$c.'_1c0/'.$url_path[2].'_1c1/'.$url_path[3]);
		exit;
	}

}


///////////////////////////////////////////////////////////////////////////////

define( 'START_TIME',           microtime(true) );
define( 'ROOT_PATH',            realpath(__DIR__.'/../src').'/' );
define( 'STORAGE_PATH',         realpath(__DIR__.'/../storage').'/' );

///////////////////////////////////////////////////////////////////////////////

# IS_PRODUCTION
defined( 'IS_PRODUCTION' ) || define( 'IS_PRODUCTION', ( getenv('SERVER_TYPE') && getenv('SERVER_TYPE')=='dev' ? false : true ) );

///////////////////////////////////////////////////////////////////////////////
















try
{
    ///////////////////////////////////////////////////////////////////////////

    if( IS_PRODUCTION )
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        
        // blank P-functions
        if( function_exists('p')===false ) { function p() {} }
        if( function_exists('z')===false ) { function z() {} }
        if( function_exists('j')===false ) { function j() {} }
        if( function_exists('b')===false ) { function b() {} }
        if( function_exists('info')===false ) { function info() {} }
        if( function_exists('f')===false ) { function f() {} }
        if( function_exists('fpe')===false ) { function fpe() {} }
    }
    else
    {
        error_reporting(-1);
        ini_set('display_errors', 1);
        
        // P-functions
        require( ROOT_PATH.'lib/p.php' );
    }

    ///////////////////////////////////////////////////////////////////////////
    
    require( ROOT_PATH.'lib/config.php' );
    
    config::setApp( 'frontend' );

    ///////////////////////////////////////////////////////////////////////////
    
    $loader = new \Phalcon\Loader();

	$loader->registerDirs([
	    ROOT_PATH.config::get( 'dirs/controllersDir' ),
        ROOT_PATH.config::get( 'dirs/appLibrariesDir' ),
	    ROOT_PATH.config::get( 'dirs/librariesDir' ),
	    ROOT_PATH.config::get( 'dirs/modelsDir' ),
	])->register();

    $loader->registerNamespaces([
        'controllers'       => ROOT_PATH.config::get( 'dirs/controllersDir' ),
        'frontend\lib'      => ROOT_PATH.config::get( 'dirs/appLibrariesDir' ),
        'lib'               => ROOT_PATH.config::get( 'dirs/librariesDir' ),
        'models'            => ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();
    
    ///////////////////////////////////////////////////////////////////////////
    
    if( IS_PRODUCTION )
    {
        // sets the exception handler
        set_exception_handler(function($e)
        {
            echo( $e->getMessage() );
        });

        // sets the error handler
        set_error_handler(function($errorCode, $errorMessage, $errorFile, $errorLine)
        {
            echo( $errorMessage );
        });
    }
    else
    {
        // sets the exception handler
        set_exception_handler(function($e)
        {
            if( class_exists('exceptions') )
            {
                $z = new \exceptions();
                return $z->handle($e);
            }
            else
            {
                die( '[ExceptionHandler] '.$e->getMessage() );
            }   
        });

        // sets the error handler
        set_error_handler(function($errorCode, $errorMessage, $errorFile, $errorLine)
        {
            if( class_exists('exceptions') )
            {
                $z = new \exceptions();
                return $z->handleError($errorCode, $errorMessage, $errorFile, $errorLine);
            }
            else
            {
                die( '[ErrorHandler] '.$errorMessage.' in '.$errorFile.':'.$errorLine );
            }
        });
    }
    
    ///////////////////////////////////////////////////////////////////////////

    $di = new \Phalcon\DI();

	///////////////////////////////////////////////////////////////////////////
	
    // request
    
    $di->set( 'request', function() 
    {
        return new \Phalcon\Http\Request();
    }, true );

	///////////////////////////////////////////////////////////////////////////    
	
    // response
    
    $di->set( 'response', function() 
    {
        return new \Phalcon\Http\Response();
    }, true );

	///////////////////////////////////////////////////////////////////////////
	
    // router
    
	$di->set( 'router', function()
	{
        //////////////////////////////////////////////////////////////////////	

        $router = new \Phalcon\Mvc\Router();

        //////////////////////////////////////////////////////////////////////        

        $router->removeExtraSlashes( true );
        
        //////////////////////////////////////////////////////////////////////

        $router->add
            ( 
                '/{language:([a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'index',
                ]
            )
            ->setName( 'homepage' );


        $router->add
            (
                '/{type:[a-z0-9\-\_]{3,}}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'type',
                ]
            )
            ->setName( 'type' );


        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]{3,}}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'subtype',
                ]
            )
            ->setName( 'subtype' );





        $router->add
            (
                '/{url:[a-z0-9\-\_]{3,}}/{subtype:[a-z0-9\-\_]{3,}}/compare/{compare_ids:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'compareItems',
                ]
            )
            ->setName( 'compare_items' );



        $router->add
            (
                '/{url:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/delete/{compare_ids:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'compareItemsDel',
                ]
            )
            ->setName( 'compare_items_del' );

        $router->add
            (
                '/list{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'list',
                ]
            )
            ->setName( 'search_list' );
		$router->add
            (
                '/search{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'search',
                ]
            )
            ->setName( 'search_items' );

        $router->add
            (
				'/search/{search:[^\/]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'search',
                ]
            )
            ->setName( 'search_items_route' );

        $router->add
            (
                '/search/{search:[^\/]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'search',
                ]
            )
            ->setName( 'search_items_paged' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'subtype',
                ]
            )
            ->setName( 'subtype_paged' );
        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/sort-{sort0:[0-9]+}-{sort:[0-9]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'subtype',
                ]
            )
            ->setName( 'subtype_paged_sort' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{group_alias:[a-z0-9\-\_\+]+}-{item_id:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'item',
                ]
            )
            ->setName( 'item' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'subtype',
                ]
            )
            ->setName( 'subtype_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'subtype',
                ]
            )
            ->setName( 'subtype_sorted_paged' );

        // filters

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_ids' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_ids_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_ids_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_ids_sorted_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_sorted_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_price' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_price_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_price_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_price_sorted_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_price' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_price_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_price_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_id_alias_price_sorted_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_price' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_price_sorted' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_price_paginate' );

        $router->add
            (
                '/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'filters',
                ]
            )
            ->setName( 'get_items_with_filters_price_sorted_paginate' );



        ///////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/change_top_items{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'topItems',
                ]
            )
            ->setName( 'change_top_items' );

        $router->add
            (
                '/change_with_size{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'changeWithSize',
                ]
            )
            ->setName( 'change_with_size' );

        $router->add
            (
                '/change_with_color{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'changeWithColor',
                ]
            )
            ->setName( 'change_with_color' );

        $router->add
            (
                '/change_similar_items{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'page',
                    'action'        => 'changeSimilarItems',
                ]
            )
            ->setName( 'change_similar_items' );

        ///////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/{page_alias:[a-z0-9\-\_]+}-{page_id:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'staticPage',
                ]
            )
            ->setName( 'static_page' );

        $router->add
            (
                '/news-actions{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'news',
                ]
            )
            ->setName( 'news' );


        $router->add
            (
                '/news-actions/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'news',
                ]
            )
            ->setName( 'news_paginate' );

        $router->add
            (
                '/news-actions/{news_alias:[a-z0-9\-\_]+}-{news_id:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'oneNews',
                ]
            )
            ->setName( 'one_news' );

        $router->add
        (
            '/news-actions/{news_alias:[a-z0-9\-\_]+}-{news_id:[0-9]+}/items{language:([/][a-z]{2})?}',
            [
                'controller'    => 'menu',
                'action'        => 'oneNewsItems',
            ]
        )
            ->setName( 'one_news_items' );

        $router->add
            (
                '/video{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'video',
                ]
            )
            ->setName( 'video' );

        $router->add
        (
            '/video/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'menu',
                'action'        => 'video',
            ]
        )
            ->setName( 'video_paginate' );
        $router->add
            (
                '/prof_tips{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'profTips',
                ]
            )
            ->setName( 'prof_tips' );

        $router->add
            (
                '/prof_tips/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'profTips',
                ]
            )
            ->setName( 'prof_tips_paginate' );
			
        $router->add
            (
                '/prof_tips/rub/{rub:[0-9]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'profTips',
                ]
            )
            ->setName( 'prof_tips_rubric_paginate' );
        $router->add
            (
                '/prof_tips/rub/{rub:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'profTips',
                ]
            )
            ->setName( 'prof_tips_rubric' );			

        $router->add
            (
                '/prof_tips/{tips_alias:[a-z0-9\–\-\_]+}-{tips_id:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'oneTips',
                ]
            )
            ->setName( 'one_tips' );

        $router->add
            (
                '/partners',
                [
                    'controller'    => 'menu',
                    'action'        => 'partners',
                ]
            )
            ->setName( 'partners' );

        $router->add
            (
                '/contacts{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'contacts',
                ]
            )
            ->setName( 'contacts' );

        $router->add
            (
                '/basket{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'order',
                ]
            )
            ->setName( 'basket' );

		$router->add
            (
                '/basket/completed{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'orderCompleted',
                ]
            )
            ->setName( 'basket_completed' );

        $router->add
            (
                '/basket/add_item{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'addToBasket',
                ]
            )
            ->setName( 'add_to_basket' );
        $router->add
            (
                '/basket/add{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'addProductBasket',
                ]
            )
            ->setName( 'add_to_basket' );
        $router->add
            (
                '/basket/delete_item{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'deleteFromBasket',
                ]
            )
            ->setName( 'delete_from_basket' );

        $router->add
            (
                '/basket/change_count_basket{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'changeCountBasket',
                ]
            )
            ->setName( 'add_to_basket' );

        $router->add(
            '/basket/get_cart_items{language:([/][a-z]{2})?}',
            [
                'controller' => 'menu',
                'action' => 'getCartItems'
            ]
        )->getName('get_cart_items');

        $router->add
            (
                '/callback{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'callback',
                ]
            )
            ->setName( 'callback' );
        $router->add
        (
            '/count{language:([/][a-z]{2})?}',
            [
                'controller'    => 'menu',
                'action'        => 'count',
            ]
        )
            ->setName( 'count' );
        $router->add
            (
                '/call-back{language:([/][a-z]{2})?}', // callbackErrors
                [
                    'controller'    => 'menu',
                    'action'        => 'callbackErrors',
                ]
            )
            ->setName( 'callback_errors' );

        ///////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/ajax/get_cities{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'getCities',
                ]
            )
            ->setName( 'get_cities' );

        $router->add
            (
                '/ajax/get_offices{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'menu',
                    'action'        => 'getOffices',
                ]
            )
            ->setName( 'get_offices' );

        $router->add
            (
                '/ajax/get_items{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'ajax',
                    'action'        => 'getItems',
                ]
            )
            ->setName( 'get_items' );

        $router->add
            (
                '/ajax/add_item_for_compare{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'ajax',
                    'action'        => 'addItemsForCompare',
                ]
            )
            ->setName( 'add_item_for_compare' );

        $router->add
        (
            '/ajax/toggle_cabinet[/]?',
            [
                'controller'    => 'ajax',
                'action'        => 'toggleCabinet',
            ]
        )
            ->setName( 'toggle_cabinet' );

        $router->add
        (
            '/ajax/action_discount/{action_id:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'ajax',
                'action'        => 'getActionDiscount',
            ]
        )
            ->setName( 'get_action_discount' );

        $router->add
        (
            '/ajax/set_action_discount{language:([/][a-z]{2})?}',
            [
                'controller'    => 'ajax',
                'action'        => 'setActionDiscount',
            ]
        )
            ->setName( 'set_action_discount' );


        $router->add
        (
            '/ajax/get_item_group{language:([/][a-z]{2})?}',
            [
                'controller' => 'ajax',
                'action' => 'getItemGroup'
            ]
        )
            ->setName('get_item_group');

        $router->add
        (
            '/ajax/apply_promo_code{language:([/][a-z]{2})?}',
            [
                'controller' => 'ajax',
                'action' => 'applyPromoCode'
            ]
        )
            ->setName('apply_promo_code');


        $router->add
            (
                '/customer_login{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'customerLogin',
                ]
            )
            ->setName( 'customer_login' );

        $router->add
            (
                '/customer_login/social/{mechanism:[a-z0-9\-\_]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'customerLoginSocial',
                ]
            )
            ->setName( 'customer_login_social' );

        $router->add
            (
                '/customer_logout{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'customerLogout',
                ]
            )
            ->setName( 'customer_logout' );

        $router->add
            (
                '/registration{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'registration',
                ]
            )
            ->setName( 'registration' );

        $router->add
            (
                '/finish_registration{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'finishRegistration',
                ]
            )
            ->setName( 'finish_registration' );

        $router->add
            (
                '/registration_canceled{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'registrationCancel',
                ]
            )
            ->setName( 'registration_canceled' );

        $router->add
            (
                '/restore_passwd{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'restorePasswd',
                ]
            )
            ->setName( 'restore_passwd' );

        $router->add
            (
                '/restore/{confirm_key:[a-z0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'resetPasswd',
                ]
            )
            ->setName( 'reset_passwd' );

        $router->add
            (
                '/confirm_registration/{confirm_key:[a-z0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'confirmRegistration',
                ]
            )
            ->setName( 'confirm_registration' );

        $router->add
            (
                '/cabinet{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'cabinet',
                ]
            )
            ->setName( 'cabinet' );
        $router->add
        (
            '/cabinet/email-settings{language:([/][a-z]{2})?}',
            [
                'controller'    => 'customer',
                'action'        => 'emailSettings',
            ]
        )
            ->setName( 'cabinet_email_settings' );
        $router->add
        (
            '/cabinet/email-subscr',
            [
                'controller'    => 'customer',
                'action'        => 'emailSubscr',
            ]
        )
            ->setName( 'cabinet_email_subscr' );

        $router->add
        (
            '/cabinet/email-settings-key/{confirm_key:[a-z0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'customer',
                'action'        => 'emailSettingsKey',
            ]
        )
            ->setName( 'cabinet_email_settings_key' );
        
        $router->add
        (
            '/cabinet/key/{confirm_key:[a-z0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'customer',
                'action'        => 'cabinetSettingsKey',
            ]
        )
            ->setName( 'cabinet_key' );

        $router->add
        (
            '/cabinet/email-cancel/{confirm_key:[a-z0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'customer',
                'action'        => 'emailCancel',
            ]
        )
            ->setName( 'cabinet_email_settings' );
        $router->add
            (
                '/cabinet/order-{order_id:[0-9]+}{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'listOrders',
                ]
            )
            ->setName( 'list_orders' );

        $router->add
            (
                '/change_customer_passwd{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'customer',
                    'action'        => 'changeCustomerPasswd',
                ]
            )
            ->setName( 'change_customer_passwd' );



        $router->add
            (
                '/login{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'user',
                    'action'        => 'login',
                ]
            )
            ->setName( 'user_login' );


        $router->add
            (
                '/_service/get_types{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'types',
                ]
            )
            ->setName( 'get_types' );

        $router->add
            (
                '/_service/get_images{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'images',
                ]
            )
            ->setName( 'get_images' );

        $router->add
            (
                '/_service/change_images{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'storage',
                ]
            )
            ->setName( 'change_images' );

        $router->add
            (
                '/_service/change_catalog{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'catalog',
                ]
            )
            ->setName( 'change_catalog' );

        $router->add
            (
                '/_service/change_cities{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'cities',
                ]
            )
            ->setName( 'change_cities' );

        $router->add
            (
                '/_service/poshta{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'poshta',
                ]
            )
            ->setName( 'poshta' );

        $router->add
            (
                '/_service/type_subtype{language:([/][a-z]{2})?}',
                [
                    'controller'    => 'service',
                    'action'        => 'typeSubtype',
                ]
            )
            ->setName( 'type_subtype' );

        $router->add
            (
                '/change_language/{new_language:[a-z]{2}}',
                [
                    'controller'    => 'page',
                    'action'        => 'changelanguage',
                ]
            )
            ->setName( 'change_language' );

        $router->add
            (
                '/dealer{language:([/][a-z]{2})?}',
                [
                    'controller' => 'dealer',
                    'action' => 'index'

                ]
            )
            ->setName('index_dealer');

        $router->add
            (
                '/dealer/upload[/]?',
                [
                    'controller' => 'dealer',
                    'action' => 'upload'
                ]
            )
            ->setName('upload_photo');

        $router->add
            (
                '/dealer/useful_materials{language:([/][a-z]{2})?}',
                [
                    'controller' => 'dealer',
                    'action' => 'usefulMaterials'
                ]
            )
            ->setName('useful_materials');

        $router->add
        (
            '/dealer/useful_materials/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'usefulMaterials',
            ]
        )
            ->setName( 'useful_materials_paginate' );

        $router->add
        (
            '/dealer/useful_materials/rub/{rub:[0-9]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'usefulMaterials',
            ]
        )
            ->setName( 'useful_materials_rubric_paginate' );

        $router->add
        (
            '/dealer/useful_materials/rub/{rub:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'usefulMaterials',
            ]
        )
            ->setName( 'useful_materials_rubric' );

        $router->add
        (
            '/dealer/useful_materials/{tips_alias:[a-z0-9\-\_]+}-{tips_id:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'oneUsefulMaterial',
            ]
        )
            ->setName( 'one_useful_material' );

        $router->add
            (
                '/dealer/top_orders{language:([/][a-z]{2})?}',
                [
                    'controller' => 'dealer',
                    'action' => 'topItems'
                ]
            )
            ->setName('top_items');

        $router->add
        (
            '/dealer/top_orders/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'topItems'
            ]
        )
            ->setName('top_items_paginate');

        $router->add
            (
                '/dealer/recommended_items{language:([/][a-z]{2})?}',
                [
                    'controller' => 'dealer',
                    'action' => 'recommendedItems'
                ]
            )
            ->setName('recommended_items');

        $router->add
        (
            '/dealer/recommended_items/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'recommendedItems'
            ]
        )
            ->setName('recommended_items_paginate');

        $router->add
        (
            '/dealer/cart{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'cart'
            ]
        )
            ->setName('cart');

        $router->add
        (
            '/dealer/ordering{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'order'
            ]
        )
            ->setName('dealer_order');

        $router->add
        (
            '/dealer/delete_preorder_item',
            [
                'controller' => 'dealer',
                'action' => 'deletePreOrderItem'
            ]
        )
            ->setName('delete_preorder_item');


        $router->add
        (
            '/dealer/top_dealer_orders{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'topDealerItems'
            ]
        )
            ->setName('top_dealer_items');

        $router->add
        (
            '/dealer/top_dealer_orders/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'topDealerItems'
            ]
        )
            ->setName('top_dealer_items_paginate');

        $router->add
        (
            '/dealer/novelty{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'newItems'
            ]
        )
            ->setName('new_items');

        $router->add
        (
            '/dealer/novelty/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'newItems'
            ]
        )
            ->setName('new_items_paginate');

        $router->add
        (
            '/dealer/email_settings{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'emailSettings'
            ]
        )
            ->setName('email_settings');

        $router->add
        (
            '/dealer/equipment{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'equipment'
            ]
        )
            ->setName('equipment');

        $router->add
        (
            '/dealer/profile_settings{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'personalData'
            ]
        )
            ->setName('personal_data');

        $router->add
        (
            '/dealer/online_order_history{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'onlineOrderHistory'
            ]
        )
            ->setName('online_order_history');

        $router->add
        (
            '/dealer/online_order_history/{order:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'singleOrder'
            ]
        )
            ->setName('single_order');

        $router->add
        (
            '/dealer/print_order/{order:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'printOrder'
            ]
        )
            ->setName('print_order');

        $router->add
        (
            '/dealer/shipment_history{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'shipmentHistory'
            ]
        )
            ->setName('shipment_history');


        $router->add
        (
            '/dealer/price_list{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'priceList'
            ]
        )
            ->setName('price_list');

        $router->add
        (
            '/dealer/wholesale_prices{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'wholesalePrices'
            ]
        )
            ->setName('wholesale_prices');

        $router->add
        (
            '/dealer/help{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'help'
            ]
        )
            ->setName('help');

        $router->add
        (
            '/dealer/financial_calculations{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'financialCalculations'
            ]
        )
            ->setName('financial_calculations');

        $router->add
        (
            '/dealer/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{group_alias:[a-z0-9\-\_\+]+}-{item_id:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller' => 'dealer',
                'action' => 'item'
            ]
        )
            ->setName('item_dealer');

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'catalog',
            ]
        )
            ->setName( 'dealer_catalog_paged' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'catalog',
            ]
        )
            ->setName( 'dealer_catalog_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/sort-{sort0:[0-9]+}-{sort:[0-9]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'catalog',
            ]
        )
            ->setName( 'dealer_catalog_paged_sort' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]{3,}}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'catalog',
            ]
        )
            ->setName( 'dealer_catalog' );

        $router->add
        (
            '/dealer/search{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'search',
            ]
        )
            ->setName( 'dealer_search_items' );

        $router->add
        (
            '/dealer/search/{search:[^\/]+}',
            [
                'controller'    => 'dealer',
                'action'        => 'search',
            ]
        )
            ->setName( 'dealer_search_items_route' );

        $router->add
        (
            '/dealer/search/{search:[^\/]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'search',
            ]
        )
            ->setName( 'dealer_search_items_paged' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_ids' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_ids_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_ids_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_ids_sorted_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_paginate' );

        $router->add
        (
            '/dealer/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_sorted_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_price' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_price_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_price_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'get_items_with_filters_id_price_sorted_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_price' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_price_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_price_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/{filter_ids:[0-9\-]+}{filter_alias:\-+\-+[a-z0-9\-\_\:]+}--price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_id_alias_price_sorted_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_price' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_price_sorted' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_price_paginate' );

        $router->add
        (
            '/dealer/catalog/{type:[a-z0-9\-\_]+}/{subtype:[a-z0-9\-\_]+}/price-{price:[0-9\-]+}/sort-{sort:[0-9\-]+}/page/{page:[0-9]+}{language:([/][a-z]{2})?}',
            [
                'controller'    => 'dealer',
                'action'        => 'filters',
            ]
        )
            ->setName( 'dealer_get_items_with_filters_price_sorted_paginate' );

        $router->add
        (
            '/faq{language:([/][a-z]{2})?}',
            [
                'controller'    => 'faq',
                'action'        => 'index',
            ]
        )
            ->setName( 'faq' );

        return $router;
    }, true );
    
    ///////////////////////////////////////////////////////////////////////////	
	
	// url
	
	$di->set( 'url', function() 
	{
		$url = new \Phalcon\Mvc\Url();	
		
		$url->setBaseUri('/');
		
		return $url;
	}, true );


    //seo_url

    $di->set( 'seoUrl', function()
    {
        return new \seoUrl();
    }, true );
	///////////////////////////////////////////////////////////////////////////	
	
	// cache
	
	$di->set( 'cache', function()
	{ 
        $cache = new \Phalcon\Cache\Frontend\Data([
            'lifetime' => 60,
            ]);
        
        return new \Phalcon\Cache\Backend\Memcache(
            $cache,
            [
                'host'  => '127.0.0.1',
                'port'  => 11211,
            ]
        );
    }, true );
    
	///////////////////////////////////////////////////////////////////////////	

    // language

    $di->set( 'languages', function()
    {
        return new \languages();
    }, true );

    //seo_url

    $di->set( 'seoUrl', function()
    {
        return new \seoUrl();
    }, true );

    $di->set( 'plugins', function()
    {
        return new \plugins();
    }, true );	
    //exelphp

    $di->set( 'exelphp', function()
    {
        return new \exelphp();
    }, true );
    $di->set( 'assets', function()
    {
        return new  Phalcon\Assets\Manager();
    }, true );

	///////////////////////////////////////////////////////////////////////////	
	
	// database
	
	$di->set( 'database', function()
	{ 
        $config = 
        [
            'host'      => config::get('global#database/server'),
            'username'  => config::get('global#database/user'),
            'password'  => config::get('global#database/passwd'),
            'dbname'    => config::get('global#database/db'),
            'schema'    => 'public',
        ];
        
        $database       = new \Phalcon\Db\Adapter\Pdo\Postgresql( $config );

        return $database;

	}, true );
	
	///////////////////////////////////////////////////////////////////////////	
	
	// db
	
	$di->set( 'db', function()
	{ 
        return new \db();
	}, true );

    ///////////////////////////////////////////////////////////////////////////
    
    //models
    
    $di->set( 'models', function()
	{ 
        return new \models();
	}, true );
	
	///////////////////////////////////////////////////////////////////////////
	
	// etc
	
	$di->set( 'etc', function()
	{ 
        return new \etc();
	}, true );

    ///////////////////////////////////////////////////////////////////////////

    // profiler

    $di->set( 'profiler', function()
    {
        return new \profiler();
    }, true );

	///////////////////////////////////////////////////////////////////////////	
	
	// common
	
	$di->set( 'common', function()
	{ 
        return new \common();
	}, true );

    ///////////////////////////////////////////////////////////////////////////	
    
    // storage
	
	$di->set( 'storage', function()
	{ 
        return new \storage();
	}, true );

    ///////////////////////////////////////////////////////////////////////////

    // sendmail

    $di->set( 'sendmail', function()
    {
        return new \sendmail();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // novaposhta

    $di->set( 'novaposhta', function()
    {
        return new \novaposhta();
    }, true );

    ///////////////////////////////////////////////////////////////////////////
	
	// liqpay

    $di->set( 'liqpay', function()
    {
        return new \liqpay();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // social

    $di->set( 'social', function()
    {
        return new \social();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // forapprove

    $di->set( 'forapprove', function()
    {
        return new \forapprove();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    $di->set('session', function() use ($di){
        // Create a connection
        $connection = $di->get('database');

        $session = new \Database(array(
            'db' => $connection,
            'table' => 'session_data'
        ));

        $session->start();

        return $session;
    }, true );
	///////////////////////////////////////////////////////////////////////////	
	
	// flash
	
    $di->set( 'flash', function() 
    {
        return new \Phalcon\Flash\Session();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // cookies

    $di->set( 'cookies', function ()
    {
        $cookies = new \Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);

        return $cookies;
    });

    ///////////////////////////////////////////////////////////////////////////

    // recaptchalib

    $di->set( 'recaptchalib', function()
    {
        return new \recaptchalib();
    }, true );


    //sms

    $di->set( 'sms', function()
    {
        return new \sms();
    }, true );

    // recaptchalib

    $di->set( 'link', function()
    {
        return new \link();
    }, true );

    ///////////////////////////////////////////////////////////////////////////
	
    // view 
    
	$di->set( 'view', function()
	{
        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir( ROOT_PATH.config::get( 'dirs/viewsDir' ) );

        $view->registerEngines([
            '.php' => '\Phalcon\Mvc\View\Engine\Php'
        ]);

        return $view;
	}, true );

    ///////////////////////////////////////////////////////////////////////////

    // filter
    
    $di->set( 'filter', function()
    {
        $filter = new \Phalcon\Filter();
        
        $filter->add( 'string', function($value)
        {
            return trim( filter_var( $value, FILTER_SANITIZE_STRING ) );
        });
        
        $filter->add( 'int', function($value)
        {
            return intval( preg_replace( '#[^0-9]#', '', $value ) );
        });
        
        $filter->add( 'float', function($value)
        {
            return trim( filter_var( $value, FILTER_SANITIZE_NUMBER_FLOAT ) );
        });

        return $filter;
    }, true );

    ///////////////////////////////////////////////////////////////////////////
	
	$di->set( 'dispatcher', function()
	{
        // Create/Get an EventManager
        $eventsManager = new \Phalcon\Events\Manager();

        // Attach a listener
        $eventsManager->attach( 'dispatch', function($event, $dispatcher, $exception) 
        {
            // The controller exists but the action not
            if ($event->getType() == 'beforeNotFoundAction') 
            {
                $dispatcher->forward([
				    'controller'    => 'page',
				    'action'        => 'error404'
                ]);
                
                return false;
            }

            // Alternative way, controller or action doesn't exist
            if ($event->getType() == 'beforeException') 
            {
                switch ($exception->getCode()) 
                {
                    case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward([
				            'controller'    => 'page',
				            'action'        => 'error404'
                        ]);
                        
                        return false;
                }
            }
        });

        $dispatcher = new \Phalcon\Mvc\Dispatcher();

        $dispatcher->setDefaultNamespace('controllers');

        // Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

	}, true );
    
    ///////////////////////////////////////////////////////////////////////////

	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);

    ///////////////////////////////////////////////////////////////////////////

    // check for user's timezone from jstz
    if( $di->get('cookies')->has('tz') )
    {
        $timezone = preg_replace( '#[^a-z\/]#i', '', $di->get('cookies')->get('tz')->getValue() );

        if( !empty($timezone) )
        {
            // set user's timezone
            date_default_timezone_set( $timezone );
        }
    }

    ///////////////////////////////////////////////////////////////////////////

    die( $application->handle()->getContent() );

	///////////////////////////////////////////////////////////////////////////

} 
catch (\Phalcon\Exception $e) 
{
    if( IS_PRODUCTION )
    {
        die($e->getMessage());
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[Phalcon\Exception] '.$e->getMessage() );
        }
    }
} 
catch (\PDOException $e)
{
    if( IS_PRODUCTION )
    {
        die($e->getMessage());
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[PDOException] '.$e->getMessage() );
        }    
    }
}
catch (\Exception $e) 
{
    if( IS_PRODUCTION )
    {
        die($e->getMessage());
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[Exception] '.$e->getMessage() );
        }    
    }
}

///////////////////////////////////////////////////////////////////////////////
