<?php



namespace models;

class preorders extends \db
{

    public function getPreOrderByCustomerId($customer_id) {
        return $this->get(
            '
            SELECT
                id,
                created_date,
                last_modified_date
            FROM preorders
            WHERE preorders.customer_id = :customer_id
            ',
            [
                'customer_id' => $customer_id
            ],
            -1
        );
    }

    public function getPreOrdersByPreOrderId( $preorder_id, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    item_id,
                    item_count,
                    (
                        SELECT
                            price2
                        FROM
                            public.items
                        WHERE
                            id = public.preorders2items.item_id
                        LIMIT 1
                    ) AS price,
                    (
                        SELECT
                            size
                        FROM
                            public.items
                        WHERE
                            id = public.preorders2items.item_id
                        LIMIT 1
                    ) AS size,
                    (
                        SELECT
                            title
                        FROM
                            public.items_i18n
                        WHERE
                            item_id = public.preorders2items.item_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS title,
                    (
                        SELECT
                            alias
                        FROM
                            public.items_group_alias
                        WHERE
                            group_id =
                            (
                                SELECT
                                    group_id
                                FROM
                                    public.items
                                WHERE
                                    id = public.preorders2items.item_id
                                LIMIT 1
                            )
                            LIMIT 1
                    ) AS group_alias,
                    (
                        SELECT
                            cover
                        FROM
                            public.items_group
                        WHERE
                            group_id =
                            (
                                SELECT
                                    group_id
                                FROM
                                    public.items
                                WHERE
                                    id = public.preorders2items.item_id
                                LIMIT 1
                            )
                            LIMIT 1
                    ) as cover,
                    (
                        SELECT
                            alias
                        FROM
                            public.types_i18n
                        WHERE
                            type =
                            (
                                SELECT
                                    type
                                FROM
                                    public.items
                                WHERE
                                    id = public.preorders2items.item_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS type_alias,
                    (
                        SELECT
                            alias
                        FROM
                            public.subtypes_i18n
                        WHERE
                            subtype =
                            (
                                SELECT
                                    subtype
                                FROM
                                    public.items
                                WHERE
                                    id = public.preorders2items.item_id
                                LIMIT 1
                            )
                            AND
                            type =
                            (
                                SELECT
                                    type
                                FROM
                                    public.items
                                WHERE
                                    id = public.preorders2items.item_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                    ) AS subtype_alias

                FROM
                    public.preorders2items
                WHERE
                    preorder_id = :preorder_id
            ',
            [
                'preorder_id'  => $preorder_id,
                'lang_id'   => $lang_id
            ],
            -1
        );
    }


    public function getPreOrdersWithIds( $preorders_ids )
    {
        return $this->get(
            '
                SELECT
                    order_id,
                    item_count,
                    price
                FROM
                    public.preorders2items
                WHERE
                    preorder_id IN ('.join( ',', $preorders_ids ).')
            ',
            [

            ],
            -1
        );
    }

    public function removePreOrderItem($item_id) {
        return $this->get(
            '
            DELETE FROM public.preorders2items
            WHERE preorders2items.item_id = :item_id
            ',
            [
                'item_id' => $item_id
            ],
            -1
        );
    }


    public function countAllPreOrders()
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.preorders
            ',
            [

            ],
            -1
        );
    }



}

