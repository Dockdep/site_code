<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace
{
    /**
     * common
     *
     * @author      Roman Telychko
     * @version     0.1.20130712
     */
    class common extends \core
    {
        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::hashPasswd()
         *
         * @author      Roman Telychko
         * @version     3.0.20131010
         *
         * @param     string      $passwd
         * @return    string      $hash
         */
        public function hashPasswd( $passwd )
        {
            $salt1 = 'IKudI9k4sts40Spu1yAwcxeaD7umJ8aMAYt6Uj862VTHBh55sMi7DPRkvgckXK88ecj6aDy1Q0DYB28ZVuygR6rlqFoRFcKn45XT5gzbADbzNfBHxMgUmEnb79CyFx7O';            # pwgen -s 128
            $salt2 = 'JzbdFHvuEamXvr8jXWCHkoRqXwEQE86NwPH27vxsdp7T3ln1rk2Mbtu9ADAUIgxpDePe9jzT0KpQceQLTFMSl1fZjmYIl1jbRtlNcuFjUaHy5X0FE55MpT8Kf2xZZnGI';            # pwgen -s 128

            $hash = '//'.$salt1.'//'.base64_encode( $passwd ).'//';
            $pieces = str_split( $salt2, 10 );

            for( $i=0; $i<10000; $i++ )
            {
                $hash = hash( 'sha512', $pieces[( $i % 10 )].'|'.$hash );
            }

            return $hash;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::arraySortByColumn()
         *
         * @author      Roman Telychko
         * @version     0.1.20130712
         *
         * @param     	array        $arr
         * @param     	string       $column
         * @param     	integer      $direction
         * @return    	bool
         *//*
        public function arraySortByColumn( &$arr, $column, $direction = SORT_ASC )
        {
            $arr_column = [];

            foreach ($arr as $k => $d)
            {
                $arr_column[$k] = $d[$column];
            }

            array_multisort( $arr_column, $direction, $arr );
        }*/

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::array_column()
         *
         * @author      Roman Telychko
         * @version     0.1.20131030
         *
         * @param     	array        $arr
         * @param     	string       $column_key
         * @param     	string       $index_key
         * @return    	array
         */
        public function array_column( $arr, $column_key, $index_key = null )
        {
            if( empty($arr) )
            {
                return [];
            }

            $data   = [];
            $c      = 0;

            foreach( $arr as $a )
            {
                if( isset($a[$column_key]) )
                {
                    $data[ ( !empty($index_key) && isset($a[$index_key]) ) ? $a[$index_key] : $c ] = $a[$column_key];
                    $c++;
                }
            }

            return $data;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::paginate()
         *
         * @author          Roman Telychko
         * @version         0.1.20130627
         *
         * @param           array           $data
         * @param           bool            $return_output
         * @return          string
         */
        public function paginate( $data = [], $return_output = false )
        {
            $data = array_merge(
                [
                    'page'              => 1,
                    'items_per_page'    => 20,
                    'total_items'       => 0,
                    'url_for'           => [],
                    'links_count'       => 16,
                ],
                $data
            );

            if( empty($data['page']) || empty($data['total_items']) || empty($data['url_for']) )
            {
                return false;
            }

            if( $data['total_items'] <= $data['items_per_page'] )
            {
                return false;
            }

            // pages count
            $data['pages_count'] = intval( ceil( $data['total_items'] / $data['items_per_page'] ) );

            if( $data['page'] > $data['pages_count'] )
            {
                $data['page'] = $data['pages_count'];
            }
            elseif( $data['page'] < 1 )
            {
                $data['page'] = 1;
            }

            // links count
            if( $data['links_count'] <= $data['pages_count'] )
            {
                if( $data['page'] <= floor( $data['links_count'] / 2 ) + 1 )
                {
                    $start_i = 1;
                }
                else
                {
                    $start_i = $data['page'] - floor( $data['links_count'] / 2 );
                }

                $stop_i     = $start_i + $data['links_count'] - 1;

                if( $stop_i > $data['pages_count'] )
                {
                    $start_i    = $data['pages_count'] - $data['links_count'] + 1;
                    $stop_i     = $data['pages_count'];
                }
            }
            else
            {
                $start_i    = 1;
                $stop_i     = $data['pages_count'];
            }

            $url_obj = $this->getDi()->get('url');
            $firstPage = $data['url_for'];
            $firstPage['for'] = $data['index_page'];
            $output =
                '<ul class="clearfix">'.
                ( $data['page']==1 ? '' : '<li class="float"><a href="'.$this->getDi()->get('seoUrl')->setUrl(( $url_obj->get( $data['page']-1 != 1 ? (array_merge( $data['url_for'], [ 'page' => $data['page'] - 1 ])):  $firstPage ))).'" title="Previous ('.( ($data['page'] == 1) ? 1 : $data['page'] - 1 ).')" class="previous"><img src="/images/page_arrow_left.png" alt="previous" width="10" height="18" /></a></li>' );

            // build links
            //p($data['page'],1);
            for( $i = $start_i; $i <= $stop_i; $i++ )
            {
                $output .= '<li'.( ($data['page'] == $i) ? ' class="current"' : '' ).'><a href="'.$this->getDi()->get('seoUrl')->setUrl((($url_obj->get($i != 1 ? array_merge( $data['url_for'], [ 'page' => $i  ]) : $firstPage  )))).'" class="float'.( ($data['page'] == $i) ? ' current hover' : '' ).'" title="Page '.$i.'">'.$i.'</a></li>';
            }

            $output .=
                ( $data['page']==$data['pages_count'] ? '' : '<li class="float"><a href="'.$this->getDi()->get('seoUrl')->setUrl($url_obj->get( array_merge( $data['url_for'], [ 'page' => ( ($data['page'] + 1 == $data['pages_count']) ? $data['pages_count'] : $data['page'] + 1 ) ] ) )).'" title="Next ('.( ($data['page'] + 1 == $data['pages_count']) ? $data['pages_count'] : $data['page'] + 1 ).')" class="next"><img src="/images/page_arrow_right.png" alt="previous" width="10" height="18" /></a></li>' ).
                '</ul>';
            ($data['page'] != '1')            ? $meta_link_prev = '<link rel="prev" href="'.$this->getDi()->get('seoUrl')->setUrl($url_obj->get( (((int)$data['page'] - 1) != 1) ? array_merge( $data['url_for'], [ 'page' => (int)$data['page'] - 1 ] ) :$firstPage)).'" />' : $meta_link_prev = '';
            ($data['page'] != $data['pages_count']) ? $meta_link_next = '<link rel="next" href="'.$this->getDi()->get('seoUrl')->setUrl($url_obj->get( array_merge( $data['url_for'], [ 'page' => (int)$data['page'] + 1 ] ) )).'" />' : $meta_link_next = '';
            if( $return_output )
            {

                $result = array(
                    'output'          => $output,
                    'meta_link_prev'  => $meta_link_prev,
                    'meta_link_next'  => $meta_link_next,
                );
                return $result;
            }
            else
            {
                echo( $output );

                return true;
            }
        }

        ///////////////////////////////////////////////////////////////////////////

        /**
         * common::adminPaginate()
         *
         * @author          Roman Telychko
         * @version         0.1.20130627
         *
         * @param           array           $data
         * @param           bool            $return_output
         * @return          string
         */
        public function adminPaginate( $data = [], $return_output = false )
        {
            $data = array_merge(
                [
                    'page'              => 1,
                    'items_per_page'    => 20,
                    'total_items'       => 0,
                    'url_for'           => [],
                    'links_count'       => 5,
                ],
                $data
            );

            if( empty($data['page']) || empty($data['total_items']) || empty($data['url_for']) )
            {
                return false;
            }

            if( $data['total_items'] <= $data['items_per_page'] )
            {
                return false;
            }

            // pages count
            $data['pages_count'] = intval( ceil( $data['total_items'] / $data['items_per_page'] ) );

            if( $data['page'] > $data['pages_count'] )
            {
                $data['page'] = $data['pages_count'];
            }
            elseif( $data['page'] < 1 )
            {
                $data['page'] = 1;
            }

            // links count
            if( $data['links_count'] <= $data['pages_count'] )
            {
                if( $data['page'] <= floor( $data['links_count'] / 2 ) + 1 )
                {
                    $start_i = 1;
                }
                else
                {
                    $start_i = $data['page'] - floor( $data['links_count'] / 2 );
                }

                $stop_i     = $start_i + $data['links_count'] - 1;

                if( $stop_i > $data['pages_count'] )
                {
                    $start_i    = $data['pages_count'] - $data['links_count'] + 1;
                    $stop_i     = $data['pages_count'];
                }
            }
            else
            {
                $start_i    = 1;
                $stop_i     = $data['pages_count'];
            }

            $url_obj = $this->getDi()->get('url');

            $output =
                '<div class="pager">'.
                '<ul>'.
                ( $data['page']==1 ? '' : '<li><a href="'.$url_obj->get( array_merge( $data['url_for'], [ 'page' => 1 ] ) ).'" title="First (1)" class="first">1</a></li>' ).
                ( $data['page']==1 ? '' : '<li><a href="'.$url_obj->get( array_merge( $data['url_for'], [ 'page' => ( ($data['page'] == 1) ? 1 : $data['page'] - 1 ) ] ) ).'" title="Previous ('.( ($data['page'] == 1) ? 1 : $data['page'] - 1 ).')" class="prev"><span class="float arrow">&laquo;</span><span class="float">Предыдущая страница</span></a></li>' );

            // build links
            for( $i = $start_i; $i <= $stop_i; $i++ )
            {
                $output .= '<li'.( ($data['page'] == $i) ? ' class="current"' : '' ).'><a href="'.$url_obj->get( array_merge( $data['url_for'], [ 'page' => $i ] ) ).'" class="'.( ($data['page'] == $i) ? ' current hover' : '' ).'" title="Page '.$i.'">'.$i.'</a></li>';
            }

            $output .=
                ( $data['page']==$data['pages_count'] ? '' : '<li><a href="'.$url_obj->get( array_merge( $data['url_for'], [ 'page' => ( ($data['page'] + 1 == $data['pages_count']) ? $data['pages_count'] : $data['page'] + 1 ) ] ) ).'" title="Next ('.( ($data['page'] + 1 == $data['pages_count']) ? $data['pages_count'] : $data['page'] + 1 ).')" class="next"><span class="float">Следующая страница</span><span class="float arrow">&raquo;</span></a></li>' ).
                ( $data['page']==$data['pages_count'] ? '' : '<li><a href="'.$url_obj->get( array_merge( $data['url_for'], [ 'page' => $data['pages_count'] ] ) ).'" title="Last ('.$data['pages_count'].')" class="last">'.$data['pages_count'].'</a></li>' ).
                '</ul>'.
                '</div>';

            if( $return_output )
            {
                return $output;
            }
            else
            {
                echo( $output );

                return true;
            }
        }

        ///////////////////////////////////////////////////////////////////////////

        /**
         * common::shortenString()
         *
         * @author          Roman Telychko
         * @version         0.1.20110930
         *
         * @param           string      $str
         * @param           integer     $length
         * @return          string
         */
        public function shortenString( $str, $length = 200 )
        {
            if( strlen($str) > $length )
            {
                $str = wordwrap( $str, $length, '||BR||', false );
                $str = mb_substr( $str, 0, mb_strpos( $str, '||BR||', 0, 'UTF-8' ), 'UTF-8' );
                $str .= '...';
            }

            return $str;
        }

        ///////////////////////////////////////////////////////////////////////////

        /**
         * common::transliterate()
         *
         * @author          Jane Bezmaternykh
         * @version         0.1.20131115
         *
         * @param           string
         * @param           integer      $lang_id
         * @return          string
         */
        public function transliterate( $str, $lang_id = 1 )
        {
            $str = mb_strtolower( trim($str), 'UTF-8');

            $str = preg_replace('/\s{2,}/', ' ', $str);

            if( $lang_id==1 )  /* uk */
            {
                $str = str_replace( 'и', 'y', $str );
                $str = str_replace( 'й', 'yi', $str );
                $str = str_replace( 'і', 'i', $str );
                $str = str_replace( 'ї', 'yi', $str );
                $str = str_replace( 'є', 'ye', $str );
            }

            if( $lang_id==2 )  /* ru */
            {
                $str = str_replace( 'и', 'i', $str );
                $str = str_replace( 'й', 'yi', $str );
                $str = str_replace( 'ы', 'y', $str );
                $str = str_replace( 'э', 'e', $str );
                $str = str_replace( 'ъ', '', $str );
            }

            $str = str_replace( 'а', 'a', $str );
            $str = str_replace( 'б', 'b', $str );
            $str = str_replace( 'в', 'v', $str );
            $str = str_replace( 'г', 'g', $str );
            $str = str_replace( 'д', 'd', $str );
            $str = str_replace( 'е', 'e', $str );
            $str = str_replace( 'ж', 'j', $str );
            $str = str_replace( 'з', 'z', $str );
            $str = str_replace( 'к', 'k', $str );
            $str = str_replace( 'л', 'l', $str );
            $str = str_replace( 'м', 'm', $str );
            $str = str_replace( 'н', 'n', $str );
            $str = str_replace( 'о', 'o', $str );
            $str = str_replace( 'п', 'p', $str );
            $str = str_replace( 'р', 'r', $str );
            $str = str_replace( 'с', 's', $str );
            $str = str_replace( 'т', 't', $str );
            $str = str_replace( 'у', 'u', $str );
            $str = str_replace( 'ф', 'f', $str );
            $str = str_replace( 'х', 'h', $str );
            $str = str_replace( 'ц', 'ts', $str );
            $str = str_replace( 'ч', 'ch', $str );
            $str = str_replace( 'ш', 'sh', $str );
            $str = str_replace( 'щ', 'sch', $str );
            $str = str_replace( 'ю', 'yu', $str );
            $str = str_replace( 'я', 'ya', $str );
            $str = str_replace( 'ь', '', $str );
            $str = preg_replace( '/\s/', '_', $str );

            $str = preg_replace( '/[^a-z0-9\_]/', '', $str );
            $str = preg_replace( '/\_{1,}/', '_', $str );

            return $str;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::generatePasswd()
         *
         * @author          Jane Bezmaternykh
         * @version         0.1.20140428
         *
         * @param           integer      $leight
         * @return          string
         */
        public function generatePasswd( $leight )
        {
            $passwd = '';

            $str = "qwertyuiopasdfghjklzxcvbnm123456789";

            for($i=0; $i<$leight; $i++)
            {
                $passwd .= substr($str, mt_rand(0, strlen($str)-1), 1);
            }

            return $passwd;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::getTypeSubtype()
         *
         * @author		Jane Bezmaternykh
         * @version     0.1.20140407
         *
         * @param       string      $type_alias
         * @param       string      $type_child_alias
         * @param       string      $subtype_alias
         * @param       integer     $lang_id
         * @return     	array
         */
        public function getTypeSubtype( $type_alias = NULL, $type_child_alias = NULL, $subtype_alias = NULL, $lang_id )
        {
            $types      = $this->getDi()->get('models')->getCatalog()->getTypes( $lang_id );
            $subtypes   = $this->getDi()->get('models')->getCatalog()->getSubtypes( $lang_id );
            //p($types,1);
            //p($types,1);

            $catalog = [];

            foreach( $subtypes as $s )
            {
                $subtypes_[$s['type']][$s['id']] = $s;
            }

            foreach( $types as $t )
            {
                $catalog_[$t['type']]                = $t;
                $catalog_[$t['type']]['subtypes']    = !empty( $subtypes_[$t['type']] ) ? $subtypes_[$t['type']] : '';

                if( $t['parent_id'] > 0 )
                {
                    $catalog_[$t['type']]                           = $t;
                    $catalog_[$t['type']]['subtypes']               = $subtypes_[$t['parent_id']];

                    if( empty( $type_child_alias ) )
                    {
                        $catalog_[$t['parent_id']]['type_children'][]   = $t;
                    }
                    else
                    {
                        $catalog_[$t['parent_id']]['type_children_']  = $t; // for breadcrumbs
                    }
                }
            }

            //p($catalog_,1);

            foreach( $catalog_ as $k => $c )
            {
                //p($c['alias'] == $type_alias,1);
                if( !empty( $type_alias ) )
                {
                    if( $c['alias'] == $type_alias )
                    {
                        if( !empty( $subtype_alias ) )
                        {
                            foreach( $c['subtypes'] as $key => $val )
                            {
                                if( $val['alias'] == $subtype_alias )
                                {
                                    //$catalog = $val;
                                    $catalog['subtype_id']      = $key;
                                    $catalog['subtype_alias']   = $subtype_alias;
                                    $catalog['subtype_title']   = $val['title'];
                                    $catalog['cover']           = $val['cover'];
                                }
                            }
                        }
                        else
                        {
                            $catalog = $c;
                        }

                        $catalog['type_id']     = $k;
                        $catalog['type_alias']  = $c['alias'];
                        $catalog['type_title']  = $c['title'];
                    }
                }
                else
                {
                    $catalog = $catalog_;
                }
            }
            // p($catalog,1);

            return $catalog;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::getTypeSubtype1()
         *
         * @author		Jane Bezmaternykh
         * @version     0.1.20140407
         *
         * @param       array       $catalog_elements
         * @param       integer     $lang_id
         * @return     	array
         */
        public function getTypeSubtype1( $catalog_elements, $lang_id )
        {
            $rootId         = 0;
            $catalog        = [];
            $catalog_ids    = [];
            $catalog2return = [];

            if( !empty( $catalog_elements ) )
            {
                $catalog_alias  = array_pop($catalog_elements);

                $catalog_temp   = $this->getDi()->get('models')->getCatalog()->getCatalogWithTreeByAlias( $catalog_alias, $lang_id );

                $catalog_ids    = $this->getDi()->get('etc')->int2arr($catalog_temp);
            }

            $catalog_temp   = $this->getDi()->get('models')->getCatalog()->getCatalog( $lang_id );

            $catalog_return = [];

            foreach( $catalog_temp as $id => $node )
            {
                $catalog[$node['id']] = $node;
            }

            foreach( $catalog as $id => $node )
            {
                if( isset($node['parent_id']) )
                {
                    $catalog[$node['parent_id']]['sub'][$id] = &$catalog[$id];
                }
                else
                {
                    $rootId = $id;
                }
            }

            $catalog_ = [$rootId => $catalog[$rootId]];

            switch( count($catalog_ids) )
            {
                case 0:
                default:


                    $catalog2return = $catalog_['0']['sub'];

                    break;

                case 1:

                    foreach( $catalog_['0']['sub'] as $k => $c )
                    {
                        if( $k == $catalog_ids['0'] )
                        {
                            $catalog2return = $c;
                        }
                    }

                    break;

                case 2:

                    foreach( $catalog_['0']['sub'] as $k => $c )
                    {
                        if( $k == $catalog_ids['0'] )
                        {
                            $catalog2return = $c;

                            foreach( $c['sub'] as $key => $val )
                            {
                                //unset($val['sub']);
                                if( $key == $catalog_ids['1'] )
                                {
                                    $temp = $val;
                                }
                            }
                        }
                    }

                    $catalog2return['sub'] = $temp;


                    break;

                case 3:

                    foreach( $catalog_['0']['sub'] as $k => $c )
                    {
                        if( $k == $catalog_ids['0'] )
                        {
                            $catalog2return = $c;

                            foreach( $c['sub'] as $key => $val )
                            {
                                //unset($val['sub']);
                                if( $key == $catalog_ids['1'] )
                                {
                                    foreach( $val['sub'] as $last_k => $v )
                                    {
                                        if( $last_k  == $catalog_ids['2'] )
                                        {
                                            $val['sub'] = $v;
                                        }
                                        else
                                        {
                                            unset($val['sub'][$last_k]);
                                        }
                                    }

                                    $temp = $val;
                                }
                            }

                            $c['sub'] = $temp;
                        }
                    }

                    $catalog2return['sub'] = $temp;

                    break;
            }

            $catalog_return =
                [
                    'catalog'   => $catalog2return,
                    'path'      => !empty( $catalog_ids ) ? $catalog_ids : []
                ];



            return $catalog_return;
        }

        /////////////////////////////////////////////////////////////////////////////
        public function getTypeSubtype2($lang_id){
            $catalog_temp   = $this->getDi()->get('models')->getCatalog()->getCatalog( $lang_id );
            $catalog = array();
            foreach($catalog_temp as $item){
                $catalog[$item['id']] = $item;
            }
            return $catalog;

        }
        /**
         * common::getGroups()
         *
         * @author		Jane Bezmaternykh
         * @version     0.1.20140407
         *
         * @param       string     $lang_id
         * @param       array      $groups
         * @return     	array
         */
        public function getGroups( $lang_id, $groups )
        {

            $catalog_   = $this->getDi()->get('models')->getCatalog()->getCatalog( $lang_id );


            $compare    = $this->getDi()->get('session')->get('compare', []);
            $groups_    = [];

            foreach( $catalog_ as $c )
            {
                $catalog_new[$c['id']] = $c;
            }


            if( !empty( $groups ) )
            {
                $item_ids   = $this->array_column( $groups, 'id' );
                $items      = $this->getDi()->get('models')->getItems()->getItemsWithMinPrice( $lang_id, join( ',', $item_ids ) );

                if( !empty( $items ) )
                {
                    $items_ = [];
                    foreach( $items as $i )
                    {
                        $items_[$i['id']] = $i;
                    }

                    foreach( $groups as &$g )
                    {
                        $g['price']                 = !empty( $items_[$g['id']]['price2'] ) ? $items_[$g['id']]['price2'] : '';
                        $g['title']                 = !empty( $items_[$g['id']]['title'] ) ? $items_[$g['id']]['title'] : '';
                        $g['description']           = !empty( $items_[$g['id']]['description'] ) ? $this->shortenString($items_[$g['id']]['description'], 200) : '';
                        $g['content_description']   = !empty( $items_[$g['id']]['content_description'] ) ? $items_[$g['id']]['content_description'] : '';
                        $g['cover']                 = !empty( $g['cover'] ) ? $this->getDi()->get('storage')->getPhotoUrl( $g['cover'], 'avatar', '200x' ) : '/images/packet.jpg';
                        $g['alias']                 = $this->getDi()->get('url')->get([ 'for' => 'item', 'subtype' => $catalog_new[$g['catalog']]['alias'], 'group_alias' => $g['alias'], 'item_id' => $g['id'] ]);
                        $g['checked']               = !empty($compare[$g['type_id']][$g['subtype_id']]) && in_array($g['id'], $compare[$g['type_id']][$g['subtype_id']]) ? 1 : 0;

                        if( !empty( $g['options'] ) )
                        {
                            $g['options_']  = $this->getDi()->get('etc')->hstore2arr($g['options']);
                            $g['is_new']    = !empty( $g['options_']['is_new'] ) ? $g['options_']['is_new'] : '0';
                            $g['is_top']    = !empty( $g['options_']['is_top'] ) ? $g['options_']['is_top'] : '0';

                            unset($g['options_']);
                            unset($g['options']);
                        }
                    }

                    $groups_ = $groups;
                }
            }

            return $groups_;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::getGroups1()
         *
         * @author		Jane Bezmaternykh
         * @version     0.1.20140407
         *
         * @param       string     $lang_id
         * @param       array      $groups
         * @return     	array
         */
        public function getGroups1( $lang_id, $groups)
        {
            $groups_    = [];
            $compare    = $this->getDi()->get('session')->get('compare', []);

            if( !empty( $groups ) )
            {
                $item_ids   = $this->array_column( $groups, 'id' );
                $items      = $this->getDi()->get('models')->getItems()->getItemsWithMinPrice( $lang_id, join( ',', $item_ids ) );

                if( !empty( $items ) )
                {
                    $items_ = [];
                    foreach( $items as $i )
                    {
                        $items_[$i['id']] = $i;
                    }



                    foreach( $groups as &$g )
                    {
                        $g['items']                 = $this->getDi()->get('models')->getItems()->getSizesByGroupId($lang_id, $g['group_id']);

                        for($i = 0; $i < count($g['items']); $i++) {
                            $g['items'][$i]['prices'] = $this->getPricesArray($g['items'][$i]);
                        }
                        $g['price']                 = !empty( $items_[$g['id']]['price2'] ) ? $items_[$g['id']]['price2'] : 0;
                        $g['title']                 = !empty( $items_[$g['id']]['title'] ) ? $items_[$g['id']]['title'] : '';
                        $g['description']           = !empty( $items_[$g['id']]['description'] ) ? $this->shortenString($items_[$g['id']]['description'], 200) : '';
                        $g['content_description']   = !empty( $items_[$g['id']]['content_description'] ) ? $items_[$g['id']]['content_description'] : '';
                        $g['cover']                 = !empty( $g['cover'] ) ? $this->getDi()->get('storage')->getPhotoUrl( $g['cover'], 'avatar', '200x' ) : '/images/packet.jpg';
                        $g['alias']                 = $this->getDi()->get('url')->get([ 'for' => 'item', 'type' => $g['type_alias'], 'subtype' => $g['subtype_alias'], 'group_alias' => $g['alias'], 'item_id' => $g['id'] ]);
                        if(isset($g['type_id']) && isset($g['catalog']))
                            $g['checked']               = !empty($compare[$g['type_id']][$g['catalog']]) && in_array($g['id'], $compare[$g['type_id']][$g['catalog']]) ? 1 : 0;


                        if( !empty( $g['options'] ) )
                        {
                            $g['options_']  = $this->getDi()->get('etc')->hstore2arr($g['options']);
                            $g['is_new']    = !empty( $g['options_']['is_new'] ) ? $g['options_']['is_new'] : '0';
                            $g['is_top']    = !empty( $g['options_']['is_top'] ) ? $g['options_']['is_top'] : '0';

                            unset($g['options_']);
                            unset($g['options']);
                        }
                    }

                    $groups_ = $groups;
                }
            }

            return $groups_;
        }


        public function getGroupsBackend( $lang_id, $groups)
        {
            $groups_    = [];
            $compare    = $this->getDi()->get('session')->get('compare', []);

            if( !empty( $groups ) )
            {
                $item_ids   = $this->array_column( $groups, 'id' );
                $items      = $this->getDi()->get('models')->getItems()->getItemsWithMinPrice( $lang_id, join( ',', $item_ids ) );

                if( !empty( $items ) )
                {
                    $items_ = [];
                    foreach( $items as $i )
                    {
                        $items_[$i['id']] = $i;
                    }



                    foreach( $groups as &$g )
                    {
                        $g['items']                 = $this->getDi()->get('models')->getItems()->getSizesByGroupId($lang_id, $g['group_id']);

                        for($i = 0; $i < count($g['items']); $i++) {
                            $g['items'][$i]['prices'] = $this->getPricesArray($g['items'][$i]);
                        }
                        $g['price']                 = !empty( $items_[$g['id']]['price2'] ) ? $items_[$g['id']]['price2'] : 0;
                        $g['title']                 = !empty( $items_[$g['id']]['title'] ) ? $items_[$g['id']]['title'] : '';
                        $g['description']           = !empty( $items_[$g['id']]['description'] ) ? $this->shortenString($items_[$g['id']]['description'], 200) : '';
                        $g['content_description']   = !empty( $items_[$g['id']]['content_description'] ) ? $items_[$g['id']]['content_description'] : '';
                        $g['cover']                 = !empty( $g['cover'] ) ? $this->getDi()->get('storage')->getPhotoUrl( $g['cover'], 'avatar', '200x' ) : '/images/packet.jpg';

                        if(isset($g['type_id']) && isset($g['catalog']))
                            $g['checked']               = !empty($compare[$g['type_id']][$g['catalog']]) && in_array($g['id'], $compare[$g['type_id']][$g['catalog']]) ? 1 : 0;


                        if( !empty( $g['options'] ) )
                        {
                            $g['options_']  = $this->getDi()->get('etc')->hstore2arr($g['options']);
                            $g['is_new']    = !empty( $g['options_']['is_new'] ) ? $g['options_']['is_new'] : '0';
                            $g['is_top']    = !empty( $g['options_']['is_top'] ) ? $g['options_']['is_top'] : '0';

                            unset($g['options_']);
                            unset($g['options']);
                        }
                    }

                    $groups_ = $groups;
                }
            }

            return $groups_;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::seo_important()
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140412
         *
         * @param     	array        $filters
         * @param     	array        $filters_applied
         * @param     	string       $url
         * @param     	string       $price
         * @param     	array        $sort
         * @return    	array
         */
        public function seo_important( $filters, $filters_applied, $url, $price, $sort )
        {
            $lang_id = 1;
            $seo_important_filters      = $this->getDi()->get('models')->getFilters()->getSeoImportantFilters( $lang_id );
            $seo_important_filters_ids  = self::array_column( $seo_important_filters, 'id' );

            foreach( $seo_important_filters as $f )
            {
                $seo_alias[$f['id']] =
                    [
                        'key'   => $f['filter_key_alias'],
                        'value' => $f['filter_value_alias']
                    ];
            }

            foreach( $filters as $k => &$f )
            {
                $filters[$k]['alias_'] =
                    in_array( $f['id'], $filters_applied )
                        ?
                        array_diff( $filters_applied, [ $f['id'] ] )
                        :
                        array_merge( $filters_applied, [ $f['id'] ] );

                sort( $f['alias_'] );

                $filters[$k]['alias'] =
                    $url.
                    (!empty( $f['alias_']  ) ? '/'.join( '-', $f['alias_'] ) : '').
                    (!empty( $f['alias_']  ) ? ( !empty($price) ? '--price-'.$price : '' ) : ( !empty($price) ? '/price-'.$price : '' )).
                    (!empty($sort) ? '/sort-'.join('-', $sort) : '');

                if( !empty( $f['alias_'] ) )
                {
                    foreach( $f['alias_'] as $v )
                    {
                        if( in_array( $v, $seo_important_filters_ids ) )
                        {
                            $filters[$k]['seo_alias_array'][] = $seo_alias[$v];
                        }
                    }

                    if( !empty( $f['seo_alias_array'] ) )
                    {
                        foreach( $f['seo_alias_array'] as $s )
                        {
                            $f['seo_alias_array_'][$s['key']][] = $s['value'];
                        }

                        foreach( $f['seo_alias_array_'] as $key => $s )
                        {
                            $f['seo_alias_array__'][$key] = $key.'-'.join( '-', $s );
                        }

                        $filters[$k]['alias'] =
                            $url.
                            (!empty(  $f['alias_'] ) && !empty( $f['seo_alias_array__'] ) ? '/'.join( '-', $f['alias_'] ).'--'.join( '--', $f['seo_alias_array__'] ) : '').
                            ( empty( $f['alias_'] ) && empty( $f['seo_alias_array__'] ) ? ( !empty($price) ? '/price-'.$price : '' ) : ( !empty($price) ? '--price-'.$price : '' ) ).
                            ( !empty($sort) ? '/sort-'.join('-', $sort) : '' );


                        unset($f['seo_alias_array_']);
                        unset($f['seo_alias_array__']);
                    }

                    unset($f['seo_alias_array']);
                    unset($f['alias_']);
                }
            }

            return $filters;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::getUrlForFilter()
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140415
         *
         * @param     	array        $params
         * @param     	string       $page
         * @return    	array
         */
        public function getUrlForFilter( $params, $page )
        {

            if( empty($params['filter_ids']) && empty($params['filter_alias']) && empty($params['price']) && !empty($params['sort']) )
            {
                $url = ['for' => 'subtype_sorted_paginated', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => $params['sort'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && empty($params['price']) && empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_ids_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && empty($params['price']) && !empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_ids_sorted_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => $params['sort'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && empty($params['price']) && empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_alias_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && empty($params['price']) && !empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_alias_sorted_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => $params['sort'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) && empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_price_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) && !empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_price_sorted_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => $params['sort'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && !empty($params['price']) && empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_alias_price_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'page' => $page ];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && !empty($params['price']) && !empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_id_alias_price_sorted_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => $params['sort'], 'page' => $page ];
            }
            elseif( empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) && empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_price_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'page' => $page ];
            }
            elseif( empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) && !empty($params['sort']) )
            {
                $url = [ 'for' => 'get_items_with_filters_price_sorted_paginate', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => $params['sort'], 'page' => $page ];
            }

            return $url;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::getUrlForSort()
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140520
         *
         * @param     	array        $params
         * @param     	string       $sort_default_1
         * @param     	string       $sort_default_2
         * @return    	array
         */
        public function getUrlForSort( $params, $sort_default_1, $sort_default_2 )
        {
            //p($params,1);

            if( empty($params['filter_ids']) && empty($params['filter_alias']) && empty($params['price']) )
            {
                $url[0] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'subtype_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'sort' => $sort_default_1.'-5'];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && empty($params['price']) )
            {
                $url[0] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'get_items_with_filters_ids_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'sort' => $sort_default_1.'-5'];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && empty($params['price']) )
            {
                $url[0] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'get_items_with_filters_id_alias_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'sort' => $sort_default_1.'-5'];
            }
            elseif( !empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) )
            {
                $url[0] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'get_items_with_filters_id_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'price' => $params['price'], 'sort' => $sort_default_1.'-5'];
            }
            elseif( !empty($params['filter_ids']) && !empty($params['filter_alias']) && !empty($params['price']) )
            {
                $url[0] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'get_items_with_filters_id_alias_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'filter_ids' => $params['filter_ids'], 'filter_alias' => $params['filter_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-5'];
            }
            elseif( empty($params['filter_ids']) && empty($params['filter_alias']) && !empty($params['price']) )
            {
                $url[0] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => '0-'.$sort_default_2];
                $url[1] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => '1-'.$sort_default_2];
                $url[2] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => '2-'.$sort_default_2];
                $url[3] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-3'];
                $url[4] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-4'];
                $url[5] = ['for' => 'get_items_with_filters_price_sorted', 'type' => $params['type_alias'], 'subtype' => $params['subtype_alias'], 'price' => $params['price'], 'sort' => $sort_default_1.'-5'];
            }

            return $url;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * common::buildBreadcrumbs()
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140718
         *
         * @param     	array        $catalog
         * @return    	string
         */
        public function buildBreadcrumbs( $catalog )
        {
            $breadcrumbs =
                '<div class="breadcrumbs">'.
                '<div class="inner">'.
                '<ul class="clearfix">'.
                '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url" href="'.$this->getDi()->get('seoUrl')->setUrl('/').'" title="'.$this->getDi()->get('languages')->getTranslation()->_("main_page").'"><span itemprop="title">'.$this->getDi()->get('languages')->getTranslation()->_("main_page").'</a></li>'.
                '<li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url" href="'.$this->getDi()->get('seoUrl')->setUrl('/#catalog').'" title="Каталог"><span itemprop="title">Каталог</span></a></li>';

            switch( count($catalog['path']) )
            {
                case 1:
                default:

                    $breadcrumbs .=
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['alias']).'" title="'.$catalog['catalog']['title'].'" class="breadcrumbs_last"><span itemprop="title">'.$catalog['catalog']['title'].'</span></a></li>';

                    break;

                case 2:

                    $breadcrumbs .=
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['alias']).'"> <span itemprop="title">'.$catalog['catalog']['title'].'</span></a></li>'.
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['sub']['alias']).'" class="breadcrumbs_last"><span itemprop="title">'.$catalog['catalog']['sub']['title'].'</span></a></li>';

                    break;

                case 3:
                    $breadcrumbs .=
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['alias']).'"> <span itemprop="title">'.$catalog['catalog']['title'].'</span></a></li>'.
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['sub']['alias']).'"><span itemprop="title">'.$catalog['catalog']['sub']['title'].'</span></a></li>'.
                        '<li class="float"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>'.
                        '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url"  href="'.$this->getDi()->get('seoUrl')->setUrl($catalog['catalog']['sub']['sub']['alias']).'" class="breadcrumbs_last"><span itemprop="title">'.$catalog['catalog']['sub']['sub']['title'].'</span></a></li>';

                    break;
            }

            $breadcrumbs .=
                '</ul>
                    </div>
                </div>';

            //p($breadcrumbs,1);

            return $breadcrumbs;
        }


        /**
         * common::explodeAlias()
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140718
         *
         * @param     	array        $items
         * @return    	array
         */
        public function explodeAlias( $items )
        {
            if(!empty($items)){
                foreach( $items as &$p )
                {
                    if(!empty($p['catalog_alias'])){
                        $p['explode']       = explode( '/', $p['catalog_alias'] );
                        $p['type_alias']    = $p['explode']['1'];
                        $p['subtype_alias'] = $p['explode']['2'];
                        unset( $p['explode'] );
                    } else {
                        $p['type_alias']    = '';
                        $p['subtype_alias'] = '';
                    }


                }
            }


            return $items;
        }

        public function postCurl($params) {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, 'http://'.config::get( 'global#domains/www-dev' ).'/ajax/get_session' );
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS,'params='.$params);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/30.0.1599.114 Chrome/30.0.1599.114 Safari/537.36' );

            $data = curl_exec($curl);
            return $data;
        }

        public function getPriceClass($price, $usersPrice) {
            $priceNum = substr($price, -1);

            if($usersPrice > $priceNum) {
                return 'class="inactive_price"';
            }
        }

        public function getPricesArray($item) {
            $prices = [];
            $price_first = 2;
            $price_last = 6;

            for ($i = $price_first; $i < $price_last + 1; $i++) {
                $prices[] = $item['price' . $i];
            }
            return $prices;
        }

        public function getCartItems($in_cart, $lang_id, $special_user = null) {
            $result = [];
            $total_price = 0;
            $item_ids    = $this->array_column( $in_cart, 'item_id' );
            $items       = $this->getDi()->get('models')->getItems()->getItemsByIds( $lang_id, $item_ids );
            $groups_ids  = $this->array_column( $items, 'group_id' );
            $groups_data = $this->getDi()->get('models')->getItems()->getItemsByColorAndGroupsId(join(',',$groups_ids));
            $colors      = array_unique($this->array_column( $groups_data, 'color_id' ));
            $color_info = $this->getDi()->get('models')->getItems()->getColorsInfoByColorsId( $lang_id, join(',',$colors) );
            foreach($color_info as $k =>$v){
                $colors_info[$v['id']] = $v;
            }


            foreach($groups_data as $k =>$v){
                if($groups_data[$k]['color_id'] != 0){
                    $groups_data[$k]['color'] = $colors_info[$groups_data[$k]['color_id']]['color_title'];
                    $groups_data[$k]['absolute_color'] = $colors_info[$groups_data[$k]['color_id']]['absolute_color'];

                } else {
                    $groups_data[$k]['color'] = 0;
                    $groups_data[$k]['absolute_color'] = 0;
                }
            }

            foreach($groups_data as $k =>$v){
                $groups_data[$v['id']] = $v;
            }

            foreach ( $in_cart as $c )
            {

                $count_item[$c['item_id']] = $c['count_items'];
            }

            if(isset($special_user)) {
                for ($i = 0; $i < count($items); $i++) {
                    $items[$i]['prices'] = $this->getPricesArray($items[$i]);
                }
            }



            foreach ( $items as $k => $i )
            {
                $items[$k]['cover']         = !empty( $i['group_cover'] ) ? $this->getDi()->get('storage')->getPhotoUrl( $i['item_cover'], 'avatar', '128x' ) : '/images/packet.jpg';
                $items[$k]['alias']         = $this->getDi()->get('url')->get([ 'for' => 'item', 'subtype' => $i['catalog_alias'], 'group_alias' => $i['group_alias'], 'item_id' => $i['id'] ]);



                if(isset($i['prices'][0])) {
                    $items[$k]['total_price'] = round($count_item[$i['id']] * $i['prices'][$special_user['status']], 2);
                    $items[$k]['price2'] = $i['prices'][$special_user['status']];
                } else {
                    $items[$k]['total_price'] = round($count_item[$i['id']] * $i['price2'], 2);
                }

                $items[$k]['count'] = $count_item[$i['id']];
                $total_price += $items[$k]['total_price'];
                $items[$k]['color'] = $groups_data[$i['id']]['color'];
                $items[$k]['absolute_color'] = $groups_data[$i['id']]['absolute_color'];
                $items_[$i['id']] = $items[$k];
            }

            $total_price = round( $total_price, 2 );

            $result['total_price'] = $total_price;
            $result['items'] = $items;
            $result['items_'] = $items_;
            return $result;
        }

        public function countOrderSum(&$order) {
            $sum = 0;
            foreach($order['items'] as $k => $item) {
                $sum += $item['total_price'];
            }
            $order['total_sum'] = $sum;
        }

        public function applyPromoCode($promo_code, &$items) {
            $flag = false;
            foreach($items as $k => $item) {
                if($this->containsPromoCode($promo_code, $item)) {
                    $flag = true;
                    $items[$k]['price2'] = number_format($item['price2'] - ($item['price2'] * $promo_code['discount'] / 100), 1, '.', '');
                    $items[$k]['total_price'] = number_format($items[$k]['price2'] * $item['count'], 1, '.', '');
                }
            }
            return $flag;
        }

        public function containsPromoCode($promo_code, $item) {
            $group_ids = $this->parseArray($promo_code['group_ids']);
            /*$catalog_ids = $this->parseArray($promo_code['catalog_ids']);*/

            if(!empty($group_ids) && in_array($item['id'], $group_ids))
                return true;

            /*$catalog_tree = $this->getDi()->get('models')->getCatalog()->getCatalogWithTree($item['catalog']);
            $path = $this->parseArray($catalog_tree[0]['path']);

            if(!empty($catalog_ids) && !empty(array_intersect($path, $catalog_ids)))
                return true;*/

            return false;
        }

        public function parseArray($str) {
            return explode(',', preg_replace('[{|}]', '' , $str));
        }
    }
}


