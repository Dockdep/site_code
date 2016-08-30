<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class properties extends \db
{
    /////////////////////////////////////////////////////////////////////////////

    public function getPropertiesByItemId( $lang_id, $item_id  )
    {
        return $this->get(
            '
                SELECT
                    id,
                    property_key_id,
                    property_value_id,
                    (
                        SELECT
                            value
                        FROM
                            public.properties_keys_i18n
                        WHERE
                            property_key_id = public.properties.property_key_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS key_value,
                    (
                        SELECT
                            value
                        FROM
                            public.properties_values_i18n
                        WHERE
                            property_value_id = public.properties.property_value_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS value_value
                FROM
                    public.properties
                WHERE
                    id IN
                    (
                        SELECT
                            property_id
                        FROM
                            properties_items
                        WHERE
                            item_id = :item_id
                    )
            ',
            [
                'lang_id'   => $lang_id,
                'item_id'   => $item_id,
            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getPropertiesByTypeSubtype( $catalog, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    property_key_id,
                    property_value_id,
                    (
                        SELECT
                            value
                        FROM
                            public.properties_keys_i18n
                        WHERE
                            property_key_id = public.properties.property_key_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS key_value,
                    (
                        SELECT
                            value
                        FROM
                            public.properties_values_i18n
                        WHERE
                            property_value_id = public.properties.property_value_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS value_value
                FROM
                    public.properties
                WHERE
                  catalog = (
                  SELECT
                    catalog
                  FROM
                    public.catalog_i18n
                  WHERE
                    full_alias = :catalog
                  LIMIT
                  1
                  )


            ',
            [
                'lang_id'       => $lang_id,
                'catalog'       => $catalog

            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////

    public function getPropertiesForItems( $items_ids  )
    {
        return $this->get(
            '
                SELECT
                    property_id,
                    item_id
                FROM
                    public.properties_items
                WHERE
                    item_id IN ('.join( ',', $items_ids ).')

            ',
            [

            ],
            -1
        );
    }

    /////////////////////////////////////////////////////////////////////////////
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////