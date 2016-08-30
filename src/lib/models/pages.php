<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class pages extends \db
{
    /////////////////////////////////////////////////////////////////////////////

    public function getPages( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    content_title,
                    alias
                FROM
                    public.pages
                WHERE
                    lang_id = :lang_id
                    AND
                    status = 1
                ORDER BY
                    id ASC
            ',
            [
                'lang_id' => $lang_id
            ],
            5
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getPage( $page_id, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    meta_title,
                    meta_keywords,
                    meta_description,
                    alias,
                    content_title,
                    content_text
                FROM
                    public.pages
                WHERE
                    lang_id = :lang_id
                    AND
                    id      = :page_id
                    AND
                    status = 1
                ORDER BY
                    id ASC
            ',
            [
                'lang_id' => $lang_id,
                'page_id' => $page_id
            ],
            60
        );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function getAdminPages($page)
    {
        return $this->get(
            '
                SELECT
                    id,
                    content_title,
                    lang_id
                FROM
                    public.pages
                WHERE
                    lang_id = 1
                ORDER BY
                    id ASC
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

    public function getAdminPageById( $page_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    meta_title,
                    meta_keywords,
                    meta_description,
                    alias,
                    content_title,
                    content_text,
                    status,
                    lang_id
                FROM
                    public.pages
                WHERE
                    id      = :page_id
            ',
            [
                'page_id' => $page_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function updatePageWithLangId( $page, $lang_id )
    {

        return $this->exec(
            '
                UPDATE
                    public.pages
                SET
                    content_title         = :content_title,
                    alias                 = :alias,
                    content_text          = :content_text,
                    meta_title            = :meta_title,
                    meta_keywords         = :meta_keywords,
                    meta_description      = :meta_description,
                    status                = :status,
                    lang_id               = :lang_id
                WHERE
                    id                    = :id
                    AND
                    lang_id               = :lang_id
            ',
            [
                'id'                    => $page['page_id'],
                'content_title'         => $page['page_title'],
                'alias'                 => $page['page_alias'],
                'content_text'          => $page['page_content_text'],
                'meta_title'            => $page['page_meta_title'],
                'meta_keywords'         => $page['page_meta_keywords'],
                'meta_description'      => $page['page_meta_description'],
                'status'                => $page['page_status'],
                'lang_id'               => $lang_id

            ]
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function addPageWithLangIdPageId( $page, $page_id, $lang_id )
    {
        return $this->exec(
            '
                INSERT INTO
                    public.pages
                    (
                        id,
                        lang_id,
                        alias,
                        meta_title,
                        meta_keywords,
                        meta_description,
                        content_title,
                        content_text,
                        status
                    )
                    VALUES
                    (
                        :id,
                        :lang_id,
                        :alias,
                        :meta_title,
                        :meta_keywords,
                        :meta_description,
                        :content_title,
                        :content_text,
                        :status
                    )
            ',
            [
                'id'                    => $page_id,
                'content_title'         => $page['page_title'],
                'alias'                 => $page['page_alias'],
                'content_text'          => $page['page_content_text'],
                'meta_title'            => $page['page_meta_title'],
                'meta_keywords'         => $page['page_meta_keywords'],
                'meta_description'      => $page['page_meta_description'],
                'status'                => $page['page_status'],
                'lang_id'               => $lang_id
            ]
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function updatePages( $page, $page_id )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $pages_with_lang = $this->get(
                '
                    SELECT
                        lang_id
                    FROM
                        public.pages
                    WHERE
                        id      = :page_id
                ',
                [
                    'page_id' => $page_id
                ],
                -1
            );

            $lang_ids = $this->getDi()->get('common')->array_column( $pages_with_lang, 'lang_id' );

            if( !empty( $page['1'] ) )
            {
                if( in_array( 1, $lang_ids ) )
                {
                    $this->updatePageWithLangId( $page['1'], 1 );
                }
                else
                {
                    $this->addPageWithLangIdPageId( $page['1'], $page_id, 1 );
                }
            }

            if( !empty( $page['2'] ) )
            {
                if( in_array( 2, $lang_ids ) )
                {
                    $this->updatePageWithLangId( $page['2'], 2 );
                }
                else
                {
                    $this->addPageWithLangIdPageId( $page['2'], $page_id, 2 );
                }
            }

            $connection->commit();

            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
            $connection->rollback();
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function addPages( $page )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            $max_id = $this->get(
                '
                    SELECT
                        MAX(id) as max_id
                    FROM
                        public.pages
                    LIMIT 1
                ',
                [
                ],
                -1
            );

            $page_id = $max_id['0']['max_id'] + 1;

            if( !empty( $page['1'] ) )
            {
                $this->addPageWithLangIdPageId( $page['1'], $page_id, 1 );
            }

            if( !empty( $page['2'] ) )
            {
                $this->addPageWithLangIdPageId( $page['2'], $page_id, 2 );
            }

            $connection->commit();

            return true;
        }
        catch(\Exception $e)
        {
            //$this->showException( $e );
            $connection->rollback();
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function deletePages( $page_id )
    {
        return $this->exec(
            '
                DELETE
                FROM
                    public.pages
                WHERE
                    id                  = :id
            ',
            [
                'id'                    => $page_id
            ]
        );
    }

    /////////////////////////////////////////////////////////////////////////////
    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.pages
            ',
            [

            ],
            -1
        );
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////