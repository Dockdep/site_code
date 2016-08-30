<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
use \Phalcon\Mvc\View;

class PageController extends \controllers\ControllerBase
{
    ///////////////////////////////////////////////////////////////////////////

    public function indexAction(  )
    {
        $titlecmp = function ($a, $b) {
            return strcasecmp($a['title'], $b['title']);
        };

        if($this->session->has('id') && $this->session->get('users_group_id') != null) {
            $users_group = $this->models->getUsersGroup()->getOneData($this->session->get('users_group_id'));
            $users_group_name = $users_group['0']['name'];
        } else {
            $users_group_name = \config::get('frontend#defaults/default_users_group');
        }

        $catalog = $this->common->getTypeSubtype1( NULL, $this->lang_id )['catalog'];
        foreach($catalog as $k => $v){
            usort($v['sub'] , $titlecmp);
            $catalog[$k] = $v;
        }
        $catalog_first = $catalog['1'];
        usort($catalog_first['sub'], $titlecmp);
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
        $stock_items        = $this->models->getItems()->getStockGroups($this->lang_id);

        $stock_items        = $this->common->explodeAlias($stock_items);
        $stock_items_       = $this->common->getGroups1( $this->lang_id, $stock_items );
        $total_stock_items  = $this->models->getItems()->getTotalStockItems();
        $pages_stock_items  = $total_stock_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_stock_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_stock_items['0']['total']/\config::get( 'limits/top_items' ) )+1);

        $prof_stock_items   = $this->models->getItems()->getProfStockGroups($this->lang_id);
        $prof_stock_items   = $this->common->explodeAlias($prof_stock_items);
        $prof_stock_items_  = $this->common->getGroups1( $this->lang_id, $prof_stock_items );
        $total_prof_stock_items  = $this->models->getItems()->getTotalProfStockGroups();
        $pages_prof_stock_items  = $total_prof_stock_items['0']['total']%\config::get( 'limits/top_items' ) == 0 ? $total_prof_stock_items['0']['total']/\config::get( 'limits/top_items' ) : (floor( $total_prof_stock_items['0']['total']/\config::get( 'limits/top_items' ) )+1);


        $news               = $this->models->getNews()->getNewsFor1Page( $this->lang_id, \config::get( 'dealer_rubric' ) );


        if( !empty( $news ) )
        {
            foreach( $news as $k => $n )
            {
                $news[$k]['image_big']      = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '180x120' ) : '';
                $news[$k]['image_small']    = !empty( $n['cover'] ) ? $this->storage->getPhotoUrl( $n['cover'], 'news', '135x100' ) : '';
                $news[$k]['link']           = $this->url->get([ 'for' => 'one_tips', 'tips_id' => $n['id'], 'tips_alias' => $n['alias'] ]);
            }
        }

        $videos             = $this->models->getNews()->getVideos( $this->lang_id, \config::get( 'dealer_rubric' ) );

        foreach( $videos as $k => $v )
        {
            $videos[$k]['options_'] = !empty( $v['options'] ) ? $this->etc->hstore2arr($v['options']) : '';

            if( !array_key_exists( 'is_news', $videos[$k]['options_'] ) )
            {
                $videos[$k]['link']   = $this->url->get([ 'for' => 'one_tips', 'tips_id' => $v['id'], 'tips_alias' => $v['alias'] ]);
            }
            else
            {
                $videos[$k]['link']   = $this->url->get([ 'for' => 'one_news', 'news_id' => $v['id'], 'news_alias' => $v['alias'] ]);
            }
        }
        $static_page_alias  = '/';

        unset($catalog['1']);

        $meta_title =
            [
                '1' => 'Професійне насіння поштою Україна | Купити насіння оптом Львів, Київ | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Профессиональные семена почтой Украина | Купить семена оптом Львов, Киев | Интернет магазин семян Semena.in.ua'
            ];

        $meta_description =
            [
                '1' => 'Неймовірні ціни на високоякісне насіння від виробника. Великий вибір професійного насіння овочів та квітів.',
                '2' => 'Невероятные цены на высококачественные семена от производителя. Большой выбор профессиональных семян овощей и цветов.'
            ];


        $slider = $this->models->getSlider()->getActiveData($this->lang_id);

        $active_sales = $this->models->getSales()->getActiveSales($this->lang_id);

        foreach($active_sales as $k => $sale) {
            $active_sales[$k]['link'] = $this->url->get([ 'for' => 'one_news', 'news_id' => $sale['id'], 'news_alias' => $sale['alias'] ]);
            $now = time();
            $current_year = date('Y');
            $current_month = date('m');
            $current_day = date('d');
            $left_date = (new \DateTime($sale['end_date']))->add(new \DateInterval('P1D'));
            $d = $left_date->format('d');
            $m = $left_date->format('m');
            if($current_month > $m || ($current_month == $m && $current_day > $d))
                $current_year++;
            $left_date->setDate($current_year , $m , $d);
            $timestamp_left = $left_date->getTimestamp();
            $active_sales[$k]['seconds_left'] = $timestamp_left - $now;
        }

        $css = [
            '/landing_sales/style.css',

            '/landing_sales/flipclock.css',

        ];

        $js = [
            '/landing_sales/flipclock.min.js'
        ];

        $this->view->setVars([
            'css' => $css,
            'js' => $js,
            'catalog'                   => $catalog,
            'catalog_first'             => $catalog_first,
            'top_items'                 => $top_items_,
            'new_items'                 => $new_items_,
            'recommended_items'         => $recommended_items_,
            'stock_items'               => $stock_items_,
            'prof_stock_items'          => $prof_stock_items_,
            'pages_top_items'           => $pages_top_items,
            'pages_new_items'           => $pages_new_items,
            'pages_recommended_items'   => $pages_recommended_items,
            'pages_stock_items'         => $pages_stock_items,
            'pages_prof_stock_items'    => $pages_prof_stock_items,
            'static_page_alias'         => $static_page_alias,
            'news'                      => $news,
            'videos'                    => $videos,
            'meta_title'                => $meta_title[$this->lang_id],
            'meta_description'          => $meta_description[$this->lang_id],
            'slider'                    => $slider,
            'active_sales'              => $active_sales
        ]);
    }


    public function typeAction( $type )
    {

        $lang_url = $this->seoUrl->getChangeLangUrl(array($type));
        $seo                = $this->seoUrl->getSeoData($this->models->getSeoInfo()->getAllSeo());
        $params             = $this->dispatcher->getParams();

        $type_child         = NULL;
        $catalog_elements   = [];

        if( strpos( $params['type'], '--' ) )
        {
            $type               = mb_substr( $params['type'], 0, strpos( $params['type'], '--' ) );
            $type_child         = trim( mb_substr( $params['type'], strpos( $params['type'], '--' ) ), '-' );

            $catalog_elements[] = $type;
            $catalog_elements[] = $type_child;
        }
        else
        {

            $type               = $params['type'];
            $catalog_elements[] = $type;
        }



        $catalog_temp           = $this->common->getTypeSubtype1( $catalog_elements, $this->lang_id );

        $catalog                = $catalog_temp['catalog'];
        $breadcrumbs            = $this->common->buildBreadcrumbs($catalog_temp);

        if( !empty( $catalog ) )
        {
            $meta_title =
                [
                    '1' => isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : '| Купити '.$catalog['title'].' Київ | Купити '.$catalog['title'].' поштою оптом Львів | Інтернет магазин насіння Semena.in.ua',
                    '2' => isset( $seo['title'] ) && !empty( $seo['title'] ) ?  $seo['title'] : '| Купить '.$catalog['title'].' Киев | Купить '.$catalog['title'].' почте оптом Львов | Интернет магазин семян Semena.in.ua'
                ];

            $meta_description =
                [
                    '1' => isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] :'Замовити '.$catalog['title'].' у Києві за найкращою ціною. Якість товара підтверджена професіоналами.',
                    '2' => isset( $seo['description'] ) && !empty( $seo['description'] ) ?  $seo['description'] :'Заказать '.$catalog['title'].' в Киеве по лучшей цене. Качество товара подтверждена профессионалами.'
                ];

            $this->view->setVars([
                'change_lang_url'   => $lang_url,
                'seo'               => $seo,
                'catalog'           => $catalog,
                'breadcrumbs'       => $breadcrumbs,
                'type_child'        => $type_child,
                'meta_title'        => $meta_title[$this->lang_id],
                'meta_description'  => $meta_description[$this->lang_id],
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


    public function subtypeAction( $type, $subtype, $sort = 0, $page = ''  )
    {
        if($this->session->get('special_users_id') != null) {
            return $this->response->redirect('dealer/catalog' . $_SERVER["REQUEST_URI"]);
        }

        $seo = $this->seoUrl->getSeoData($this->models->getSeoInfo()->getAllSeo());
        $params         = $this->dispatcher->getParams();
		$subtype = $params['subtype'];
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

            $limit = ((isset($_GET['all'])) ? 10000 : \config::get( 'limits/items', 5));
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

            if($sort[1]>0 && $sort[1]>0)
                $page_url_for_filter = [ 'for' => 'subtype_paged_sort', 'type' => $type_alias, 'subtype' => $subtype_alias, 'page' => $page,'sort0'=>$sort[0], 'sort'=>$sort[1] ];

            if( $total['0']['items'] > \config::get( 'limits/items') )
            {
                $paginate = $this->common->paginate(
                    [
                        'page'              => $page,
                        'items_per_page'    => ((isset($_GET['all'])) ? 10000 : \config::get( 'limits/items', 5)),
                        'total_items'       => $total['0']['items'],
                        'url_for'           => isset( $page_url_for_filter ) ? $page_url_for_filter : [ 'for' => 'subtype_paged', 'type' => $type_alias, 'subtype' => $subtype_alias, 'page' => $page ],
                        'index_page'       => 'subtype'
                    ], true
                );
            }

            $group_ids = $this->models->getItems()->getGroupIdsByCatalogId( $catalog_id );
            $group_ids = array_map(function($value) {
                return $value['group_id'];
            }, $group_ids);

            $active_sales = $this->models->getSales()->getActiveSales($this->lang_id);


            $catalog_sales = [];
            foreach($active_sales as $k => $sale) {
                $active_sales[$k]['group_ids'] = $this->common->parseArray($sale['group_ids']);
                if(!empty(array_intersect($active_sales[$k]['group_ids'], $group_ids))) {
                    $active_sales[$k]['link'] = $this->url->get([ 'for' => 'one_news', 'news_id' => $sale['id'], 'news_alias' => $sale['alias'] ]);
                    $catalog_sales[] = $active_sales[$k];
                }
            }

            $cssSale = [
                'https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic',
                '/landing_sales/style.css'
            ];
            $jsSale = [
                '/landing_sales/script.js'
            ];

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

        if($subtype==='semena_gazonnykh_trav_1c_21')
			$this->view->setMainView('landing');
        elseif($subtype==='nasinnja_gazonnikh_trav_1c1')
			$this->view->setMainView('landing_ukr');

			
		if(!empty($_GET['calc']))$this->view->setMainView('calc');
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
                'catalog_sales'             => $catalog_sales,
                'css'                       => $cssSale,
                'js'                        => $jsSale
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


    public function filtersAction( $type, $subtype, $filter_ids = '', $filter_alias = '', $price = '', $sort = '', $page = 1 )
    {
        if($this->session->get('special_users_id') != null) {
            return $this->response->redirect('dealer/catalog' . $_SERVER["REQUEST_URI"]);
        }
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

        $min_prices = array_map(function($value) {
            return $value['min_price'];
        }, $groups_);


//        $max_min_price       = $this->models->getItems()->getMaxMinPriceWithCatalogId( $catalog_id );

        $max_min_price[0]['min_price'] = min($min_prices);
        $max_min_price[0]['max_price'] = max($min_prices);

        $paginate = '';

        if( $total > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/items', 5),
                    'total_items'       => $total,
                    'url_for'           => isset( $page_url_for_filter ) ? $page_url_for_filter : [ 'for' => 'subtype_paged', 'type' => $catalog['type_alias'], 'subtype' => $catalog['subtype_alias'], 'page' => $page ],
                    'index_page'       => 'subtype'
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

        $group_ids = $this->models->getItems()->getGroupIdsByCatalogId( $catalog_id );
        $group_ids = array_map(function($value) {
            return $value['group_id'];
        }, $group_ids);

        $active_sales = $this->models->getSales()->getActiveSales($this->lang_id);

        $catalog_sales = [];
        foreach($active_sales as $k => $sale) {
            $active_sales[$k]['group_ids'] = $this->common->parseArray($sale['group_ids']);
            if(!empty(array_intersect($active_sales[$k]['group_ids'], $group_ids))) {
                $active_sales[$k]['link'] = $this->url->get([ 'for' => 'one_news', 'news_id' => $sale['id'], 'news_alias' => $sale['alias'] ]);
                $catalog_sales[] = $active_sales[$k];
            }
        }

        $cssSale = [
            'https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic',
            '/landing_sales/style.css'
        ];
        $jsSale = [
            '/landing_sales/script.js'
        ];
        $this->view->pick('page/subtype');

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
            'catalog_sales'             => $catalog_sales,
            'css' => $cssSale,
            'js' => $jsSale
        ]);
    }


    public function itemAction( $type, $subtype, $group_alias, $item_id )
    {
        if($this->session->get('special_users_id') != null) {
            return $this->response->redirect('dealer' . $_SERVER["REQUEST_URI"]);
        }

        $looked         = $this->session->get('looking_items', []);
        $looked[]       = $item_id;
        $looked         = array_unique( $looked );
        $looked         = array_reverse( $looked );
        $looked         = array_chunk( $looked, 5 );
        $this->session->set( 'looking_items', array_reverse($looked['0']) );

        $params = $this->dispatcher->getParams();
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
        $breadcrumbs    = $this->common->buildBreadcrumbs($catalog);

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

            $active_size = -1;
            foreach ($sizes as $k => &$s) {
                $s['link'] = $this->url->get(['for' => 'item', 'type' => $type_alias, 'subtype' => $subtype_alias, 'group_alias' => $group_alias, 'item_id' => $s['id']]);
                $s['image'] = !empty($s['cover']) ? $this->storage->getPhotoUrl($s['cover'], 'avatar', 'color') : '';

                if($active_size == -1) {
                    $active_size = $s['status'] == 1 ? $k : $active_size;
                }

                if (!empty($s['color_id'])) {
                    $sizes_colors['sizes'][] = $s['size'];
                    $sizes_colors['colors'][] = $s['color_id'];
                    $sizes_colors__[$s['color_id']][$s['size']] = $s;

                }
            }
            if($active_size == -1) {
                $active_size = 0;
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
                $news[$k]['link'] = $this->url->get(['for' => 'one_tips', 'tips_id' => $n['id'], 'tips_alias' => $n['alias']]);
            }

            // get popular items_groups
//
//            $popular_groups = $this->models->getItems()->getPopularItems($this->lang_id);
//            $popular_groups = $this->common->explodeAlias($popular_groups);
//
//
//            $recommended_items = $this->models->getItems()->getRecommendedGroups($this->lang_id, \config::get( 'limits/top_items' ));
//            $recommended_items = $this->common->explodeAlias($recommended_items);
//            $popular_groups_ = $this->common->getGroups1($this->lang_id, $recommended_items);

            $groups = $this->models->getItems()->getBuyWithItems( $this->lang_id, $item['0']['group_id'] );
            foreach( $groups as &$p )
            {
                $p['explode']       = explode( '/', $p['catalog_alias'] );
                $p['type_alias']    = $p['explode']['1'];
                $p['subtype_alias'] = $p['explode']['2'];
                unset( $p['explode'] );
            }


            $popular_groups_         = $this->common->getGroups1( $this->lang_id, $groups );



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


            $this->view->setVars([
                'change_lang_url'   => $lang_url,
                'catalog'           => $catalog,
                'item'              => $item['0'],
                'group_alias'       => $group_alias,
                'item_id'           => $item_id,
                'properties'        => $properties,
                'filters'           => $filters,
                'active_size'       => $active_size,
                'sizes'             => $sizes,
                'sizes_colors'      => $sizes_colors,
                'sizes_colors__'    => $sizes_colors__,
                'seo'               => $seo,
                'popular_groups'    => $popular_groups_,
                'news'              => $news,
                'meta_title'        => $meta_title[$this->lang_id],
                'meta_description'  => $meta_description[$this->lang_id],
                'breadcrumbs'       => $breadcrumbs,
                'catalog_id'        => $catalog_id,
                'type_alias'                => $type_alias,
                'subtype_alias'             => $subtype_alias
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


    public function topItemsAction()
    {
        $groups  = [];

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $block_class    = $this->request->getPost( 'block_class', 'string', '' );
            $page           = $this->request->getPost( 'next_page', 'string', '' );
            $news_id        = $this->request->getPost( 'news_id', 'string', '' );
        }

        $limit = 5;

        switch( $block_class )
        {
            case 'top_items':
            default:
                $groups = $this->models->getItems()->getTopGroups( $this->lang_id, $limit, $page );
                break;

            case 'recomended_items':
                $groups = $this->models->getItems()->getRecommendedGroups( $this->lang_id, $limit, $page );
                break;
            case 'new_items':
                $groups = $this->models->getItems()->getNewGroups( $this->lang_id, $limit, $page );
                break;
            case 'stock_items':
                $groups = $this->models->getItems()->getStockGroups( $this->lang_id, $limit, $page );
                break;
            case 'prof_stock_items':
                $groups = $this->models->getItems()->getProfStockGroups( $this->lang_id, $limit, $page );
                break;

            case 'recomended_groups':
                $groups_ids = $this->models->getNews()->getGroupsIdsByNewsId( $this->lang_id,$news_id );

                if( !empty( $groups_ids ) )
                {
                    $news2groups_ids_   = $this->etc->int2arr($groups_ids['0']['group_id']);

                    $news2groups_ids    = array_chunk( $news2groups_ids_, \config::get( 'limits/groups2news' ) );

                    $groups            = $this->models->getItems()->getNews2Groups( $this->lang_id, $news2groups_ids[$page-1] );

                }
                break;
        }

            $groups          = $this->common->explodeAlias( $groups );
            $groups_         = $this->common->getGroups1( $this->lang_id, $groups );

            foreach($groups_ as $key=>$g){
                $groups_[$key]['title'] = \plugins::getShortText($groups_[$key]['title'],20);
            }


        die( json_encode( $groups_ ) );

    }


    public function changeWithSizeAction()
    {

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id        = $this->request->getPost( 'item_id', 'int', '' );
            $group_alias    = $this->request->getPost( 'group_alias', 'string', '' );

            $item           = $this->models->getItems()->getOneItem( $this->lang_id, $item_id );
            $filters        = $this->models->getFilters()->getFiltersByItemId( $this->lang_id, $item_id );

            $colors_info    = $this->models->getItems()->getColorsInfoByColorId( $this->lang_id, $item['0']['color_id'] );

            $item['0']['color_title']       = NULL;
            $item['0']['absolute_color']    = NULL;
            $item['0']['color']             = NULL;

            if( !empty( $colors_info ) )
            {
                $item['0']['color_title']       = $colors_info['0']['color_title'];
                $item['0']['absolute_color']    = $colors_info['0']['absolute_color'];


                $item['0']['color']             =
                    '<div class="float properties">'.$this->languages->getTranslation()->_("choose_color").': </div>'.
                    '<div class="float properties" style="color:'.$colors_info['0']['absolute_color'].'">'.$colors_info['0']['color_title'].'</div>';
            }

            $item['0']['explode']       = explode( '/', $item['0']['full_alias'] );
            $item['0']['type_alias']    = $item['0']['explode']['1'];
            $item['0']['subtype_alias'] = $item['0']['explode']['2'];
            unset( $item['0']['explode'] );

            $item['0']['alias']             = $this->url->get([ 'for' => 'item', 'type' => $item['0']['type_alias'], 'subtype' => $item['0']['subtype_alias'], 'group_alias' => $group_alias, 'item_id' => $item_id ]);
            $item['0']['filters']           = $filters;
            $item['0']['images']            = $this->etc->int2arr( $item['0']['photogallery'] );
			$item['0']['status_real']		= $item['0']['status'];
            $item['0']['status']            = $item['0']['status'] == 1 ? '<div data-stock="'.$item['0']['status'].'" id="stock" class="properties properties_presence ">'.$this->languages->getTranslation()->_("in_stock").'</div>' : ($item['0']['status'] == 2 ? '<div data-stock="'.$item['0']['status'].'" id="stock" class="properties properties_absent">'.$this->languages->getTranslation()->_("znyt").'</div>' : '<div data-stock="'.$item['0']['status'].'" id="stock" class="properties properties_absent">'.$this->languages->getTranslation()->_("missing").'</div>');
            $item['0']['image']             = '';
			

                $item['0']['image'] .=
                    '<li class="float width_400">'.
                    '<a href="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '400x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '800x' ).'\'"  class="thumbnail">'.
                    '<img src="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '400x' ).'" alt="'.$item['0']['title'].'" class="image_400">'.
                    '</a>'.
                    '</li>';

            if( !empty( $item['0']['images'] ) && !empty( $item['0']['cover'] ) )
            {
                foreach( $item['0']['images'] as $k => $i )
                {

                        $item['0']['image'] .=
                            '<li class="float width_128 '.($k%3==0 ? 'last' : '').'">'.
                            '<a href="'.$this->storage->getPhotoUrl( $i, 'group', '800x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'\'"  class="thumbnail">'.
                            '<img src="'.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'" alt="'.$item['0']['title'].'" class="image_128">'.
                            '</a>'.
                            '</li>';

                }

                $item['0']['image']  .=
                    '<li class="float width_128 '.(count($item['0']['images'])%3==0 ? 'last' : '').'">'.
                    '<a href="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '800x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '128x' ).'\'"  class="thumbnail">'.
                    '<img src="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '128x' ).'" alt="'.$item['0']['title'].'" class="image_128">'.
                    '</a>'.
                    '</li>';
            }

        }

        if($this->session->get('special_users_id') != null) {
            $special_users_id = $this->session->get('special_users_id');

            $special_user = $this->models->getSpecialUsers()->getOneData($special_users_id)[0];
            $special_users = $this->models->getSpecialUsers()->getAllData($this->lang_id, 0);

            $item[0]['prices'] = $this->common->getPricesArray($item[0]);

            $this->view->setVars([
                'special_users'     => $special_users,
                'special_user'      => $special_user
            ]);
        }

        $this->view->pick('page/changeWithSize');
        $this->view->setVars([
            'item' => $item['0']
        ]);
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }


    public function changeWithColorAction()
    {
        $this->lang_id = $this->seoUrl->getLangId();

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $item_id            = $this->request->getPost( 'item_id', 'int', '' );
            $catalog_id     = $this->request->getPost( 'catalog_id', 'int', '' );
            $group_id           = $this->request->getPost( 'group_id', 'int', '' );
            $group_alias        = $this->request->getPost( 'group_alias', 'string', '' );
            $color_id           = $this->request->getPost( 'color_id', 'string', '' );
            $current_item_size  = $this->request->getPost( 'current_item_size', 'string', '' );

            $group              = $this->models->getItems()->getItemsByColorAndGroupId( $group_id );

            $item_id_needed = $item_id;

            foreach( $group as $g )
            {
                if( $g['size'] == $current_item_size && $g['color_id'] == $color_id )
                {
                    $item_id_needed = $g['id'];
                }

                $sizes[] = $g['size'];

                $sizes_colors[$g['color_id']][$g['size']] =
                    [
                        'id' => $g['id']
                    ];
				
            }

            $item           = $this->models->getItems()->getOneItem( $this->lang_id, $item_id_needed );
            $filters        = $this->models->getFilters()->getFiltersByItemId( $this->lang_id, $item_id );

            $colors_info    = $this->models->getItems()->getColorsInfoByColorId( $this->lang_id, $item['0']['color_id'] );

            $item['0']['color_title']       = NULL;
            $item['0']['absolute_color']    = NULL;
            $item['0']['color']             = NULL;

            if( !empty( $colors_info ) )
            {
                $item['0']['color_title']       = $colors_info['0']['color_title'];
                $item['0']['absolute_color']    = $colors_info['0']['absolute_color'];


                $item['0']['color']             =
                    '<div class="float properties">'.$this->languages->getTranslation()->_("choose_color").': </div>'.
                    '<div class="float properties" style="color:'.$colors_info['0']['absolute_color'].'">'.$colors_info['0']['color_title'].'</div>';
            }

            $item['0']['sizes'] = NULL;

            if( !empty( $sizes ) )
            {
                $sizes = array_unique( $sizes );

                $i = 0;

                foreach( $sizes as $key=>$s )
                {
                    if( isset( $sizes_colors[$item['0']['color_id']][$s] ) )
                    {
                        $item['0']['sizes'] .=
                            '<a href="#" class="group_sizes'.($s == $item['0']['size'] ? ' active' : '').' exist" style="padding-top:'.($i*3).'px; width:'.(31+($i*3)).'px" data-item_id="'.$sizes_colors[$item['0']['color_id']][$s]['id'].'" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                            '<span class="group_sizes_header"></span>'.
                            '<span class="group_sizes_content">'.$s.'</span>'.
                            '</a>';
                    }
                    else
                    {
                        $item['0']['sizes'] .=
                            '<a href="#" onClick="return false;" class="group_sizes'.($s == $item['0']['size'] ? ' active' : '').' not_exist" style="padding-top:'.($i*3).'px; width:'.(31+($i*3)).'px" data-item_id="" data-catalog_id="'.$catalog_id.'" data-group_alias="'.$group_alias.'">'.
                            '<span class="group_sizes_header"></span>'.
                            '<span class="group_sizes_content">'.$s.'</span>'.
                            '</a>';
                    }
                    $i++;
                }
            }


            $item['0']['explode']       = explode( '/', $item['0']['full_alias'] );
            $item['0']['type_alias']    = $item['0']['explode']['1'];
            $item['0']['subtype_alias'] = $item['0']['explode']['2'];
            unset( $item['0']['explode'] );


            $item['0']['alias']             = $this->url->get([ 'for' => 'item', 'type' => $item['0']['type_alias'], 'subtype' => $item['0']['subtype_alias'], 'group_alias' => $group_alias, 'item_id' => $item_id ]);
            $item['0']['filters']           = $filters;
            $item['0']['images']            = $this->etc->int2arr( $item['0']['photogallery'] );
            $item['0']['status']            = $item['0']['status'] == 1 ? '<div data-stock="'.$item['0']['status'].'" id="stock" class="properties properties_presence ">'.$this->languages->getTranslation()->_("in_stock").'</div>' : '<div data-stock="'.$item['0']['status'].'" id="stock" class="properties properties_presence ">'.$this->languages->getTranslation()->_("missing").'</div>';

            $item['0']['image']             = '';


                $item['0']['image'] .=
                    '<li class="float width_400">'.
                    '<a href="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '400x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '800x' ).'\'"  class="thumbnail">'.
                    '<img src="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '400x' ).'" alt="'.$item['0']['title'].'" class="image_400">'.
                    '</a>'.
                    '</li>';

            if( !empty( $item['0']['images'] ) && !empty( $item['0']['cover'] ) )
            {
                foreach( $item['0']['images'] as $k => $i )
                {
                    $item['0']['image'] .=
                        '<li class="float width_128 '.($k%3==0 ? 'last' : '').'">'.
                        '<a href="'.$this->storage->getPhotoUrl( $i, 'group', '800x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'\'"  class="thumbnail">'.
                        '<img src="'.$this->storage->getPhotoUrl( $i, 'group', '128x128' ).'" alt="'.$item['0']['title'].'" class="image_128">'.
                        '</a>'.
                        '</li>';
                }

                $item['0']['image']  .=
                    '<li class="float width_128 '.(count($item['0']['images'])%3==0 ? 'last' : '').'">'.
                    '<a href="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '800x' ).'" title="'.$item['0']['title'].'"  data-options="thumbnail: \''.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '128x' ).'\'"  class="thumbnail">'.
                    '<img src="'.$this->storage->getPhotoUrl( $item['0']['cover'], 'avatar', '128x' ).'" alt="'.$item['0']['title'].'" class="image_128">'.
                    '</a>'.
                    '</li>';
            			
            }			


            $properties     = $this->models->getProperties()->getPropertiesByItemId( $this->lang_id, $item_id );

            $item['0']['properties']  = '';

            if( !empty( $properties ) )
            {
                foreach( $properties as $p )
                {
                    $item['0']['properties']  .=
                        '<div class="clearfix">'.
                        '<p class="float key_value">'.$p['key_value'].':</p>'.
                        '<a class="float" href="#">'.$p['value_value'].'</a>'.
                        '</div>';
                }
            }
        }

        die(json_encode($item) );
    }


    public function changeSimilarItemsAction()
    {
        $groups     = [];
        $groups_    = [];

        if( $this->request->isAjax() && $this->request->isPost() )
        {
            $catalog_id     = $this->request->getPost( 'catalog_id', 'int', '' );
            $group_id       = $this->request->getPost( 'group_id', 'int', '' );
            $similar        = $this->request->getPost( 'similar', 'string', '' );

            switch( $similar )
            {
                case 'popular':
                default:
                    $recommended_items    = $this->models->getItems()->getRecommendedGroups($this->lang_id, \config::get( 'limits/top_items' ));
                    $groups    = $this->common->explodeAlias($recommended_items);

                    break;

                case 'same':
                    $groups = $this->models->getItems()->getSameItems( $this->lang_id, $catalog_id );
                    break;

                case 'buy_with':
                    $groups = $this->models->getItems()->getBuyWithItems( $this->lang_id, $group_id );
                    break;

                case 'viewed':
                    $looked     = $this->session->get('looking_items', []);

                    if( !empty( $looked ) )
                    {
                        $groups_looked   = $this->models->getItems()->getLookedGroups( $this->lang_id, $looked );
                        $groups_temp     = [];

                        foreach( $looked as $l )
                        {
                            foreach( $groups_looked as &$g )
                            {
                                if( $l == $g['id'] )
                                {
                                    $groups_temp[$l] = $g;
                                }
                            }
                        }

                        foreach( $groups_temp as $g )
                        {
                            $groups[] = $g;
                        }
                    }

                    break;
            }

            foreach( $groups as &$p )
            {
                $p['explode']       = explode( '/', $p['catalog_alias'] );
                $p['type_alias']    = $p['explode']['1'];
                $p['subtype_alias'] = $p['explode']['2'];
                unset( $p['explode'] );
            }


            $groups_         = $this->common->getGroups1( $this->lang_id, $groups );
        }

        die( json_encode( $groups_ ) );
    }


    public function searchAction( $search = '', $page = 1 )
    {
        if($this->session->get('special_users_id') != null) {
            return $this->response->redirect('dealer/search?search='.$search);
        }

	    if($s = $this->request->get('search', 'string', NULL ))
            $search = $s;

        $items_         = $this->models->getItems()->getItemsByTerm( $search, 'items', $page, $this->lang_id );

        $total_items    = $this->models->getItems()->getTotalItemsByTerm( $search ,$this->lang_id);

        $items          = [];

        if( !empty( $items_ ) )
        {
            $items_ids  = $this->common->array_column( $items_, 'item_id' );
            $items      = $this->models->getItems()->getItemsByIds( $this->lang_id, $items_ids );

            foreach( $items as &$i )
            {
                $i['cover']         = !empty( $i['group_cover'] ) ? $this->storage->getPhotoUrl( $i['group_cover'], 'avatar', '200x' ) : '/images/packet.jpg';
                $i['alias']         = $this->url->get([ 'for' => 'item', 'type' => $i['type_alias'], 'subtype' => $i['subtype_alias'], 'group_alias' => $i['group_alias'], 'item_id' => $i['id'] ]);
                $i['price']         = $i['price2'];
                $i['type_id']       = $i['type'];
                $i['id']            = $i['group_id'];

                $i['options_'] = $this->etc->hstore2arr($i['options']);

                $i['is_new'] = !empty( $i['options_']['is_new'] ) ? $i['options_']['is_new'] : '0';
                $i['is_top'] = !empty( $i['options_']['is_top'] ) ? $i['options_']['is_top'] : '0';

                unset($i['options_']);
                unset($i['options']);
            }
        }


        if( $total_items['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'             => $page,
                    'items_per_page'   => \config::get( 'limits/items', 5),
                    'total_items'      => $total_items['0']['total'],
                    'url_for'          => [ 'for' => 'search_items_paged', 'search' => $search, 'page' => $page ],
                    'index_page'       => 'search_items_route'
                ], true
            );
        }

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

        $this->view->setVars([
            'groups'        => $items,
            'page'          => $page,
            'search'        => $search,
            'total'         => $total_items['0']['total'],
            'no_robots'     => 1,
            'meta_link_next'            => $meta_link_next[1],
            'meta_link_prev'            => $meta_link_prev[1],
            'paginate'                  => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }


    public function compareItemsDelAction( $type, $subtype, $compare_ids  ){

        $lang = $this->session->get('language');
        $compare        = $this->session->get('compare', []);
        $url = '';
        $id_arr = explode('-', $compare_ids);

        foreach($id_arr as $id){

            foreach( $compare as $key => $comp )
            {
                foreach( $comp as $k => $c )
                {
                    $url = $this->url->get([ 'for' => 'compare_items',  'subtype' => $subtype, 'compare_ids' => join( '-', array_diff( $c, [$id] )) ]);
                    foreach($c as $key2=>$_c){

                        if($_c == $id){unset($_SESSION['compare'][$key][$k][$key2]);}

                    }

                    if(count($_SESSION['compare'][$key][$k])==0){
                
                        unset($_SESSION['compare'][$key][$k]);
                        header(!empty($lang) ? "Location:".$lang : 'Location:/');
                        die();
                    }

                }
            }

        }

        header('Location:/'.$type.$url.$this->lang_name );
        die();
    }


    public function compareItemsAction( $url, $subtype, $compare_ids)
    {
        $params         = $this->dispatcher->getParams();
        $types = $params['url'];
        $subtypes = $params['subtype'];

        $lang_url = $this->seoUrl->getChangeLangUrl(array($types,$subtypes));

        if( empty( $compare_ids ) )
        {
            return $this->response->redirect([ 'for' => 'homepage', 'language' => $this->lang_name  ]);
        }
        $catalog = '/'.$url.'/'.$subtype;
        $items_ids              = explode( '-', $compare_ids );
        $prod_text = '';
        $items                  = $this->models->getItems()->getItemsByIds( $this->lang_id, $items_ids );
        $properties             = $this->models->getProperties()->getPropertiesByTypeSubtype( $catalog,$this->lang_id ); // for cache
        $properties_for_items   = $this->models->getProperties()->getPropertiesForItems( $items_ids );
        foreach($items_ids as $items_id){
            $filters[$items_id]        = $this->models->getFilters()->getFiltersByItemId( $this->lang_id, $items_id );
            foreach( $filters[$items_id]  as $f ){
                if($f['key_value'] == $this->languages->getTranslation()->_("producer")){
                    $prod_text .='<td>'.$f['value_value'].'</td>';
                }
            }
        }
        $num = count($items);
        for($i=0; $i<$num; $i++){
            $items[$i]['full_alias'] = $this->models->getCatalog()->getFullAlias($this->lang_id, $items[$i]['catalog'])[0]['full_alias'];
        }

        foreach( $properties as $p )
        {
            $properties_[$p['id']] = $p;
            $properties_names[$p['property_key_id']] = $p['key_value'];
        }

        foreach( $properties_for_items as $p )
        {
            $properties_for_items_[$p['item_id']][] = $properties_[$p['property_id']];
        }

        foreach( $properties_for_items_ as $key => $val )
        {
            foreach( $val as $v )
            {
                $properties_for_items___[$v['key_value']][] = $v['value_value'];
            }
        }

        foreach( $properties_for_items___ as $p )
        {
            $count[] = count($p);
        }

        foreach( $items as &$i )
        {
            $i['cover']         = !empty( $i['group_cover'] ) ? $this->storage->getPhotoUrl( $i['group_cover'], 'avatar', '200x' ) : '/images/packet.jpg';
            $i['alias']         = $this->url->get([ 'for' => 'item','subtype' => $i['full_alias'], 'group_alias' => $i['group_alias'], 'item_id' => $i['id'] ]);
            $i['alias_del']     = $this->url->get([ 'for' => 'compare_items_del',  'subtype' => $i['full_alias'], 'compare_ids' => $i['id']  ]);
        }


        $this->view->setVars([
            'change_lang_url'      => $lang_url,
            'filters'               => $filters,
            'properties_names'      => array_unique($properties_names),
            'properties_for_items'  => $properties_for_items___,
            'items'                 => $items,
            'count'                 => max($count),
            'no_robots'             => 1,
            'prod_text'             => $prod_text
        ]);
    }


    public function error404Action(  )
    {
        $this->view->setVar( 'page_title', 'Ошибка 404: Не найдено | '.\config::get('global#title') );

        $meta_title =
            [
                '1' => 'Помилка 404: Не знайдено | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Ошибка 404: не найдено | Интернет магазин семян Semena.in.ua',
            ];

        $meta_description =
            [
                '1' => 'Помилка 404: Не знайдено | Інтернет магазин насіння Semena.in.ua',
                '2' => 'Ошибка 404: не найдено | Интернет магазин семян Semena.in.ua',
            ];

        $this->view->setVars([
            'meta_title'        => $meta_title[$this->lang_id],
            'meta_description'  => $meta_description[$this->lang_id],
            'no_robots'         => 1
        ]);
    }


    public function changelanguageAction(){
        $params = $this->dispatcher->getParams();
        $language = '/'.$params['new_language'];
        $this->session->set('compare', []);
        if($language == '/ua'){
            $language = '';
        }
        $this->session->set('language', $language);
        header(!empty($language) ? "Location:".$language : 'Location:/');
    }

}