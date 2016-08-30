<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

use Phalcon\Tag\Select;
use Phalcon\Db\Column as Column;

class catalog extends \db
{
    /////////////////////////////////////////////////////////////////////////////
    public function getTranslateData($table, $fields){
        return $this->get_num(
            "
                SELECT
                  $fields
                FROM
                    public.$table
            ",
            [
            ],
            -1
        );
    }
    public function getTypes( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    type,
                    title,
                    alias,
                    meta_title,
                    meta_keywords,
                    meta_description,
                    (
                        SELECT
                            parent_id
                        FROM
                            public.types
                        WHERE
                            type = public.types.id
                    ) AS parent_id
                FROM
                    public.types_i18n
                WHERE
                    lang_id = :lang_id
                    AND
                    type IN
                    (
                        SELECT
                            id
                        FROM
                            public.types
                        WHERE
                            status = 1
                    )
                ORDER BY
                  type ASC
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

////////////////////////////////////////////////////////////


   ///////////////////////////////////////////////////////////
    public function getSubtypes( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    type,
                    cover,
                    (
                        SELECT
                            title
                        FROM
                            public.subtypes_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            subtype = public.subtypes.id
                            AND
                            type = public.subtypes.type
                        LIMIT
                            1
                    ) AS title,
                    (
                        SELECT
                            alias
                        FROM
                            public.subtypes_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            subtype = public.subtypes.id
                            AND
                            type = public.subtypes.type
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            meta_title
                        FROM
                            public.subtypes_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            subtype = public.subtypes.id
                            AND
                            type = public.subtypes.type
                        LIMIT
                            1
                    ) AS meta_title,
                    (
                        SELECT
                            meta_keywords
                        FROM
                            public.subtypes_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            subtype = public.subtypes.id
                            AND
                            type = public.subtypes.type
                        LIMIT
                            1
                    ) AS meta_keywords,
                    (
                        SELECT
                            meta_description
                        FROM
                            public.subtypes_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            subtype = public.subtypes.id
                            AND
                            type = public.subtypes.type
                        LIMIT
                            1
                    ) AS meta_description
                FROM
                    public.subtypes
                WHERE
                    status = 1
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getTitles( $type_ids, $subtype_ids, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    title,
                    subtype,
                    type
                FROM
                    public.subtypes_i18n
                WHERE
                    lang_id = :lang_id
                    AND
                    type IN ('.join( ',', $type_ids ).')
                    AND
                    subtype IN ('.join( ',', $subtype_ids ).')
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getTypesForCatalog( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    cover,
                    parent_id,
                    (
                        SELECT
                            title
                        FROM
                            public.types_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            type = public.types.id
                        LIMIT
                            1
                    ) AS title,
                    (
                        SELECT
                            alias
                        FROM
                            public.types_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            type = public.types.id
                        LIMIT
                            1
                    ) AS alias
                FROM
                    public.types
                WHERE
                    status = 1
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function insertCatalog( $catalog, $lang_id )
    {
        $connection = $this->database;

        try
        {
            $connection->begin();

            foreach( $catalog as $key => $value )
            {
                $data_catalog = $this->get(
                    '
                        INSERT INTO
                            public.catalog
                                (
                                    parent_id,
                                    type,
                                    subtype,
                                    cover
                                )
                                VALUES
                                (
                                    :parent_id,
                                    :type,
                                    :subtype,
                                    :cover
                                )
                                RETURNING id
                    ',
                    [
                        'parent_id' => $value['parent_id'],
                        'type'      => $value['type'],
                        'subtype'   => $value['subtype'],
                        'cover'     => $value['cover']
                    ],
                    -1
                );

                $catalog = $data_catalog['0']['id'];

                $data_catalog_i18n = $this->exec(
                    '
                        INSERT INTO
                            public.catalog_i18n
                                (
                                    catalog,
                                    lang_id,
                                    title,
                                    alias
                                )
                                VALUES
                                (
                                    :catalog,
                                    :lang_id,
                                    :title,
                                    :alias
                                )
                    ',
                    [
                        'catalog'           => $catalog,
                        'lang_id'           => $lang_id,
                        'title'             => $value['title'],
                        'alias'             => $value['alias']
                    ]
                );
            }

            $connection->commit();

            return true;
        }
        catch(\Exception $e)
        {
            $this->showException( $e );
            $connection->rollback();
        }

        return false;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function insertCatalogAlias( $catalog, $lang_id )
    {
        foreach( $catalog as $c )
        {
            $data = $this->exec(
                '
                    UPDATE
                        public.catalog_i18n
                    SET
                        full_alias        = :full_alias
                    WHERE
                        catalog           = :catalog
                        AND
                        lang_id           = :lang_id
                ',
                [
                    'catalog'       => $c['id'],
                    'full_alias'    => $c['alias'],
                    'lang_id'       => $lang_id,

                ]
            );
        }

        return true;
    }
    /////////////////////////////////////////////////////////////////////////////////////
    public function getFullAlias($lang_id, $catalog_id)
    {
        return $this->get(
            '
                SELECT
                  full_alias
                FROM
                    public.catalog_i18n
                WHERE
                      catalog = :catalog
                AND
                      lang_id = :lang_id
            ',
            [
                'lang_id' => $lang_id,
                'catalog' => $catalog_id
            ],
            -1
        );

    }
    /////////////////////////////////////////////////////////////////////////////

    public function getCatalog( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    parent_id,
		            cover,
                    subtype,
                    (
                        SELECT
                            title
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                    ) AS title,
                    (
                        SELECT
                            full_alias
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                    ) AS alias
                FROM
                    public.catalog
                WHERE
                      status = 1

                ORDER BY
                  sort ASC
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getCatalogForInsertAlias( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    parent_id,
                    (
                        SELECT
                            title
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                    ) AS title,
                    (
                        SELECT
                            alias
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                    ) AS alias
                FROM
                    public.catalog
                WHERE
                      status = 1
                ORDER BY
                  id ASC
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getCatalogWithTree( $catalog )
    {
        return $this->get(
            '
                WITH RECURSIVE catalogtree(id, parent_id, path) AS
                (
                    SELECT
                        id,
                        parent_id,
                        array[id] AS path
                    FROM
                        public.catalog
                    WHERE
                        parent_id = 0
                    UNION ALL
                    SELECT
                        t.id,
                        t.parent_id,
                        ct.path || t.id
                    FROM
                        public.catalog t
                    JOIN
                        catalogtree ct
                        ON ct.id = t.parent_id
                )
                SELECT
                    *
                FROM
                    catalogtree
                WHERE
                    id = :id
                ORDER BY
                    id ASC;
            ',
            [
                'id' => $catalog
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getCatalogWithTreeByAlias( $catalog_alias, $lang_id )
    {
        $path = $this->get(
            '
                WITH RECURSIVE catalogtree(id, parent_id, path) AS
                (
                    SELECT
                        id,
                        parent_id,
                        array[id] AS path
                    FROM
                        public.catalog
                    WHERE
                        parent_id = 0
                    UNION ALL
                    SELECT
                        t.id,
                        t.parent_id,
                        ct.path || t.id
                    FROM
                        public.catalog t
                    JOIN
                        catalogtree ct
                        ON ct.id = t.parent_id
                )
                SELECT
                    path
                FROM
                    catalogtree
                WHERE
                    id =
                    (
                        SELECT
                            catalog
                        FROM
                            public.catalog_i18n
                        WHERE
                            alias = :alias
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    )
            ',
            [
                'alias' => $catalog_alias,
                'lang_id' => $lang_id
            ],
            -1
        );

        return $path['0']['path'];
    }

    /////////////////////////////////////////////////////////////////////////////



    public function getCatalogByCatalogIds( $catalog_ids, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    parent_id,
                    type,
                    subtype,
                    cover,
                    (
                        SELECT
                            title
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                        LIMIT
                            1
                    ) AS title,
                    (
                        SELECT
                            alias
                        FROM
                            public.catalog_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            catalog = public.catalog.id
                        LIMIT
                            1
                    ) AS alias
                FROM
                    public.catalog
                WHERE
                    id IN ('.join( ',', $catalog_ids ).')
                    OR
                    parent_id = '.array_pop( $catalog_ids ).'
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getCatalogPathByIds( $catalog )
    {
        return $this->get(
            '
                WITH RECURSIVE catalogtree(id, parent_id, path) AS
                (
                    SELECT
                        id,
                        parent_id,
                        array[id] AS path
                    FROM
                        public.catalog
                    WHERE
                        parent_id = 0
                    UNION ALL
                    SELECT
                        t.id,
                        t.parent_id,
                        ct.path || t.id
                    FROM
                        public.catalog t
                    JOIN
                        catalogtree ct
                        ON ct.id = t.parent_id
                )
                SELECT
                    *
                FROM
                    catalogtree
                WHERE
                    id = :id
                ORDER BY
                    id ASC;
            ',
            [
                'id' => $catalog
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getFiltersForCatalog()
    {
        return $this->get(
            '
                SELECT
                    property_id,
                    type,
                    subtype
                FROM
                    public.properties_items
            ',
            [

            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function addCatalog2Filter( $filters_add )
    {
        foreach( $filters_add as $f )
        {
            $data = $this->exec(
                '
                    UPDATE
                        public.properties_items
                    SET
                        catalog        = :catalog
                    WHERE
                        property_id             = :id
                ',
                [
                    'catalog'          => $f['catalog'],
                    'id'        => $f['id']

                ]
            );
        }

        return true;
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getFullAliasForItem($lang_id,$item)
    {
        $num = count($item);
        for($i=0; $i<$num; $i++){
            $item[$i]['full_alias'] = $this->getFullAlias($lang_id,$item[$i]['catalog'])[0]['full_alias'];
        }
        return $item;
    }


    public function getCatalogUrl($full_alias, $change_lang)
    {
        return $this->get(
            '
                SELECT
                    full_alias
                FROM
                    public.catalog_i18n
                WHERE
                    catalog = (
                        SELECT
                            catalog
                        FROM
                            public.catalog_i18n
                        WHERE
                            full_alias = :full_alias
                    )
                AND lang_id = :lang_id
                 LIMIT
                        1
            ',
            [
                'full_alias'     => $full_alias,
                'lang_id'        => $change_lang
            ],
            -1
        );
    }




}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

