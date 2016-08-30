<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class news extends \db
{
    /////////////////////////////////////////////////////////////////////////////

    public function getNews( $lang_id, $page = 1 )
    {
        return $this->get(
            '
                SELECT
                    id,
                    title,
                    alias,
                    content,
                    cover,
                    abstract_info,
                    video,
					publish_date
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1
                    AND
                    options @> \'"is_news"=>"1"\'::hstore
                ORDER BY
                    publish_date DESC
                LIMIT
                    '.\config::get( 'limits/news' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/news' ))
            ,
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getNewsFor1Page( $lang_id, $dealer_rubric )
    {
        return $this->get(
            '
                SELECT
                    id,
                    title,
                    alias,
                    content,
                    cover,
                    abstract_info,
                    pic_status,
                    video,
                    rubric_id
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1
                    AND
                    options @> \'"is_tips"=>"1"\'::hstore
                    AND
                    rubric_id NOT IN ('. join(', ', $dealer_rubric).')
                ORDER BY
                    publish_date DESC
                LIMIT
                    4
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getOneNews( $lang_id, $news_id, $dealer_rubric = null )
    {
        $for_dealer = !empty($dealer_rubric) ? 'AND
                    rubric_id NOT IN ('. join(', ', $dealer_rubric).')' : '';
        return $this->get(
            '
                SELECT
                    id,
                    title,
                    alias,
                    meta_title,
                    meta_keywords,
                    meta_description,
                    content,
                    cover,
                    photogallery,
                    group_id,
                    pic_status,
                    video,
					publish_date
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    id      = :news_id
                    AND
                    status = 1
                    '. $for_dealer .'
                LIMIT 1
            ',
            [
                'lang_id' => $lang_id,
                'news_id' => $news_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getGroupsIdsByNewsId( $lang_id, $news_id )
    {
        return $this->get(
            '
                SELECT
                    group_id
                FROM
                    public.news
                WHERE
                    id      = :id
                AND
                   lang_id = :lang_id
            ',
            [
                'lang_id' => $lang_id,
                'id' => $news_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getNewsByGroupId( $lang_id, $group_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    title,
                    alias,
                    content,
                    cover,
                    abstract_info,
                    video
                FROM
                    public.news
                WHERE
                    intset('.$group_id.') <@ group_id
                    AND
                    lang_id = :lang_id
                    AND
                    status = 1

            ',
            [
                'lang_id' => $lang_id,
                //'group_id' => $group_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getTotalNews( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) as count
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1
                    AND
                    options @> \'"is_news"=>"1"\'::hstore
                LIMIT
                    1
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

   /////////////////////////////////////////////////////////////////////////////

    public function getTotalVideo( $lang_id,$rub = 0 )
    {
	$sql =             '
                SELECT
                    COUNT(id) as count
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1 AND video IS NOT NULL ';
					if($rub>0)$sql .= ' AND rubric_id='.$rub;
					$sql .= '
                    AND
                    options @> \'"is_tips"=>"1"\'::hstore
                LIMIT
                    1
            ';
        return $this->get(
			$sql,
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////

    public function getVideo( $lang_id, $page = 1, $rub = 0, $dealer_rubric = null )
    {
        $for_dealer = !empty($dealer_rubric) ? 'AND
                    rubric_id NOT IN ('. join(', ', $dealer_rubric).')' : '';
	    $sql = '
                SELECT
                    id,
                    title,
                    alias,
                    content,
                    cover,
                    abstract_info,
                    video,
					publish_date
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1 AND video IS NOT NULL ';

					if($rub>0)$sql .= ' AND rubric_id='.$rub;
					$sql .='
                    AND
                    options @> \'"is_tips"=>"1"\'::hstore
                    '. $for_dealer .'
                ORDER BY
                    video_sort ASC
                LIMIT
                    '.\config::get( 'limits/news' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/news' ))
            ;
	    return $this->get($sql,

            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////

    public function getTips( $lang_id, $page = 1, $rub = 0, $dealer_rubric = null )
    {
        $for_dealer = !empty($dealer_rubric) ? 'AND
                    rubric_id NOT IN ('. join(', ', $dealer_rubric).')' : '';
	    $sql = '
                SELECT
                    id,
                    title,
                    alias,
                    content,
                    cover,
                    abstract_info,
                    video,
					publish_date,
					rubric_id
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1';

					if($rub>0)$sql .= ' AND rubric_id='.$rub;
					$sql .='
                    AND
                    options @> \'"is_tips"=>"1"\'::hstore
                    '. $for_dealer .'
                ORDER BY
                    publish_date DESC
                LIMIT
                    '.\config::get( 'limits/news' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/news' ))
            ;
	    return $this->get($sql,

            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getTotalTips( $lang_id,$rub = 0 )
    {
	$sql =             '
                SELECT
                    COUNT(id) as count
                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1';
					if($rub>0)$sql .= ' AND rubric_id='.$rub;
					$sql .= '
                    AND
                    options @> \'"is_tips"=>"1"\'::hstore
                LIMIT
                    1
            ';
        return $this->get(
			$sql,
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getVideos( $lang_id, $dealer_rubric = null )
    {
        $for_dealer = !empty($dealer_rubric) ? 'AND
                    rubric_id NOT IN ('. join(', ', $dealer_rubric).')' : '';
        return $this->get(
            '
                SELECT
                    id,
                    title,
                    alias,
                    video,
                    options,
                    rubric_id

                FROM
                    public.news
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1
                    AND
                    video IS NOT NULL
                    '. $for_dealer .'
                ORDER BY
                    video_sort ASC
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////
    public function getAllNewsData($lang_id, $page='')
    {
       /* return $this->get(
            '
                SELECT * FROM public.news
                WHERE lang_id = :lang_id
                ORDER BY id DESC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/admin_orders' ))
            ,
        [
            'lang_id' => $lang_id
        ],
            -1
        );*/
        return $this->get(
            '
                SELECT * FROM public.news

                ORDER BY id DESC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/admin_orders' ))
            ,
        [

        ],
            -1
        );
    }
    /////////////////////////////////////////////////////////////////////////////
    public function getOneNewsData($id)
    {
        return $this->get(
            '
                SELECT * FROM public.news
                WHERE id = :id
            ',
            [
                'id' => $id,
            ],
            -1
        );
    }
    /////////////////////////////////////////////////////////////////////////////
    public function deleteNews($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.news
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }
    /////////////////////////////////////////////////////////////////////////////
    public function addLangData($data, $id)
    {
        if($data['options'] == 'is_news') {
            $options = '"is_news"=>1';
        } else if($data['options'] == 'is_tips'){
            $options = '"is_tips"=>1';
        } else {
            $options = '';
        }

        return $this->get(
            '
                INSERT INTO
                    public.news
                        (   id,
							rubric_id,
                            title,
                            alias,
                            meta_title,
                            meta_description,
                            meta_keywords,
                            content,
                            status,
                            group_id,
                            video,
							video_sort,
                            lang_id,
                            cover,
                            pic_status,
                            abstract_info,
                            options

                        )
                        VALUES
                        (   :id,
							:rubric_id,
                            :title,
                            :alias,
                            :meta_title,
                            :meta_description,
                            :meta_keywords,
                            :content,
                            :status,
                            :group_id,
                            :video,
							:video_sort,
                            :lang_id,
                            :cover,
                            :pic_status,
                            :abstract_info,
                            \''.$options.'\'
                        )
                        RETURNING id
            ',
            [
                "rubric_id"             => $data["rubric"],
				"title"             => $data["title"],
                "alias"             => $data["alias"],
                "meta_title"        => $data["meta_title"],
                "meta_description"  => $data["meta_description"],
                "meta_keywords"     => $data["meta_keywords"],
                "content"           => $data["content"],
                "status"            => $data["status"],
                "group_id"          => $data["products_id"],
                "video"             => $data["video"],
				"video_sort"             => $data["video_sort"],
                "lang_id"           => $data['lang_id'],
                "cover"             => $data['cover'],
                "pic_status"        => $data['pic_status'],
                "abstract_info"     => $data["abstract"],
                "id"                => $id
            ],
            -1
        );


    }
    /////////////////////////////////////////////////////////////////////////////////
    public function updateLangData($data, $id)
    {
        if($data['options'] == 'is_news') {
            $options = '"is_news"=>1';
        } else if($data['options'] == 'is_tips'){
            $options = '"is_tips"=>1';
        } else {
            $options = '';
        }

        $this->exec(
            '
                UPDATE
                    public.news
                SET
                            rubric_id = :rubric,
							title = :title,
                            alias = :alias,
                            meta_title = :meta_title,
                            meta_description = :meta_description,
                            meta_keywords = :meta_keywords,
                            content = :content,
                            status = :status,
                            group_id = :group_id,
                            video = :video,
							video_sort = :video_sort,
                            lang_id = :lang_id,
                            cover = :cover,
                            pic_status = :pic_status,
                            abstract_info = :abstract_info,
                            options = \''.$options.'\'
                WHERE
                    id              = :id
                AND lang_id         = :lang_id
            ',
            [
                "rubric"             => $data["rubric"],
				"title"             => $data["title"],
                "alias"             => $data["alias"],
                "meta_title"        => $data["meta_title"],
                "meta_description"  => $data["meta_description"],
                "meta_keywords"     => $data["meta_keywords"],
                "content"           => $data["content"],
                "status"            => $data["status"],
                "group_id"          => $data["products_id"],
                "video"             => $data["video"],
				"video_sort"             => $data["video_sort"],
                "lang_id"           => $data["lang_id"],
                "cover"             => $data["cover"],
                "pic_status"        => $data['pic_status'],
                "abstract_info"     => $data["abstract"],

                "id" => $id
            ]
        );

    }
    //////////////////////////////////////////////////////

    public function countData($lang_id = 1 )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total

                FROM
                    public.news WHERE lang_id = :lang_id
            ',
            [
				'lang_id'=>$lang_id
            ],
            -1
        );
    }
    public function countData2()
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total

                FROM
                    public.news
            ',
            [

            ],
            -1
        );
    }
    ///////////////////////////////////////////////////////////////////////
    public function addData($data)
    {
        try
        {
            $max_id = $this->get(
                '
                    SELECT
                        MAX(id) as max_id
                    FROM
                        public.news
                    LIMIT 1
                ',
                [
                ],
                -1
            );

            $id = $max_id['0']['max_id'] + 1;

            if( !empty( $data['1'] ) )
            {
                $data['1']['lang_id'] = 1;
                $this->addLangData($data[1], $id);
            }

            if( !empty( $data['2'] ) )
            {
                $data['2']['lang_id'] = 2;
                $this->addLangData($data[2], $id);
            }

            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
        }

        return false;


    }

    public function updateData($data, $id)
    {
        try
        {

            $data_lang = $this->get(
                '
                    SELECT
                        lang_id
                    FROM
                        public.news
                    WHERE
                        id      = :id
                ',
                [
                    'id' => $id
                ],
                -1
            );


            $lang_ids = $this->getDi()->get('common')->array_column( $data_lang, 'lang_id' );

            if( !empty( $data['1'] ) )
            {
                if( in_array( 1, $lang_ids ) )
                {
                    $data['1']['lang_id'] = 1;
                    $this->updateLangData($data[1],$id);
                }
                else
                {
                    $data['1']['lang_id'] = 1;
                    $this->addLangData($data[1], $id);
                }
            }

            if( !empty( $data[2] ) )
            {
                if( in_array( 2, $lang_ids ) )
                {
                    $data['2']['lang_id'] = 2;

                    $this->updateLangData($data[2],$id);
                }
                else
                {
                    $data['2']['lang_id'] = 2;
                    $this->addLangData($data[2], $id);
                }
            }



            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
        }

        return false;


    }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
