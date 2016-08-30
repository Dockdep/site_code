<?php



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

    config::setApp( 'backend' );

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
        'backend\lib'      => ROOT_PATH.config::get( 'dirs/appLibrariesDir' ),
        'lib'               => ROOT_PATH.config::get( 'dirs/librariesDir' ),
        'models'            => ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();

    ///////////////////////////////////////////////////////////////////////////

    if( IS_PRODUCTION )
    {
        // sets the exception handler
        set_exception_handler(function($e)
        {
            #die( $e->getMessage() );
        });

        // sets the error handler
        set_error_handler(function($errorCode, $errorMessage, $errorFile, $errorLine)
        {
            #die( $errorMessage.' in '.$errorFile.':'.$errorLine );
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
    //$di = new \Phalcon\DI\FactoryDefault();

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
                '/',
                [
                    'controller'    => 'page',
                    'action'        => 'index',
                ]
            )
            ->setName( 'admin_homepage' );

        $router->add
            (
                '/orders',
                [
                    'controller'    => 'page',
                    'action'        => 'order',
                ]
            )
            ->setName( 'admin_orders' );

        $router->add
            (
                '/orders/page/{page:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'order',
                ]
            )
            ->setName( 'admin_orders_paginate' );

        $router->add
            (
                '/orders/{sort_type:[a-z\_]+}-{sort_id:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'orderSort',
                ]
            )
            ->setName( 'admin_orders_sorted' );

        $router->add
            (
                '/orders/{sort_type:[a-z\_]+}-{sort_id:[0-9]+}/page/{page:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'orderSort',
                ]
            )
            ->setName( 'admin_orders_sorted_paginate' );


        $router->add
            (
                '/login',
                [
                    'controller'    => 'page',
                    'action'        => 'login',
                ]
            )
            ->setName( 'admin_login' );

        $router->add
            (
                '/logout',
                [
                    'controller'    => 'page',
                    'action'        => 'adminLogout',
                ]
            )
            ->setName( 'admin_login' );

        $router->add
            (
                '/static_page',
                [
                    'controller'    => 'page',
                    'action'        => 'staticPage',
                ]
            )
            ->setName( 'static_page' );

        $router->add
            (
                '/static_page/page/{page:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'staticPage',
                ]
            )
            ->setName( 'static_page_paged' );

        $router->add
            (
                '/static_page/edit/{page_id:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'staticPageEdit',
                ]
            )
            ->setName( 'static_page_edit' );

        $router->add
            (
                '/static_page/add',
                [
                    'controller'    => 'page',
                    'action'        => 'staticPageAdd',
                ]
            )
            ->setName( 'static_page_add' );

        $router->add
            (
                '/static_page/delete/{page_id:[0-9]+}',
                [
                    'controller'    => 'page',
                    'action'        => 'staticPageDelete',
                ]
            )
            ->setName( 'static_page_delete' );


        $router->add
            (
                '/downloadImg',
                [
                    'controller'    => 'page',
                    'action'        => 'downloadImg',
                ]
            )
            ->setName( '/downloadImg' );


        $router->add
        (
            '/downloadImages',
            [
                'controller'    => 'page',
                'action'        => 'downloadImages',
            ]
        )
        ->setName( '/downloadImages' );

        $router->add
            (
                '/check_ajax_data',
                [
                    'controller'    => 'page',
                    'action'        => 'checkAjaxData',
                ]
            )
            ->setName( '/check_ajax_data' );


        $router->add
            (
                '/get_campaign_data',
                [
                    'controller'    => 'page',
                    'action'        => 'getCampaignList',
                ]
            )
            ->setName( '/get_campaign_data' );




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/seo_info_index',
                [
                    'controller'    => 'seo',
                    'action'        => 'index',
                ]
            )
            ->setName( 'seo_info_index' );

        $router->add
            (
                '/seo_info_add',
                [
                    'controller'    => 'seo',
                    'action'        => 'add',
                ]
            )
            ->setName( 'seo_info_add' );

        $router->add
            (
                '/seo_info_delete',
                [
                    'controller'    => 'seo',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'seo_info_delete' );

        $router->add
            (
                '/seo_info_update',
                [
                    'controller'    => 'seo',
                    'action'        => 'update',
                ]
            )
            ->setName( 'seo_info_update' );


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/news_index',
                [
                    'controller'    => 'news',
                    'action'        => 'index',
                ]
            )
            ->setName( 'news_index' );



        $router->add
            (
                '/news_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'news',
                    'action'        => 'index',
                ]
            )
            ->setName( 'news_index_paged' );

        $router->add
            (
                '/news_add',
                [
                    'controller'    => 'news',
                    'action'        => 'add',
                ]
            )
            ->setName( 'news_add' );
        $router->add
            (
                '/news_rubrics',
                [
                    'controller'    => 'news',
                    'action'        => 'rubrics',
                ]
            )
            ->setName( 'news_rubrics' );
			
        $router->add
            (
                '/news_rubrics/{id:[0-9]+}',
                [
                    'controller'    => 'news',
                    'action'        => 'rubrics',
                ]
            )
            ->setName( 'news_rubrics' );

        $router->add
            (
                '/news_rubrics_delete/{id:[0-9]+}',
                [
                    'controller'    => 'news',
                    'action'        => 'rubrics_delete',
                ]
            )
            ->setName( 'news_rubrics_delete' );			

        $router->add
            (
                '/news_update/{id:[0-9]+}',
                [
                    'controller'    => 'news',
                    'action'        => 'update',
                ]
            )
            ->setName( 'news_update' );


        $router->add
            (
                '/news_delete/{id:[0-9]+}',
                [
                    'controller'    => 'news',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'news_delete' );

        $router->add
            (
                '/get_product_like',
                [
                    'controller'    => 'news',
                    'action'        => 'getProductLike',
                ]
            )
            ->setName( 'get_product_like' );

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/slider_index',
                [
                    'controller'    => 'slider',
                    'action'        => 'index',
                ]
            )
            ->setName( 'slider_index' );


        $router->add
            (
                '/slider_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'slider',
                    'action'        => 'index',
                ]
            )
            ->setName( 'slider_index_paged' );

        $router->add
            (
                '/slider_add',
                [
                    'controller'    => 'slider',
                    'action'        => 'add',
                ]
            )
            ->setName( 'slider_add' );


        $router->add
            (
                '/slider_update/{id:[0-9]+}',
                [
                    'controller'    => 'slider',
                    'action'        => 'update',
                ]
            )
            ->setName( 'slider_update' );


        $router->add
            (
                '/slider_delete/{id:[0-9]+}',
                [
                    'controller'    => 'slider',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'slider_delete' );
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/navigation_index',
                [
                    'controller'    => 'navigation',
                    'action'        => 'index',
                ]
            )
            ->setName( 'navigation_index' );




        $router->add
            (
                '/navigation_add',
                [
                    'controller'    => 'navigation',
                    'action'        => 'add',
                ]
            )
            ->setName( 'navigation_add' );


        $router->add
            (
                '/navigation_update/{id:[0-9]+}',
                [
                    'controller'    => 'navigation',
                    'action'        => 'update',
                ]
            )
            ->setName( 'navigation_update' );


        $router->add
            (
                '/navigation_delete/{id:[0-9]+}',
                [
                    'controller'    => 'navigation',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'navigation_delete' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////


        $router->add
            (
                '/customers_index',
                [
                    'controller'    => 'customers',
                    'action'        => 'index',
                ]
            )
            ->setName( 'customers_index' );


        $router->add
            (
                '/customers_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'customers',
                    'action'        => 'index',
                ]
            )
            ->setName( 'customers_index_paged' );

        $router->add
            (
                '/customers_add',
                [
                    'controller'    => 'customers',
                    'action'        => 'add',
                ]
            )
            ->setName( 'customers_add' );


        $router->add
            (
                '/customers_update/{id:[0-9]+}',
                [
                    'controller'    => 'customers',
                    'action'        => 'update',
                ]
            )
            ->setName( 'customers_update' );


        $router->add
            (
                '/customers_delete/{id:[0-9]+}',
                [
                    'controller'    => 'customers',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'customers_delete' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////


        $router->add
            (
                '/users_group_index',
                [
                    'controller'    => 'groups',
                    'action'        => 'index',
                ]
            )
            ->setName( 'users_group_index' );


        $router->add
            (
                '/users_group_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'groups',
                    'action'        => 'index',
                ]
            )
            ->setName( 'users_group_index_paged' );

        $router->add
            (
                '/users_group_add',
                [
                    'controller'    => 'groups',
                    'action'        => 'add',
                ]
            )
            ->setName( 'users_group_add' );


        $router->add
            (
                '/users_group_update/{id:[0-9]+}',
                [
                    'controller'    => 'groups',
                    'action'        => 'update',
                ]
            )
            ->setName( 'users_group_update' );


        $router->add
            (
                '/users_group_delete/{id:[0-9]+}',
                [
                    'controller'    => 'groups',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'users_group_delete' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////



        $router->add
            (
                '/email_templates_index',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'index',
                ]
            )
            ->setName( 'email_templates_index' );


        $router->add
            (
                '/email_templates_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'index',
                ]
            )
            ->setName( 'email_templates_index_paged' );

        $router->add
            (
                '/email_templates_add',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'add',
                ]
            )
            ->setName( 'email_templates_add' );


        $router->add
            (
                '/email_templates_update/{id:[0-9]+}',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'update',
                ]
            )
            ->setName( 'email_templates_update' );


        $router->add
            (
                '/email_templates_delete/{id:[0-9]+}',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'email_templates_delete' );


        $router->add
            (
                '/email_templates_get_one_data',
                [
                    'controller'    => 'email_templates',
                    'action'        => 'ajax',
                ]
            )
            ->setName( 'email_templates_get_one_data' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////


        $router->add
            (
                '/event_email_index',
                [
                    'controller'    => 'event_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'event_email_index' );


        $router->add
            (
                '/event_email_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'event_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'event_email_index_paged' );

        $router->add
            (
                '/event_email_add',
                [
                    'controller'    => 'event_email',
                    'action'        => 'add',
                ]
            )
            ->setName( 'event_email_add' );


        $router->add
            (
                '/event_email_update/{id:[0-9]+}',
                [
                    'controller'    => 'event_email',
                    'action'        => 'update',
                ]
            )
            ->setName( 'event_email_update' );


        $router->add
            (
                '/event_email_delete/{id:[0-9]+}',
                [
                    'controller'    => 'event_email',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'event_email_delete' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////


        $router->add
            (
                '/standard_email_index',
                [
                    'controller'    => 'standard_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'standard_email_index' );


        $router->add
            (
                '/standard_email_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'standard_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'standard_email_index_paged' );

        $router->add
            (
                '/standard_email_add',
                [
                    'controller'    => 'standard_email',
                    'action'        => 'add',
                ]
            )
            ->setName( 'standard_email_add' );


        $router->add
            (
                '/standard_email_update/{id:[0-9]+}',
                [
                    'controller'    => 'standard_email',
                    'action'        => 'update',
                ]
            )
            ->setName( 'standard_email_update' );


        $router->add
            (
                '/standard_email_delete/{id:[0-9]+}',
                [
                    'controller'    => 'standard_email',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'standard_email_delete' );

            $router->add
                (
                    '/standard_email_getuserslike',
                    [
                        'controller'    => 'standard_email',
                        'action'        => 'getuserslike',
                    ]
                )
                ->setName( 'standard_email_getuserslike' );
        ///////////////////////////////////////////////////////////////////////////////////////////////////////



        $router->add
            (
                '/admin_email_index',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'admin_email_index' );


        $router->add
            (
                '/admin_email_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'index',
                ]
            )
            ->setName( 'admin_email_index_paged' );

        $router->add
            (
                '/admin_email_add',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'add',
                ]
            )
            ->setName( 'admin_email_add' );


        $router->add
            (
                '/admin_email_update/{id:[0-9]+}',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'update',
                ]
            )
            ->setName( 'admin_email_update' );


        $router->add
            (
                '/admin_email_delete/{id:[0-9]+}',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'admin_email_delete' );

        $router->add
            (
                '/admin_email_getuserslike',
                [
                    'controller'    => 'admin_email',
                    'action'        => 'getuserslike',
                ]
            )
            ->setName( 'admin_email_getuserslike' );
        ///////////////////////////////////////////////////////////////////////////////////////////////////////



        $router->add
            (
                '/excel_worker_index',
                [
                    'controller'    => 'excel_worker',
                    'action'        => 'index',
                ]
            )
            ->setName( 'excel_worker_index' );


        $router->add
            (
                '/excel_worker_work',
                [
                    'controller'    => 'excel_worker',
                    'action'        => 'getdata',
                ]
            )
            ->setName( 'excel_worker_work' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////



        $router->add
            (
                '/delivery_index',
                [
                    'controller'    => 'delivery',
                    'action'        => 'index',
                ]
            )
            ->setName( 'delivery_index' );



        $router->add
            (
                '/delivery_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'delivery',
                    'action'        => 'index',
                ]
            )
            ->setName( 'delivery_index_paged' );

        $router->add
            (
                '/delivery_add',
                [
                    'controller'    => 'delivery',
                    'action'        => 'add',
                ]
            )
            ->setName( 'delivery_add' );


        $router->add
            (
                '/delivery_update/{id:[0-9]+}',
                [
                    'controller'    => 'delivery',
                    'action'        => 'update',
                ]
            )
            ->setName( 'delivery_update' );


        $router->add
            (
                '/delivery_more_info/{id:[a-z\_]+}',
                [
                    'controller'    => 'delivery',
                    'action'        => 'moreinfo',
                ]
            )
            ->setName( 'delivery_more_info' );



        $router->add
            (
                '/delivery_delete/{id:[0-9]+}',
                [
                    'controller'    => 'delivery',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'delivery_delete' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        $router->add
            (
                '/headings_index',
                [
                    'controller'    => 'headings',
                    'action'        => 'index',
                ]
            )
            ->setName( 'headings_index' );



        $router->add
            (
                '/headings_index/page/{page:[0-9]+}',
                [
                    'controller'    => 'headings',
                    'action'        => 'index',
                ]
            )
            ->setName( 'headings_index_paged' );

        $router->add
            (
                '/headings_add',
                [
                    'controller'    => 'headings',
                    'action'        => 'add',
                ]
            )
            ->setName( 'headings_add' );


        $router->add
            (
                '/headings_update/{id:[0-9]+}',
                [
                    'controller'    => 'headings',
                    'action'        => 'update',
                ]
            )
            ->setName( 'headings_update' );


        $router->add
            (
                '/headings_more_info/{id:[a-z\_]+}',
                [
                    'controller'    => 'headings',
                    'action'        => 'moreinfo',
                ]
            )
            ->setName( 'headings_more_info' );



        $router->add
            (
                '/headings_delete/{id:[0-9]+}',
                [
                    'controller'    => 'headings',
                    'action'        => 'delete',
                ]
            )
            ->setName( 'headings_delete' );

        $router->add
        (
            '/get_price_list',
            [
                'controller'    => 'seo',
                'action'        => 'getPriceList',
            ]
        )
            ->setName( 'get_price_list' );
	
	$router->add
        (
            '/get_users_list',
            [
                'controller'    => 'seo',
                'action'        => 'getUsersList',
            ]
        )
            ->setName( 'get_users_list' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////////

	
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

    ///////////////////////////////////////////////////////////////////////////
	
    // RubricsNews

    $di->set( 'RubricsNews', function()
    {
        $RubricsNews = new \Phalcon\Mvc\RubricsNews();

        $RubricsNews->setBaseUri('/');

        return $RubricsNews;
    }, true );

    ///////////////////////////////////////////////////////////////////////////	

    // cache

    $di->set( 'cache', function()
    {
        $cache = new \Phalcon\Cache\Frontend\Data([
            'lifetime' => 60,
        ]);

        return new \Phalcon\Cache\Backend\Apc( $cache );
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // i18n


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




    // language

    $di->set( 'language', function()
    {
        return new \language();
    }, true );

    ///////////////////////////////////////////////////////////////////////////
    //sms

    $di->set( 'sms', function()
    {
        return new \sms();
    }, true );

    //seo_url

    $di->set( 'seoUrl', function()
    {
        return new \seoUrl();
    }, true );
     //////////////////////////////////////////////////////////////////////////
    //UTMParser

    $di->set( 'UTMParser', function()
    {
        return new \UTMParser();
    }, true );
    ////////////////////////////////////////////////////////////////////////////
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

    // MyMailer

    $di->set( 'MyMailer', function()
    {
        return new \MyMailer();
    }, true );
    ///////////////////////////////////////////////////////////////////////////

    // forapprove

    $di->set( 'forapprove', function()
    {
        return new \forapprove();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // excelphp

    $di->set( 'excelphp', function()
    {
        return new \excelphp();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // session

    $di->set( 'session', function()
    {
        $session = new \Phalcon\Session\Adapter\Files();
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
        die();
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
        die();
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
        die();
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
