<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ServiceController extends \controllers\ControllerBase
{
    ///////////////////////////////////////////////////////////////////////////

    public function typesAction()
    {
        $rows = [];
        $all_rows = [];
        $file = fopen(ROOT_PATH.'data/SEMENA_1_gazonni travy.csv', 'r');
        
        if ($file)
        {
            while( ($buffer = fgetcsv( $file, 100000, ',' ) ) !== false)
            {
                $all_rows[] = array_filter($buffer);
            }
        }
        fclose($file);

        // get all filters_keys id => title
        $termins = $all_rows['2'];

        foreach( $all_rows as $r )
        {
            if( !empty( $r ) && !empty( $r['1'] ) )
            {
                $veg[ $r['1'] ][] = $r;
            }
        }

        // get all kavuns
        $kavun = $all_rows;

        $type = 4;
        $subtype = 1;


        // get filters_key_id_from
        $filters_key_id = array_unique($all_rows['0']);
        foreach( $filters_key_id as $k => $v )
        {
            if( $v == 'Характеристики' )
            {
                $char_key_id_from = $k;
            }
            if( $v == 'Фільтри для розділу:' )
            {
                $filters_key_id_from = $k;
            }
        }

        unset($kavun['0']);
        unset($kavun['1']);
        unset($kavun['2']);

        foreach( $kavun as $key => $value )
        {
            foreach( $value as $k => $v )
            {
                $filter_values_[$k][] = trim($v);
                $filter_values_[$k] = array_unique($filter_values_[$k]);
            }
        }

        foreach( $filter_values_ as $k => $v )
        {
            if( $k >= $filters_key_id_from )
            {

                $val[$termins[$k]] = array_unique($v);

                foreach( $val[$termins[$k]] as $key => $val_ )
                {
                    $key_values[$termins[$k]][] =
                        [
                            'value_value' => $val_,
                            'value_alias' => $this->common->transliterate( trim($val_), $this->lang_id ),
                        ];
                }

                $filter_values_for_group[] =
                    [
                        'key_value' => trim($termins[$k]),
                        'key_alias' => $this->common->transliterate( trim($termins[$k]), $this->lang_id ),
                        'key_values' => $key_values[$termins[$k]]
                    ];
            }
            if( $k < $filters_key_id_from && $k >= $char_key_id_from )
            {
                $char_values_for_group[trim($termins[$k])] = array_unique($v);
            }
        }

        $termins = $all_rows['2'];



        unset($all_rows['0']);
        unset($all_rows['1']);
        unset($all_rows['2']);

        foreach( $all_rows as $r )
        {
            if( !empty( $r ) && !empty( $r['1'] ) )
            {
                $veg[ $r['1'] ][] = $r;
            }
        }


        $filters_for_group  = $this->models->getFilters()->getFilters( $this->lang_id, $type, $subtype );

        $char_for_group     = $this->models->getFilters()->getChar( $this->lang_id, $type, $subtype );

        foreach( $kavun as $key => $value )
        {
            for ($i = 1; $i <= 6; $i++)
            {
                if( file_exists( STORAGE_PATH.'foto gazonni travy/'.$value['3'].'/'.$i.'.jpg' ) )
                {
                    $md5_files[$value['3']][] = md5_file(STORAGE_PATH.'foto gazonni travy/'.$value['3'].'/'.$i.'.jpg');

                    $md5_files_temp[STORAGE_PATH.'foto gazonni travy/'.$value['3'].'/'.$i.'.jpg'] = md5_file(STORAGE_PATH.'foto gazonni travy/'.$value['3'].'/'.$i.'.jpg');
                }
            }

            $md5_files[$value['3']]     = array_filter($md5_files[$value['3']]);
            $md5_files[$value['3']]     = array_unique($md5_files[$value['3']]);
            $md5_files_[$value['3']]    = $this->etc->arr2int($md5_files[$value['3']]);

            foreach( $value as $k => $v )
            {
                $filter_values_[$k][] = trim($v);

                if( $k >= $filters_key_id_from )
                {
                    foreach( $filters_for_group as $f )
                    {
                        if( $f['filter_key_value'] == trim($termins[$k]) && $f['filter_value_value'] == trim($v) )
                        {
                            $filters[$key][] = $f['id'];
                        }
                    }

                    $filters_[$key][trim($termins[$k])] = trim($v);
                }


                if( $k < $filters_key_id_from && $k >= $char_key_id_from )
                {
                    foreach( $char_for_group as $f )
                    {
                        if( $f['property_key_value'] == trim($termins[$k]) && $f['property_value_value'] == trim($v) )
                        {
                            $char[$key][] = $f['id'];
                        }
                    }

                    $char_[$key][trim($termins[$k])] = trim($v);
                }
            }


            $items[$value['2']][] =
                [
                    'size'                  => $value['6'],
                    'price1'                => isset( $value['7'] ) && !empty( $value['7'] ) ? str_replace( ',', '.', $value['7'] ) : '5',
                    'price2'                => isset( $value['7'] ) && !empty( $value['7'] ) ? str_replace( ',', '.', $value['7'] ) : '5',
                    'status'                => 1,
                    'type'                  => $type,
                    'subtype'               => $subtype,
                    'lang_id'               => '1',
                    'product_id'            => NULL,
                    'color'                 => NULL,
                    'filters'               => $filters[$key],
                    'char'                  => $char[$key],
                ];

            $kavun_group[$value['2']] =
                [
                    'subtype_title'         => isset( $value['1'] ) && !empty( $value['1'] ) ? $value['1'] : '',
                    'group_title'           => $value['2'],
                    'group_alias'           => $this->common->transliterate( $value['2'] ),
                    'description'           => isset( $value['4'] ) && !empty( $value['4'] ) ? $value['4'] : NULL,
                    'content_description'   => isset( $value['5'] ) && !empty( $value['5'] ) ? $value['5'] : NULL,
                    'content_video'         => NULL,
                    'cover'                 => isset( $value['3'] ) && !empty( $value['3'] ) ? md5_file(STORAGE_PATH.'foto gazonni travy/'.'/'.$value['3'].'/1.jpg') : NULL,
                    'photogallery'          => isset( $md5_files_[$value['3']] ) && !empty( $md5_files_[$value['3']] ) ? $md5_files_[$value['3']] : NULL,
                    'status'                => 1,
                    'type'                  => $type,
                    'subtype'               => $subtype,
                    'lang_id'               => '1',
                    'items'                 => $items[$value['2']],
                ];

        }

        sort($kavun_group);

        $md5_files_temp = array_unique( $md5_files_temp );
        $md5_files_temp = array_filter( $md5_files_temp );

        p($kavun_group,1);

        foreach( $kavun_group as $kavun )
        {
            p($this->models->getFilters()->addItems( $kavun ) );
        }


        p($kavun_group,1);

        $termins = array_unique($termins);

        p('hello',1);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function imagesAction()
    {

        $path = STORAGE_PATH.'temp/111.jpg';
        $image_path = $this->storage->getPhotoPath( 'avatar', '38550b4ad85b2ad8314b888458eb6bfe', '11' );
        p($path);

        p($this->storage->imageResizeWithCrop( [], '38550b4ad85b2ad8314b888458eb6bfe', 'avatar' ));

        p( md5_file($path),1 );
    }

    //////////////////////////////////////////////////////////////////////////

    public function storageAction()
    {
        $images = $this->models->getFilters()->getImages();

        $subtypes = $this->common->array_column($images, 'cover');
        $subtypes = array_filter( $subtypes );
        $subtypes = array_unique( $subtypes );

        foreach( $subtypes as $s )
        {
            $path = $this->storage->getPhotoPath( 'subtype', $s, 'subtype' );
            $image_path = $this->storage->getPhotoPath( 'subtype', $s, '165x120' );
            p($path);
        }

        p($subtypes);

        p($images,1);
    }

    //////////////////////////////////////////////////////////////////////////

    public function catalogAction()
    {
        $rootId = 0;

        $catalog_temp   = $this->getDi()->get('models')->getCatalog()->getCatalogForInsertAlias( $this->lang_id );

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

        $catalog_loop = $catalog_['0']['sub'];
        $catalog_loop_ = [];

        foreach( $catalog_loop as &$value )
        {
            foreach( $value['sub'] as &$val )
            {
                if( !empty($val['sub']) )
                {
                    foreach( $val['sub'] as &$v )
                    {
                        $v['alias'] = $this->url->get([ 'for' => 'subtype', 'type' => $value['alias'].'--'.$val['alias'], 'subtype' => $v['alias'] ]);

                        $catalog_loop_[] = $v;
                    }

                    $val['alias'] = $this->url->get([ 'for' => 'type', 'type' => $value['alias'].'--'.$val['alias'] ]);

                    unset( $val['sub'] );
                    $catalog_loop_[] = $val;


                }
                else
                {
                    $val['alias'] = $this->url->get([ 'for' => 'subtype', 'type' => $value['alias'], 'subtype' => $val['alias'] ]);

                    $catalog_loop_[] = $val;
                }
            }

            $value['alias'] = $this->url->get([ 'for' => 'type', 'type' => $value['alias'] ]);

            unset( $value['sub'] );
            $catalog_loop_[] = $value;
        }

        p( $this->models->getCatalog()->insertCatalogAlias( $catalog_loop_, $this->lang_id ),1 );
    }

    //////////////////////////////////////////////////////////////////////////

    public function citiesAction()
    {
        $curl = curl_init();

        $postvalues = array(
            'getpage=yes',
            'lang=en',
        );

        $header = array(
            'Origin: http://myip.ms',
            'X-Requested-With: XMLHttpRequest',
        );

        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_URL, 'http://semena.in.ua/content/contact/' );
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, join( '&', $postvalues ) );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_REFERER, 'http://semena.in.ua/content/contact/' );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header );
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/30.0.1599.114 Chrome/30.0.1599.114 Safari/537.36' );

        curl_setopt($curl, CURLOPT_COOKIEFILE, '/home/jane/www/two/cities/cookiefile.txt' );
        curl_setopt($curl, CURLOPT_COOKIEJAR, '/home/jane/www/two/cities/cookiefile.txt' );

        $data = curl_exec($curl);

        $reg = '#<tr>\s*<td[^>]*>\s*(?P<address>[^<]*)\s*[^t]*td>\s*<td[^>]*>(?P<tel>[0-9\-]*)\s*[^t]*td>\s*#ims';

        if( preg_match_all( $reg, $data, $matches ) )
        {
            $shop =
                [
                    'address' => $matches['address'],
                    'phone' => $matches['tel'],
                ];
        }

        foreach( $shop['address'] as $k => &$s )
        {
            $s = trim($s);
            $shop['address_'][$k] = trim(mb_substr($s, 13));
            $shop['district'][$k] = 0;

            $shop_[$k] =
            [
                'phone' =>   $shop['phone'][$k],
                //'address_' =>   $shop['address_'][$k],
                'address_' =>   iconv(mb_detect_encoding($shop['address_'][$k]), "UTF-8", $shop['address_'][$k]),
                'district' =>   $shop['district'][$k]
            ];
        }

        p($shop_);

        p('hello',1);
    }

    //////////////////////////////////////////////////////////////////////////

    public function poshtaAction()
    {
        $cities = $this->novaposhta->warenhouse('Полтава');

        foreach( $cities->warenhouse as $c )
        {
            p($c);
        }


        die();

        p( $this->novaposhta->price( 'Полтава', 10, 20 ), 1 );

    }

    //////////////////////////////////////////////////////////////////////////

    public function typeSubtypeAction()
    {
        $file = fopen(ROOT_PATH.'data/Semena_old_urls.csv', 'r');
        
        if ($file)
        {
            while( ($buffer = fgetcsv( $file, 100000, ',' ) ) !== false)
            {
                $all_rows[] = array_filter($buffer);
            }
        }
        fclose($file);

        foreach( $all_rows as $k => $v )
        {
            $current_titles[$k] = isset($v['1']) ? $v['1'] : '';
        }

        $items = $this->models->getFilters()->getItemsTitle();

        $j = 0;

        foreach( $items as $k => $i )
        {
            if( in_array( $i['title'], $current_titles ) )
            {
                $items[$k]['in_array'] = 1;

                $j++;
            }
            else
            {
                $items[$k]['in_array'] = 0;
            }
        }

        p($j);

        p('hello',1);
    }

    //////////////////////////////////////////////////////////////////////////

}
