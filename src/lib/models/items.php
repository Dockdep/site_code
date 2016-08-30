<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class items extends \db
{
    public function getAllData() {
        return $this->get('
            SELECT * FROM items_group_alias
        ');
    }
    public function getTopGroupsByCustomer($lang_id, $id) {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                    LEFT JOIN (
                        SELECT SUM(num) AS num, group_id AS top_groups FROM
                        (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                        FROM orders o
                        INNER JOIN customers ON customers.id = o.customer_id
                        RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                        LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                        WHERE o.created_date
                        BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                        AND lang_id = 1
                        AND customers.id = ' . $id . '
                        GROUP BY o2i.item_id,i.group_id, i.title) foo
                        GROUP BY group_id
                        ORDER BY num DESC
                ) numb ON numb.top_groups = public.items_group.group_id
                WHERE
                group_id IN
                (
                SELECT group_id FROM
                    (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    INNER JOIN customers ON customers.id = o.customer_id
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    AND customers.id = ' . $id . '
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                )
                ORDER BY num DESC
                LIMIT 50'
            ,
            [
                'lang_id' => $lang_id,
            ],
            60*60*24
        );
    }

    public function getDealersTopGroups($lang_id) {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                    LEFT JOIN (
                        SELECT SUM(num) AS num, group_id AS top_groups FROM
                        (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                        FROM orders o
                        INNER JOIN customers ON customers.id = o.customer_id
                        RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                        LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                        WHERE o.created_date
                        BETWEEN \''.\config::get( 'top_items/from_three_month' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                        AND lang_id = 1
                        AND customers.special_users_id IS NOT NULL
                        GROUP BY o2i.item_id,i.group_id, i.title) foo
                        GROUP BY group_id
                        ORDER BY num DESC
                ) numb ON numb.top_groups = public.items_group.group_id
                WHERE
                group_id IN
                (
                SELECT group_id FROM
                    (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    INNER JOIN customers ON customers.id = o.customer_id
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from_three_month' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    AND customers.special_users_id IS NOT NULL
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                )
                ORDER BY num DESC
                LIMIT 50'
            ,
            [
                'lang_id' => $lang_id
            ],
            60*60*24
        );
    }

    public function getAllTopGroups($lang_id) {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2
                FROM
                    public.items_group
                    LEFT JOIN (
                        SELECT SUM(num) AS num, group_id AS top_groups FROM
                        (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                        FROM orders o
                        RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                        LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                        WHERE o.created_date
                        BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                        AND lang_id = 1
                        GROUP BY o2i.item_id,i.group_id, i.title) foo
                        GROUP BY group_id
                        ORDER BY num DESC
                ) numb ON numb.top_groups = public.items_group.group_id
                WHERE
                group_id IN
                (
                SELECT group_id FROM
                    (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                )
                ORDER BY num DESC
                LIMIT 40'
            ,
            [
                'lang_id' => $lang_id
            ],
            60*60*24
        );
    }

    public function getTopGroups( $lang_id, $limit = 50, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                    LEFT JOIN (
                        SELECT SUM(num) AS num, group_id AS top_groups FROM
                        (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                        FROM orders o
                        RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                        LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                        WHERE o.created_date
                        BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                        AND lang_id = 1
                        GROUP BY o2i.item_id,i.group_id, i.title) foo
                        GROUP BY group_id
                        ORDER BY num DESC
                ) numb ON numb.top_groups = public.items_group.group_id
                WHERE
                group_id IN
                (
                SELECT group_id FROM
                    (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                )
                ORDER BY num DESC
                LIMIT
                    '.$limit.'
                OFFSET
                    '.($page-1)*($limit)
            ,
            [
                'lang_id' => $lang_id
            ],
            60*60*24
        );
    }

    public function getNewGroups( $lang_id, $limit = 50, $page = '1'  )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_new"=>"1"\'::hstore
                ORDER BY group_id
                LIMIT
                    '.$limit.'
                OFFSET
                    '.($page-1)*($limit)
            ,
            [
                'lang_id' => $lang_id
            ],
            60
        );
    }

    public function getRecommendedGroups( $lang_id, $limit = 50, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as type_id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id					
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_recommended"=>"1"\'::hstore
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                LIMIT
                    '.$limit.'
                OFFSET
                    '.($page-1)*($limit)
            ,
            [
                'lang_id' => $lang_id
            ],
           60
        );
    }

    public function getRecommendedGroupsByUsersGroup($lang_id, $users_group_name, $page = '1') {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as type_id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                LEFT JOIN users_groups2items_group
                ON items_group.group_id = users_groups2items_group.item_group_id
                LEFT JOIN users_groups
                ON users_groups2items_group.users_groups_id = users_groups.id
                WHERE
                    users_groups2items_group.options @> \'"is_recommended"=>"1"\'::hstore
                    AND users_groups.name = :users_group_name
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                LIMIT
                    '.\config::get( 'limits/top_items' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/top_items' ))
            ,
            [
                'lang_id' => $lang_id,
                'users_group_name' => $users_group_name
            ],
            60
        );
    }

    public function getNewGroupsByUsersGroup( $lang_id, $users_group_name, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                LEFT JOIN users_groups2items_group
                ON items_group.group_id = users_groups2items_group.item_group_id
                LEFT JOIN users_groups
                ON users_groups2items_group.users_groups_id = users_groups.id
                WHERE
                    users_groups2items_group.options @> \'"is_recommended"=>"1"\'::hstore
                    AND users_groups.name = :users_group_name
                ORDER BY group_id
                LIMIT
                    '.\config::get( 'limits/top_items' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/top_items' ))
            ,
            [
                'lang_id' => $lang_id,
                'users_group_name' => $users_group_name
            ],
            60
        );
    }

    public function getTopGroupsByUsersGroup( $lang_id, $users_group_name, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    )
                    type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
					(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                LEFT JOIN users_groups2items_group
                ON items_group.group_id = users_groups2items_group.item_group_id
                LEFT JOIN users_groups
                ON users_groups2items_group.users_groups_id = users_groups.id
                LEFT JOIN (
                  SELECT SUM(num) AS num, group_id AS top_groups FROM
                  (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                    ORDER BY num DESC
                ) numb ON numb.top_groups = public.items_group.group_id
                WHERE
                group_id IN
                (
                SELECT group_id FROM
                    (SELECT o2i.item_id, COUNT(o2i.item_id) AS num, i.group_id, i.title
                    FROM orders o
                    RIGHT JOIN orders2items o2i ON o.id = o2i.order_id
                    LEFT JOIN items_i18n i ON o2i.item_id = i.item_id
                    WHERE o.created_date
                    BETWEEN \''.\config::get( 'top_items/from' ).'\' AND \''.\config::get( 'top_items/to' ).'\'
                    AND lang_id = 1
                    GROUP BY o2i.item_id,i.group_id, i.title) foo
                    GROUP BY group_id
                )
                AND
                    users_groups2items_group.options @> \'"is_recommended"=>"1"\'::hstore
                AND users_groups.name = :users_group_name
                ORDER BY num DESC
                LIMIT
                    '.\config::get( 'limits/top_items' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/top_items' ))
            ,
            [
                'lang_id' => $lang_id,
                'users_group_name' => $users_group_name

            ],
            60*60*24
        );
    }

    public function getStockGroupsByUsersGroup( $lang_id, $users_group_name, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
										(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                LEFT JOIN users_groups2items_group
                ON items_group.group_id = users_groups2items_group.item_group_id
                LEFT JOIN users_groups
                ON users_groups2items_group.users_groups_id = users_groups.id
                WHERE
                    users_groups2items_group.options @> \'"is_recommended"=>"1"\'::hstore
                AND users_groups.name = :users_group_name
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                LIMIT
                    '.\config::get( 'limits/top_items' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/top_items' ))
            ,
            [
                'lang_id' => $lang_id,
                'users_group_name' => $users_group_name
            ],
            60
        );
    }

    public function getStockGroups( $lang_id, $limit = 5, $page = '1' )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
										(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_stock"=>"1"\'::hstore
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                LIMIT
                    '.$limit.'
                OFFSET
                    '.($page-1)*$limit
            ,
            [
                'lang_id' => $lang_id,

            ],
            60
        );
    }

    public function getProfStockGroups($lang_id, $limit = 5, $page = '1') {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
										(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_prof_stock"=>"1"\'::hstore
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                LIMIT
                    '.$limit.'
                OFFSET
                    '.($page-1)*$limit
            ,
            [
                'lang_id' => $lang_id,

            ],
            60
        );
    }

    public function getTotalProfStockGroups() {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_prof_stock"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getGroupsBySubtype( $lang_id, $subtype, $page = 1 )
    {
        return $this->get(
            '
            SELECT
                group_id,
                cover,
                (
                    SELECT
                        alias
                    FROM
                        items_group_alias
                    WHERE
                        group_id = public.items_group.group_id
                        AND
                        type = :type
                        AND
                        subtype = :subtype
                        AND
                        lang_id = :lang_id
                ) AS alias,
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_group.group_id
                        )
                        AND
                        group_id = public.items_group.group_id
                    LIMIT 1
                ) as id,
                (
                    SELECT
                        price2
                    FROM
                        public.items
                    WHERE
                        group_id = public.items_group.group_id
                        AND
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_group.group_id
                        )
                    LIMIT 1
                ) AS min_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                    ) AS count_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
            FROM
                public.items_group
            WHERE
                status = 1
                AND
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        type = :type
                        AND
                        subtype = :subtype
                        AND
                        lang_id = :lang_id
                )
            LIMIT
                '.\config::get( 'limits/dealer_catalog' ).'
            OFFSET
                '.($page-1)*(\config::get( 'limits/dealer_catalog' ))
            ,
            [
                'lang_id'   => $lang_id,
                'subtype'   => $subtype,
            ],
            -1
        );
    }

    public function getGroupsBySearch( $lang_id, $search, $page = 1 ) {

        return $this->get(
            '
            SELECT
                    ig.group_id,
                    ig.cover,
                    ig.options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = ig.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT 1
                    ) as id,
                    (
                        SELECT
                            price2
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                        LIMIT 1
                    ) AS min_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                    ) AS count_price,
                    (
                        SELECT
                            title
                        FROM public.items_i18n
                        WHERE
                            lang_id = :lang_id
                        AND
                            group_id = ig.group_id

                        LIMIT 1
                    ) AS title,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            status = 1
                    ) AS count_available

                FROM
                    public.items_group as ig
				LEFT JOIN public.items as it ON
					(ig.group_id = it.group_id)
				LEFT JOIN public.items_i18n ON
				    (ig.group_id = public.items_i18n.group_id)
                WHERE
                    ig.status = 1
					AND
					it.status !=2
                    AND
                    ig.group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE

                            lang_id = :lang_id
                    )
                    AND
                    lang_id=:lang_id
                    AND
                    (title::text ILIKE  \'%' . $search . '%\'
                    OR
                    content_description::text ILIKE \'%' . $search . '%\'
					OR
					product_id::text ILIKE \'%' . $search . '%\'
					)
				GROUP BY ig.group_id

            LIMIT
                '.\config::get( 'limits/dealer_catalog' ).'
            OFFSET
                '.($page-1)*(\config::get( 'limits/dealer_catalog' ))
            ,
            [
                'lang_id'   => $lang_id
            ],
            -1
        );

    }

    public function getGroupIdsByCatalogId($catalog)
    {
        return $this->get(

            '
                SELECT
                    group_id
                FROM
                    public.items_group as ig
                WHERE
                    ig.group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            catalog = :catalog

                    )
            ',
            [
                'catalog' => $catalog
            ],
            -1
        );
    }

    public function getGroupsByCatalogId( $lang_id, $catalog, $page, $sort, $limit = 1000 )
    {

        $sql = 'min_price ASC';

        if( in_array( 1, $sort ) )
        {
            $sql = 'new ASC';
        }
        if( in_array( 2, $sort ) )
        {
            $sql = 'top ASC';
        }
        if( in_array( 3, $sort ) )
        {
            $sql .= ',min_price ASC';
        }
        if( in_array( 4, $sort ) )
        {
            $sql .= ',min_price DESC';
        }
        if( in_array( 3, $sort ) && in_array( 0, $sort ) )
        {
            $sql = 'min_price ASC';
        }
        if( in_array( 4, $sort ) && in_array( 0, $sort ) )
        {
            $sql = 'min_price DESC';
        }
        if( in_array( 5, $sort ) && in_array( 0, $sort ) )
        {
            $sql = 'title ASC';
        }
        if( in_array( 6, $sort ) && in_array( 0, $sort ) )
        {
            $sql = 'title DESC';
        }

        return $this->get(
            '
                SELECT
                    ig.group_id,
                    ig.options->\'is_new\' AS new,
                    ig.options->\'is_top\' AS top,
                    ig.cover,
                    ig.options,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT 1
                    ) as id,

                    (
                        SELECT
                            price2
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                        LIMIT 1
                    ) AS min_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                    ) AS count_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            status = 1
                    ) AS count_available,
                    (
                        SELECT
                          case when count(*) = 0  then 0 else 1 end
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            status = 1
                    ) AS checking,
                    (
                        SELECT
                            title
                        FROM public.items_i18n
                        WHERE
                            lang_id=:lang_id
                        AND
                            group_id = ig.group_id
                        LIMIT 1
                    ) AS title,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = ig.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias

                FROM
                    public.items_group as ig 
				LEFT JOIN public.items as it ON 
					(ig.group_id = it.group_id)
                WHERE
                    ig.status = 1
					AND 
					it.status !=2		
                    AND
                    ig.group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                    )
				GROUP BY ig.group_id	
                ORDER BY
                    checking DESC,
                    '.$sql.'
            LIMIT
                '.$limit.'
            OFFSET
                '.($page-1)*(\config::get( 'limits/items' ))
            ,
            [
                'lang_id'   => $lang_id,
                'catalog'   => $catalog
            ],
            60*60*12
        );
    }

    public function getGroupsByCatalogIdBackend( $lang_id, $catalog, $prices, $limit = 1000 )
    {

        return $this->get(
            '
                SELECT
                    ig.group_id,
                    ig.options->\'is_new\' AS new,
                    ig.options->\'is_top\' AS top,
                    ig.cover,
                    ig.options,
                    it.id as item_id,
                    it.size as size,
                    it.price2 as price2,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = ig.group_id
                            AND
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = ig.group_id
                        LIMIT 1
                    ) as id,

                    (
                        SELECT
                            price2
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = ig.group_id
                                LIMIT 1
                            )
                        LIMIT 1
                    ) AS min_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                    ) AS count_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = ig.group_id
                            AND
                            status = 1
                    ) AS count_available,
                    (
                        SELECT
                            title
                        FROM public.items_i18n
                        WHERE
                            lang_id=:lang_id
                        AND
                            group_id = ig.group_id
                        LIMIT 1
                    ) AS title,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = ig.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias

                FROM
                    public.items_group as ig
				INNER JOIN public.items as it ON
					(ig.group_id = it.group_id)
                WHERE
                    ig.status = 1
					AND
					it.status !=2
                    AND
                    ig.group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                    )
                    AND
                    price2 >= ' . $prices['0'].'
                    AND
                    price2 <= ' . $prices['1'].'
                ORDER BY
                    count_available
                    DESC
            LIMIT
                '.$limit
            ,
            [
                'lang_id'   => $lang_id,
                'catalog'   => $catalog
            ],
            -1
        );
    }

    public function getItemsWithMinPrice( $lang_id, $item_ids )
    {
        return $this->get(
            '
                SELECT
                    id,
                    price2,
                    price3,
                    price4,
                    price5,
                    price6,
                    size,
                    firm,
                    stock_availability,
                    (
                        SELECT
                            title
                        FROM
                            items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                    ) AS title,
                    (
                        SELECT
                            description
                        FROM
                            items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                    ) AS description,
                    (
                        SELECT
                            content_description
                        FROM
                            items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                    ) AS content_description
                FROM
                    public.items
                WHERE
                    id IN ('.$item_ids.')
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getAllItems( $lang_id, $type, $subtype )
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as items
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            type = :type
                            AND
                            subtype = :subtype
                            AND
                            lang_id = :lang_id

                    )
            ',
            [
                'lang_id' => $lang_id,
                'type' => $type,
                'subtype' => $subtype,
            ],
            -1
        );
    }

    public function getAllItemsWithCatalogId( $lang_id, $catalog )
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as items
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
							
                    )
            ',
            [
                'lang_id' => $lang_id,
                'catalog' => $catalog
            ],
            -1
        );
    }

    public function getMaxMinPrice( $type, $subtype )
    {
        return $this->get(
            '
                SELECT
                    MIN(price2) as min_price,
                    MAX(price2) as max_price
                FROM
                    public.items

                WHERE
                    type    = :type
                    AND
                    subtype = :subtype

            ',
            [
                'subtype'           => $subtype,
                'type'              => $type
            ],
            -1
        );
    }

    public function getMaxMinPriceWithCatalogId( $catalog )
    {
        return $this->get(
            '
                SELECT
                    MIN(price2) as min_price,
                    MAX(price2) as max_price
                FROM
                    public.items
                WHERE
                    catalog = :catalog

            ',
            [
                'catalog'           => $catalog
            ],
            -1
        );
    }

    public function getOneItem( $lang_id, $id )
    {
        return $this->get(
            '
                SELECT
                    i.id,
                    i.group_id,
                    i.product_id,
                    i.catalog,
                    i.price2,
                    i.type,
                    i.size,
                    i.color_id,
                    i.status,
                    i.photogallery,
                    i.cover,
                    i.subtype,
                    i.price3,
                    i.price4,
                    i.price5,
                    i.price6,
                    i.stock_availability,
                    i.firm,
                    i18n.meta_title,
                    i18n.meta_description,
                    i18n.title,
                    i18n.content_description,
                    i18n.description,
                    i18n.content_video,
                    i18n.front_video,
                    (
                        SELECT
                            full_alias
                        FROM
                            public.catalog_i18n
                        WHERE
                            catalog = i.catalog
                            AND
                            lang_id = :lang_id
                    ) AS full_alias
                FROM
                    public.items as i
                LEFT JOIN
                    public.items_i18n as i18n
                    ON ( i.id =  i18n.item_id AND lang_id = :lang_id )
                WHERE
                    id = :id
                LIMIT
                    1
            ',
            [
                'id'      => $id,
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getGroupWithItems( $lang_id )
    {
        return $this->get(
            '
                SELECT DISTINCT
                    items_group.group_id,
                    items.size,
                    items.id as item_id,
                    (
                        SELECT
                            title
                        FROM
                            items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                    ) AS title,
                    (
                        SELECT
                            title
                        FROM
                            public.colors_i18n
                        WHERE
                            color_id = public.items.color_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS color_title
                FROM items_group
                LEFT JOIN items
                ON items_group.group_id = items.group_id
                LEFT JOIN items_i18n
                ON items_group.group_id = items_i18n.group_id
                WHERE
                    lang_id = :lang_id
            ',
            [
                'lang_id'  => $lang_id
            ],
            -1
        );
    }

    public function getSizes( $lang_id, $type, $subtype, $group_alias )
    {
        return $this->get(
            '
                SELECT
                    id,
                    size,
                    color_id,
                    cover,
                    (
                        SELECT
                            absolute_color
                        FROM
                            public.colors
                        WHERE
                            id = public.items.color_id
                        LIMIT 1
                    ) AS absolute_color,
                    (
                        SELECT
                            title
                        FROM
                            public.colors_i18n
                        WHERE
                            color_id = public.items.color_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS color_title
                FROM
                    public.items
                WHERE
                    group_id =
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            type    = :type
                            AND
                            subtype = :subtype
                            AND
                            lang_id = :lang_id
                            AND
                            alias   = :alias
                    )
                ORDER BY
                    price2 ASC
            ',
            [
                'lang_id'       => $lang_id,
                'type'          => $type,
                'subtype'       => $subtype,
                'alias'         => $group_alias
            ],
            -1
        );
    }

    public function getSizesByGroupId( $lang_id, $group_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    size,
                    color_id,
                    cover,
                    price2,
                    price3,
                    price4,
                    price5,
                    price6,
                    stock_availability,
                    firm,
                    catalog,
                    group_id,
                    status,
                    (
                        SELECT
                            absolute_color
                        FROM
                            public.colors
                        WHERE
                            id = public.items.color_id
                        LIMIT 1
                    ) AS absolute_color,
                    (
                        SELECT
                            title
                        FROM
                            public.colors_i18n
                        WHERE
                            color_id = public.items.color_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS color_title
                FROM
                    public.items
                WHERE
                    group_id = :group_id
                ORDER BY
                    price2 ASC
            ',
            [
                'lang_id'       => $lang_id,
                'group_id'      => $group_id
            ],
            -1
        );
    }

    public function getGroupsByGroupId( $lang_id, $group_ids )
    {
        return $this->get(
            '
                SELECT DISTINCT
                items_group.group_id as id,
                title
                FROM
                    public.items_group
                INNER JOIN public.items_i18n ON
                  public.items_i18n.group_id = items_group.group_id
                WHERE
                    items_group.group_id IN ('. join(', ',$group_ids).')
                    AND
                    lang_id = :lang_id
            ',
            [
                'lang_id'       => $lang_id
            ],
            -1
        );
    }

    public function getGroupsByGroups($lang_id, $groups)
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT
                            1
                    ) as id,
										(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
					(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                group_id IN
                (
                    SELECT
                        group_id
                    FROM
                        items_group_alias
                    WHERE
                        lang_id = :lang_id
                )
                AND
                group_id IN ('. join(', ', $groups).')
               '
            ,
            [
                'lang_id' => $lang_id,

            ],
            60
        );

    }

    public function getColorsInfoByColorId( $lang_id, $id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    absolute_color,
                    (
                        SELECT
                            title
                        FROM
                            public.colors_i18n
                        WHERE
                            color_id = public.colors.id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS color_title
                FROM
                    public.colors
                WHERE
                    id = :id
            ',
            [
                'lang_id'       => $lang_id,
                'id'            => $id,
            ],
            -1
        );
    }

    public function getColorsInfoByColorsId( $lang_id, $id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    absolute_color,
                    (
                        SELECT
                            title
                        FROM
                            public.colors_i18n
                        WHERE
                            color_id = public.colors.id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS color_title
                FROM
                    public.colors
                WHERE
                    id IN ('.$id.')
            ',
            [
                'lang_id'       => $lang_id
            ],
            -1
        );
    }

    public function getItemsByColorAndGroupId( $group_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    size,
                    color_id
                FROM
                    public.items
                WHERE
                    group_id = :group_id
                ORDER BY
                    price2 ASC
            ',
            [
                'group_id'      => $group_id,
            ],
            -1
        );
    }

    public function getItemsByColorAndGroupsId( $group_id )
    {
        return $this->get(
            '
                SELECT
                    id,
                    size,
                    color_id
                FROM
                    public.items
                WHERE
                    group_id IN ('.$group_id.')
                ORDER BY
                    price2 ASC
            ',
            [
            ],
            -1
        );
    }

    public function getPopularItems( $lang_id )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as id,
                    (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as type

                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    options @> \'"is_top"=>"1"\'::hstore
                    AND
                    group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            lang_id = :lang_id
                    )
                ORDER BY
                    group_id DESC
                LIMIT
                    5
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getBuyWithItems( $lang_id, $group_id )
    {
        $data_groups = [];

        $data_group_ids_by_with = $this->get(
            '
                SELECT
                    group_id_buy_with
                FROM
                    public.items_group_buy_with
                WHERE
                    group_id = :group_id
            ',
            [
                'group_id'      => $group_id
            ],
            -1
        );

        if( !empty( $data_group_ids_by_with ) )
        {
            $group_ids_by_with_ = $this->getDi()->get('etc')->int2arr($data_group_ids_by_with['0']['group_id_buy_with']);
            $group_ids_by_with = join( ',', $group_ids_by_with_ );

            $data_groups = $this->get(
                '
                    SELECT
                        group_id,
                        cover,
                        options,
                        (
                            SELECT
                                alias
                            FROM
                                items_group_alias
                            WHERE
                                group_id = public.items_group.group_id
                                AND
                                lang_id = :lang_id
                        ) AS alias,
                        (
                            SELECT
                                count(*)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_group.group_id
                                AND
                                status = 1
                        ) AS count_available,
                       (
                        SELECT
                                type
                            FROM
                                public.items
                            WHERE
                                price2 IN
                                (
                                    SELECT
                                        MIN(price2)
                                    FROM
                                        public.items
                                    WHERE
                                        group_id = public.items_group.group_id
                                )
                                AND
                                group_id = public.items_group.group_id
                            LIMIT
                                1
                        ) as type_id,
                        (
                            SELECT
                                full_alias
                            FROM
                                catalog_i18n
                            WHERE
                                catalog =
                                (
                                    SELECT
                                        catalog
                                    FROM
                                        items_group_alias
                                    WHERE
                                        group_id = public.items_group.group_id
                                        AND
                                        lang_id = :lang_id
                                    LIMIT 1
                                )
                                AND
                                lang_id = :lang_id
                            LIMIT 1
                        ) AS catalog_alias,
                        (
                            SELECT
                                catalog
                            FROM
                                items_group_alias
                            WHERE
                                group_id = public.items_group.group_id
                                AND
                                lang_id = :lang_id
                            LIMIT
                                1
                        ) AS catalog,
                        (
                            SELECT
                                id
                            FROM
                                public.items
                            WHERE
                                price2 IN
                                (
                                    SELECT
                                        MIN(price2)
                                    FROM
                                        public.items
                                    WHERE
                                        group_id = public.items_group.group_id
                                )
                                AND
                                group_id = public.items_group.group_id
                                      LIMIT 1
                        ) as id,
                                            (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as type
                    FROM
                        public.items_group
                    WHERE
                        status = 1
                        AND
                        group_id IN ('.$group_ids_by_with.')
                    LIMIT
                        5
                ',
                [
                    'lang_id'       => $lang_id
                ],
                -1
            );
        }

        return $data_groups;
    }

    public function getSameItems( $lang_id, $catalog )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as id,
                                        (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as type,
                    			(
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items_group_alias
                        WHERE
                            catalog = :catalog
                            AND
                            lang_id = :lang_id
                    )
                ORDER BY
                    group_id DESC
                LIMIT
                    5
            ',
            [
                'lang_id'   => $lang_id,
                'catalog'   => $catalog,
            ],
            -1
        );
    }

    public function getLookedGroups( $lang_id, $looked )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                    ) AS alias,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog,
                    (
                        SELECT
                            full_alias
                        FROM
                            catalog_i18n
                        WHERE
                            catalog =
                            (
                                SELECT
                                    catalog
                                FROM
                                    items_group_alias
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    lang_id = :lang_id
                                LIMIT 1
                            )
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS catalog_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as id,
                                   (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as type
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN
                    (
                        SELECT
                            group_id
                        FROM
                            items
                        WHERE
                            id IN ('.join( ',', $looked ).')
                    )
                LIMIT
                    5
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getNews2Groups( $lang_id, $groups_ids )
    {
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    			(
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
					) as price2,
                    (
                            SELECT
                                full_alias
                            FROM
                                catalog_i18n
                            WHERE
                                catalog =
                                (
                                    SELECT
                                        catalog
                                    FROM
                                        items_group_alias
                                    WHERE
                                        group_id = public.items_group.group_id
                                        AND
                                        lang_id = :lang_id
                                    LIMIT 1
                                )
                                AND
                                lang_id = :lang_id
                            LIMIT 1
                        ) AS catalog_alias,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS catalog,
                    (
                        SELECT
                            subtype
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS subtype_id,
                                        (
                        SELECT
                            alias
                        FROM
                            public.types_i18n
                        WHERE
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS type_alias,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                            )
                            AND
                            group_id = public.items_group.group_id
                            LIMIT 1
                    ) as id,
                                        (
                        SELECT
                            type
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                        LIMIT 1
                    ) as type
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN ('.join( ',', $groups_ids ).')
                LIMIT
                    5
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getTotalTopItems()
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_top"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getTotalNewItems()
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_new"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getTotalNewItemsByUsersGroup($users_group_name)
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    ' . $users_group_name . ' @> \'"is_new"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getTotalRecommendedItems()
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_recommended"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getTotalRecommendedItemsByUsersGroup($users_group_name)
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                LEFT JOIN users_groups2items_group
                ON items_group.group_id = users_groups2items_group.item_group_id
                LEFT JOIN users_groups
                ON users_groups2items_group.users_groups_id = users_groups.id
                WHERE
                    users_groups2items_group.options @> \'"is_recommended"=>"1"\'::hstore
                    AND
                    users_groups.name = :users_group_name
            ',
            [
                'users_group_name' => $users_group_name
            ],
            -1
        );
    }

    public function getStockTopItems()
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                    options @> \'"is_stock"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getTotalStockItems()
    {
        return $this->get(
            '
                SELECT
                    COUNT(group_id) as total
                FROM
                    public.items_group
                WHERE
                     options @> \'"is_stock"=>"1"\'::hstore
            ',
            [

            ],
            -1
        );
    }

    public function getGroupsByFilters(  $filter_applied, $price_array, $type, $subtype )
    {
        if( !empty( $filter_applied ) && empty( $price_array ) )
        {
            $sql = 'filter_id IN ('.join(',',$filter_applied).')';
        }
        elseif( empty( $filter_applied ) && !empty( $price_array ) )
        {
            $sql =
                'item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 >= '.$price_array['0'].'
                        AND
                        price2 <= '.$price_array['1'].'
                )';
        }
        else
        {
            $sql =
                'filter_id IN ('.join(',',$filter_applied).')
                AND
                item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 >= '.$price_array['0'].'
                        AND
                        price2 <= '.$price_array['1'].'
                )';
        }

        return $this->get(
            '
                SELECT
                    group_id,
                    (
                        SELECT
                            filter_key_id
                        FROM
                            public.filters
                        WHERE
                            id = public.filters_items.filter_id
                        LIMIT
                            1
                    ) as key_id
                FROM
                    public.filters_items
                WHERE
                    '.$sql.'
                    AND
                    type = :type
                    AND
                    subtype = :subtype
                ORDER BY
                    group_id DESC'
            ,
            [
                'type'      => $type,
                'subtype'   => $subtype,
            ],
            -1
        );
    }

    public function getGroupsByFiltersWithCatalog(  $filter_applied, $price_array, $catalog )
    {
        if( !empty( $filter_applied ) && empty( $price_array ) )
        {

            $sql = 'filter_id IN ('.join(',',$filter_applied).')';
        }
        elseif( empty( $filter_applied ) && !empty( $price_array ) )
        {
            $sql =
                'item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 >= '.$price_array['0'].'
                        AND
                        price2 <= '.$price_array['1'].'
                )';
        }
        else
        {
            $sql =
                'filter_id IN ('.join(',',$filter_applied).')
                AND
                item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 >= '.$price_array['0'].'
                        AND
                        price2 <= '.$price_array['1'].'
                )';
        }

        $r = $this->get(
            '
                SELECT
                    group_id,
                    (
                        SELECT
                            filter_key_id
                        FROM
                            public.filters
                        WHERE
                            id = public.filters_items.filter_id
                        LIMIT
                            1
                    ) as key_id,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            public.items.id = public.filters_items.item_id
                    ) AS count_price					
                FROM
                    public.filters_items
                WHERE
                    '.$sql.'
                    AND
                    catalog = :catalog
                ORDER BY
                    group_id DESC'
            ,
            [
                'catalog'   => $catalog,
            ],
            -1
        );
        return $r;
    }

    public function getResultGroups( $lang_id, $result_groups, $filter_applied, $price_array, $sort, $page )
    {
        if( !empty( $filter_applied ) && empty( $price_array ) )
        {
            $sql =
                'id IN
                (
                    SELECT
                        item_id
                    FROM
                        filters_items
                    WHERE
                        filter_id in (' . join(',', $filter_applied) . ')
                )';
        }
        elseif( empty( $filter_applied ) && !empty( $price_array ) )
        {
            $sql =
                'price2 >= ' . $price_array['0'].'
                AND
                price2 <= ' . $price_array['1'];
        }
        else
        {
            $sql =
                'id IN
                (
                    SELECT
                        item_id
                    FROM
                        filters_items
                    WHERE
                        filter_id in (' . join(',', $filter_applied) . ')
                )
                AND
                price2 >= '.$price_array['0'].'
                AND
                price2 <= '.$price_array['1'];
        }

        $order = '';

        if( in_array( 1, $sort ) )
        {
            $order = 'new ASC';
        }
        if( in_array( 2, $sort ) )
        {
            $order = 'top ASC';
        }
        if( in_array( 3, $sort ) )
        {
            $order .= ',min_price ASC';
        }
        if( in_array( 4, $sort ) )
        {
            $order .= ',min_price DESC';
        }
        if( in_array( 3, $sort ) && in_array( 0, $sort ) )
        {
            $order = 'min_price ASC';
        }
        if( in_array( 4, $sort ) && in_array( 0, $sort ) )
        {
            $order = 'min_price DESC';
        }
        return $this->get(
            '
                SELECT
                    group_id,
                    cover,
                    options,
                    options->\'is_new\' AS new,
                    options->\'is_top\' AS top,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            subtype
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS subtype_id,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    '.$sql.'
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                            AND '.$sql.'
                        LIMIT 1
                    ) as id,
                    (
                    SELECT
                        price2
                    FROM
                        public.items
                    WHERE
                        group_id = public.items_group.group_id
                        AND
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_group.group_id
                            LIMIT 1
                        )
                        LIMIT 1
                ) AS min_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                    ) AS count_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS catalog
                FROM
                    public.items_group
                WHERE
                    status = 1
                    AND
                    group_id IN ('.join( ',', $result_groups ).')

                ORDER BY
                    '.$order.'
                LIMIT
                    '.\config::get( 'limits/items' ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/items' ))
            ,
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getResultGroupsWithLimit( $lang_id, $result_groups, $filter_applied, $price_array, $limit = 10000 )
    {
        if( !empty( $filter_applied ) && empty( $price_array ) )
        {
            $sql =
                'id IN
                (
                    SELECT
                        item_id
                    FROM
                        filters_items
                    WHERE
                        filter_id in (' . join(',', $filter_applied) . ')
                )';
        }
        elseif( empty( $filter_applied ) && !empty( $price_array ) )
        {
            $sql =
                'price2 >= ' . $price_array['0'] . '
                AND
                price2 <= ' . $price_array['1'];
        }
        else
        {
            $sql =
                'id IN
                (
                    SELECT
                        item_id
                    FROM
                        filters_items
                    WHERE
                        filter_id in (' . join(',', $filter_applied) . ')
                )
                AND
                price2 >= ' . $price_array['0'] . '
                AND
                price2 <= ' . $price_array['1'];
        }

        return $this->get(
            '
                SELECT
                    public.items_group.group_id,
                    public.items_group.cover,
                    public.items_group.options,
                    public.items_group.options->\'is_new\' AS new,
                    public.items_group.options->\'is_top\' AS top,
                    it.id as item_id,
                    it.price2 as price2,
                    it.size as size,
                    (
                        SELECT
                            alias
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                    ) AS alias,
                    (
                        SELECT
                            type
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS type_id,
                    (
                        SELECT
                            subtype
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS subtype_id,
                    (
                        SELECT
                            id
                        FROM
                            public.items
                        WHERE
                            price2 IN
                            (
                                SELECT
                                    MIN(price2)
                                FROM
                                    public.items
                                WHERE
                                    group_id = public.items_group.group_id
                                    AND
                                    '.$sql.'
                                LIMIT 1
                            )
                            AND
                            group_id = public.items_group.group_id
                            AND '.$sql.'
                        LIMIT 1
                    ) as id,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                    ) AS count_price,
                    (
                        SELECT
                            count(*)
                        FROM
                            public.items
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            status = 1
                    ) AS count_available,
                    (
                        SELECT
                            catalog
                        FROM
                            items_group_alias
                        WHERE
                            group_id = public.items_group.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT
                            1
                    ) AS catalog,
                    (
                            SELECT
                                full_alias
                            FROM
                                catalog_i18n
                            WHERE
                                catalog =
                                (
                                    SELECT
                                        catalog
                                    FROM
                                        items_group_alias
                                    WHERE
                                        group_id = public.items_group.group_id
                                        AND
                                        lang_id = :lang_id
                                    LIMIT 1
                                )
                                AND
                                lang_id = :lang_id
                            LIMIT 1
                        ) AS catalog_alias
                FROM
                    public.items_group
				INNER JOIN public.items as it ON
					(items_group.group_id = it.group_id)
                WHERE
                    public.items_group.status = 1
					AND
					it.status != 2
                    AND
                    public.items_group.group_id IN ('.join( ',', $result_groups ).')
                    AND it.'.$sql.'
                LIMIT
                    '.$limit
            ,
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getTitleByAlias( $lang_id, $alias) {
        return $this->get(
            '
                SELECT title, full_alias FROM catalog_i18n
                WHERE alias::text ILIKE \'%'.$alias.'%\' and lang_id = :lang_id
            ',
            [
                'lang_id'   => $lang_id
            ],
            -1
        );
    }

    public function getItemsByIds( $lang_id, $item_ids )
    {
        return $this->get(
            '
                SELECT
                    public.items.id,
                    public.items.status,
                    public.items.catalog,
                    public.items.price2,
                    public.items.price3,
                    public.items.price4,
                    public.items.price5,
                    public.items.price6,
                    public.items.size,
                    public.items.type,
                    public.items.subtype,
                    public.items.group_id,
                    public.items.stock_availability,
                    public.items.firm,
                    (
                        SELECT
                            cover
                        FROM
                            public.items_group
                        WHERE
                            group_id = public.items.group_id
                        LIMIT 1
                    ) AS group_cover,
                    (
                        SELECT
                            options
                        FROM
                            public.items_group
                        WHERE
                            group_id = public.items.group_id
                        LIMIT 1
                    ) AS options,
                    (
                        SELECT
                            alias
                        FROM
                            public.items_group_alias
                        WHERE
                            group_id = public.items.group_id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS group_alias,
                    (
                        SELECT
                            title
                        FROM
                            public.items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS title,
                    (
                        SELECT
                            description
                        FROM
                            public.items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS description,
                    (
                        SELECT
                            content_description
                        FROM
                            public.items_i18n
                        WHERE
                            item_id = public.items.id
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS content_description,
                    (
                        SELECT
                            alias
                        FROM
                            public.types_i18n
                        WHERE
                            type = public.items.type
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
                            type = public.items.type
                            AND
                            subtype = public.items.subtype
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) AS subtype_alias,
                    public.items.status as count_available,
					public.catalog_i18n.title as catalog_title,
					public.catalog_i18n.full_alias as catalog_alias,
					public.items.cover as item_cover
                FROM
                    public.items
				LEFT JOIN public.catalog_i18n ON public.catalog_i18n.catalog = public.items.catalog	
                WHERE
                    id IN ('.join( ',', $item_ids ).')
                     AND public.catalog_i18n.lang_id = :lang_id
            ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getItemsByTerm( $term, $search_for, $page = 1,$lang_id )
    {

        $data = $this->get(
            '
                SELECT
                    item_id
                FROM
                    public.items_i18n
				LEFT JOIN public.items i ON i.group_id = public.items_i18n.group_id	
                WHERE
                    (
                    title::text ILIKE \'%'.$term.'%\'
                    OR
                    content_description::text ILIKE \'%'.$term.'%\'
					OR
					i.product_id::text ILIKE \'%'.$term.'%\'
                )
                AND
                item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_i18n.group_id
                            LIMIT 1
                        )
                )
                AND
                lang_id = :lang_id
                LIMIT
                    '.\config::get( 'limits/'.$search_for ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/'.$search_for ))

            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );



        return $data;
    }

    public function getItemsByTermFromCatalog( $term, $search_for, $page = 1,$lang_id )
    {

        $data = $this->get(
            '
             SELECT
                    i.id AS item_id
                FROM
                    public.catalog_i18n
				LEFT JOIN public.items i ON i.catalog = public.catalog_i18n.catalog
                WHERE
                (
                    title::text ILIKE \'%'.$term.'%\'
                )
                AND
                id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = (
                                SELECT
                                    group_id
                                FROM
                                    public.items
                                WHERE
                                    id = i.id
                                )
                            LIMIT 1
                        )
                )
                AND
                lang_id = :lang_id
                LIMIT
                    '.\config::get( 'limits/'.$search_for ).'
                OFFSET
                    '.($page-1)*(\config::get( 'limits/'.$search_for ))

            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );



        return $data;
    }

    public function getTotalItemsByTerm( $term,$lang_id )
    {
        return $this->get(
            '
                SELECT
                    COUNT(item_id) as total
                FROM
                    public.items_i18n
				LEFT JOIN public.items i ON i.group_id = public.items_i18n.group_id
                WHERE
                    (
                    title::text ILIKE \'%'.$term.'%\'
                    OR
                    content_description::text ILIKE \'%'.$term.'%\'
					OR
					i.product_id::text ILIKE \'%'.$term.'%\'
                )
                AND
                item_id IN
                (
                    SELECT
                        id
                    FROM
                        public.items
                    WHERE
                        price2 IN
                        (
                            SELECT
                                MIN(price2)
                            FROM
                                public.items
                            WHERE
                                group_id = public.items_i18n.group_id
                            LIMIT 1
                        )
                )
                AND
                lang_id = :lang_id
                ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getTypeSubtypeByTerm( $term, $lang_id )
    {
        return $this->get(
            '
                SELECT
                    type,
                    (
                        SELECT
                            title
                        FROM
                            public.types_i18n
                        WHERE
                            type = public.items.type
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) as type_title,
                    (
                        SELECT
                            alias
                        FROM
                            public.types_i18n
                        WHERE
                            type = public.items.type
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) as type_alias,
                    subtype,
                    (
                        SELECT
                            title
                        FROM
                            public.subtypes_i18n
                        WHERE
                            type = public.items.type
                            AND
                            subtype = public.items.subtype
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) as subtype_title,
                    (
                        SELECT
                            alias
                        FROM
                            public.subtypes_i18n
                        WHERE
                            type = public.items.type
                            AND
                            subtype = public.items.subtype
                            AND
                            lang_id = :lang_id
                        LIMIT 1
                    ) as subtype_alias
                FROM
                    public.items
                WHERE
                    id IN
                    (
                        SELECT
                            item_id
                        FROM
                            public.items_i18n
                        WHERE
                            lang_id = :lang_id
                            AND
                            (
                                item_id::text ILIKE \'%'.$term.'%\'
                                OR
                                product_id::text ILIKE \'%'.$term.'%\'
                                OR
                                title::text ILIKE \'%'.$term.'%\'
                                OR
                                content_description::text ILIKE \'%'.$term.'%\'
                            )
                    )
                ',
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getItemsUrl($alias, $lang_id)
    {
        return $this->get(
            '
                SELECT
                    alias
                FROM
                    public.items_group_alias
                WHERE
                    group_id = (
                      SELECT
                        group_id
                      FROM
                        public.items_group_alias
                      WHERE
                        alias = :alias
                    )
                    AND
                      lang_id = :lang_id
                    LIMIT
                            1

                ',
            [
                'lang_id' => $lang_id,
                'alias' => $alias
            ],
            -1
        );

    }

    public function getProductLike($like)
    {
        return $this->get(
            '
            SELECT DISTINCT
            group_id, meta_title
            FROM items_i18n
             WHERE group_id IN (
                SELECT DISTINCT group_id
                FROM items
                WHERE product_id = :like
            ) AND lang_id= :lang_id

            ',
            [
                'lang_id' => '1',
                'like' => $like
            ],
            -1
        );
    }

    public function getGroupLike($like)
    {
        return $this->get(
            "
            SELECT DISTINCT
            group_id, meta_title
            FROM items_i18n
             WHERE group_id IN ('$like') AND lang_id= :lang_id

            ",
            [
                'lang_id' => '1'
            ],
            -1
        );
    }

    public function getItemsList($lang){
        return $this->get(
            "
                SELECT DISTINCT i_18n.item_id as id, concat(i_18n.item_id, 'S') as IDS,
                        RPAD(c_i18n.title, 12, '') as Item_title,
                        concat('http://semena.in.ua',c_i18n.full_alias, '/', i_g_a.alias, '-', i_18n.item_id, '/ru') as Destination_URL,
                        i_g.cover as Image_URL,
                        RPAD(i_18n.meta_title, 12, '') as Item_subtitle,
                        'Отборные семена' as Item_description,
                        'Категория' Item_category,
                        i.price1 as price,
                        concat(c_i18n.title, ' ', i_18n.meta_title) Contextual_keywords,
                        '' Item_address
                FROM items_group i_g
                LEFT JOIN items_i18n i_18n ON   i_g.group_id = i_18n.group_id
                LEFT JOIN items_group_alias i_g_a ON  i_g.group_id = i_g_a.group_id
                LEFT JOIN catalog_i18n c_i18n ON  c_i18n.catalog = i_g_a.catalog
                LEFT JOIN items i ON  i.id = i_18n.item_id
                WHERE i_18n.lang_id =  :lang_id AND c_i18n.lang_id =  :lang_id AND i_g_a.lang_id = :lang_id
                ORDER BY i_18n.item_id
            ",
            [
                'lang_id' => $lang
            ],
            -1
        );
    }

}

