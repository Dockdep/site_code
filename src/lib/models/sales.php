<?php

namespace models;


class sales extends \db
{
    public function getAllData($lang_id)
    {
        return $this->get(
            '
                SELECT * FROM
                    public.sales
                  INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                    WHERE
                      lang_id = :lang_id
            '
            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getOneData($id)
    {
        return $this->get(
            '
                SELECT *
                FROM public.sales
                INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                WHERE
                    id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

    public function getOneDataByLang($id, $lang_id)
    {
        return $this->get(
            "
                SELECT *,
                CASE      WHEN NOW()
                          BETWEEN
                          start_date and end_date + INTERVAL '1' day
                          OR
                          (
                            is_seasonal = TRUE
                            AND
                            (
                              EXTRACT (DOY FROM NOW())
                              BETWEEN
                              EXTRACT (DOY FROM start_date)
                              AND
                              EXTRACT (DOY FROM end_date)
                              OR
                              (
                                EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                                AND
                                (
                                EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                                OR
                                EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)
                                )
                              )
                            )
                          )
                            THEN 1
                          ELSE 0
                end AS active
                FROM public.sales
                INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                WHERE
                    id = :id
                    AND
                    lang_id = :lang_id
            ",
            [
                'id' => $id,
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function deleteData($id)
    {
        return $this->exec(
            '   DELETE
                FROM
                    public.sales
                WHERE
                    id  = :id
            ',
            [
                'id' => $id
            ]
        );
    }

    public function addData($data)
    {

        $id = $this->get(
            '
                INSERT INTO
                    public.sales
                        (
                          group_ids,
                          is_seasonal,
                          start_date,
                          end_date,
                          show_banner,
                          show_counter
                        )
                        VALUES
                        (
                          :group_ids,
                          :is_seasonal,
                          :start_date,
                          :end_date,
                          :show_banner,
                          :show_counter
                        )
                        RETURNING id
            ',
            [
                'group_ids' => !empty($data['group_ids']) ? '{'. implode(', ', $data['group_ids']) . '}' : null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_seasonal' => $data['is_seasonal'],
                'show_banner' => $data['show_banner'],
                'show_counter' => $data['show_counter']
            ],
            -1
        );

        return $this->exec(
            '
                INSERT INTO
                    public.sales_i18n
                        (
                          lang_id,
                          sales_id,
                          name,
                          description,
                          alias,
                          full_name,
                          classic_cover,
                          seasonal_cover,
                          banner
                        )
                        VALUES
                        (
                          1,
                          :sales_id,
                          :name_1,
                          :description_1,
                          :alias_1,
                          :full_name_1,
                          :classic_cover_1,
                          :seasonal_cover_1,
                          :banner_1
                        ),
                        (
                          2,
                          :sales_id,
                          :name_2,
                          :description_2,
                          :alias_2,
                          :full_name_2,
                          :classic_cover_2,
                          :seasonal_cover_2,
                          :banner_2
                        );
            ',
            [
                'sales_id' => $id[0]['id'],
                'name_1' => $data['name_1'],
                'description_1' => $data['description_1'],
                'name_2' => $data['name_2'],
                'description_2' => $data['description_2'],
                'alias_1' => $data['alias_1'],
                'full_name_1' => $data['full_name_1'],
                'alias_2' => $data['alias_2'],
                'full_name_2' => $data['full_name_2'],
                'classic_cover_1' => !empty($data['classic_cover_1']) ? $data['classic_cover_1'] : null,
                'seasonal_cover_1' => !empty($data['seasonal_cover_1']) ? $data['seasonal_cover_1'] : null,
                'banner_1' => !empty($data['banner_1']) ? $data['banner_1'] : null,
                'classic_cover_2' => !empty($data['classic_cover_2']) ? $data['classic_cover_2'] : null,
                'seasonal_cover_2' =>!empty($data['seasonal_cover_2']) ? $data['seasonal_cover_2'] : null,
                'banner_2' => !empty($data['banner_2']) ? $data['banner_2'] : null
            ],
            -1
        );
    }

    public function updateData($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.sales
                SET
                    group_ids = :group_ids,
                    is_seasonal = :is_seasonal,
                    start_date = :start_date,
                    end_date = :end_date,
                    show_banner = :show_banner,
                    show_counter = :show_counter
                WHERE
                    id  = :id
            ',
            [
                'group_ids' => !empty($data['group_ids']) ? '{'. implode(', ', $data['group_ids']) . '}' : null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'is_seasonal' => $data['is_seasonal'],
                'show_banner' => $data['show_banner'],
                'show_counter' => $data['show_counter'],
                'id' => $id
            ]
        );
    }

    public function updateLang($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.sales_i18n as s
                SET
                    name = d.name,
                    description = d.description,
                    alias = d.alias,
                    full_name = d.full_name,
                    classic_cover = d.classic_cover,
                    seasonal_cover = d.seasonal_cover,
                    banner = d.banner
                FROM (
                  VALUES
                    (1, :sales_id::INTEGER, :name_1, :description_1, :alias_1, :full_name_1, :classic_cover_1, :seasonal_cover_1, :banner_1),
                    (2, :sales_id::INTEGER, :name_2, :description_2, :alias_2, :full_name_2, :classic_cover_2, :seasonal_cover_2, :banner_2)
                ) as d(lang_id, sales_id, name, description, alias, full_name, classic_cover, seasonal_cover, banner)
                WHERE
                    s.sales_id = d.sales_id
                    AND
                    s.lang_id = d.lang_id
            ',
            [
                'sales_id' => $id,
                'name_1' => $data['name_1'],
                'description_1' => $data['description_1'],
                'name_2' => $data['name_2'],
                'description_2' => $data['description_2'],
                'alias_1' => $data['alias_1'],
                'full_name_1' => $data['full_name_1'],
                'alias_2' => $data['alias_2'],
                'full_name_2' => $data['full_name_2'],
                'classic_cover_1' => !empty($data['classic_cover_1']) ? $data['classic_cover_1'] : null,
                'seasonal_cover_1' => !empty($data['seasonal_cover_1']) ? $data['seasonal_cover_1'] : null,
                'banner_1' => !empty($data['banner_1']) ? $data['banner_1'] : null,
                'classic_cover_2' => !empty($data['classic_cover_2']) ? $data['classic_cover_2'] : null,
                'seasonal_cover_2' =>!empty($data['seasonal_cover_2']) ? $data['seasonal_cover_2'] : null,
                'banner_2' => !empty($data['banner_2']) ? $data['banner_2'] : null
            ]
        );
    }


    public function countData()
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.sales
            ',
            [

            ],
            -1
        );
    }

    public function getActiveSales($lang_id)
    {
        return $this->get(
            "
                SELECT *,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month,

                CASE WHEN   EXTRACT (DOY FROM NOW())
                            BETWEEN
                            EXTRACT (DOY FROM start_date)
                            AND
                            EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                            OR
                            EXTRACT (DOY FROM NOW()) < EXTRACT (DOY FROM end_date)
                            THEN EXTRACT (DOY FROM end_date + INTERVAL '1' day) - EXTRACT (DOY FROM NOW())
                     WHEN   EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                            AND
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            /*OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)*/
                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM NOW()) + EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                end as diff,
                TRUE as active
                  FROM
                    public.sales
                  INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                  WHERE
                      lang_id = :lang_id
                  AND
                    (
                      NOW()
                      BETWEEN
                      start_date and end_date + INTERVAL '1' day
                      OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                          EXTRACT (DOY FROM NOW())
                          BETWEEN
                          EXTRACT (DOY FROM start_date)
                          AND
                          EXTRACT (DOY FROM end_date)
                          OR
                          (
                            EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                            AND
                            (
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            OR
                            EXTRACT (DOY FROM NOW()) < EXTRACT (DOY FROM end_date)
                            )
                          )
                        )
                      )
                    )
                  ORDER BY diff
                  ASC
            "
            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );
    }

    public function getActiveSalesExceptCurrent($lang_id, $sale_id)
    {
        return $this->get(
            "
                SELECT *,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month,

                CASE WHEN   EXTRACT (DOY FROM NOW())
                            BETWEEN
                            EXTRACT (DOY FROM start_date)
                            AND
                            EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                            OR
                            EXTRACT (DOY FROM NOW()) < EXTRACT (DOY FROM end_date)

                            THEN EXTRACT (DOY FROM end_date + INTERVAL '1' day) - EXTRACT (DOY FROM NOW())
                     WHEN   (
                            EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                            AND
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            )
                            /*OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)*/
                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM NOW()) + EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                end as diff,
                TRUE as active
                  FROM
                    public.sales
                  INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                  WHERE
                      public.sales.id <> :current_sale_id
                  AND
                      lang_id = :lang_id
                  AND
                    (
                      NOW()
                      BETWEEN
                      start_date and end_date + INTERVAL '1' day
                      OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                          EXTRACT (DOY FROM NOW())
                          BETWEEN
                          EXTRACT (DOY FROM start_date)
                          AND
                          EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                          OR
                          EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                          AND
                          (
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)
                          )
                        )
                      )
                    )
                  ORDER BY diff
                  ASC
            "
            ,
            [
                'lang_id' => $lang_id,
                'current_sale_id' => $sale_id
            ],
            -1
        );
    }

    public function getFutureSales($lang_id)
    {
        return $this->get(
            "
                SELECT *,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month,

                CASE WHEN   EXTRACT (DOY FROM NOW())
                            BETWEEN
                            EXTRACT (DOY FROM start_date)
                            AND
                            EXTRACT (DOY FROM NOW() + INTERVAL '1' day + INTERVAL '2' month)
                            /*OR
                            EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                              >= EXTRACT (DOY FROM start_date)*/

                            THEN EXTRACT (DOY FROM start_date) - EXTRACT (DOY FROM NOW())
                     WHEN   EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)

                            AND

                            EXTRACT (DOY FROM start_date) <= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)

                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM now()) + EXTRACT (DOY FROM start_date)
                     ELSE   EXTRACT (DOY FROM start_date) - EXTRACT (DOY FROM NOW())
                end as diff,
                FALSE as active
                  FROM
                    public.sales
                  INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                  WHERE
                    lang_id = :lang_id
                    AND
                    (
                      (
                      (start_date, end_date)
                      OVERLAPS
                      (NOW(), NOW() + INTERVAL '1' day + INTERVAL '2' month )
                      AND
                      start_date > NOW()
                      )
                      OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                          EXTRACT (DOY FROM start_date)
                          BETWEEN
                          EXTRACT (DOY FROM NOW() + INTERVAL '1' day)
                          AND
                          EXTRACT (DOY FROM NOW() + INTERVAL '2' month)

                            OR
                            (
                                EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)
                                AND
                                (
                                  EXTRACT (DOY FROM start_date) > EXTRACT (DOY FROM NOW())
                                  OR
                                  EXTRACT (DOY FROM start_date) <= EXTRACT (DOY FROM NOW() +  INTERVAL '2' month)
                                )
                            )
                        )

                      )
                    )
                  ORDER BY diff
                  ASC
            "
            ,
            [
                'lang_id' => $lang_id
            ],

            -1
        );
    }

    public function getFutureSalesExceptCurrent($lang_id, $sale_id)
    {
        return $this->get(
            "
                SELECT *,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month,

                CASE WHEN   EXTRACT (DOY FROM NOW())
                            BETWEEN
                            EXTRACT (DOY FROM start_date)
                            AND
                            EXTRACT (DOY FROM NOW() + INTERVAL '1' day + INTERVAL '2' month)
                            /*OR
                            EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                              >= EXTRACT (DOY FROM start_date)*/

                            THEN EXTRACT (DOY FROM start_date) - EXTRACT (DOY FROM NOW())
                     WHEN   EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)

                            AND

                            EXTRACT (DOY FROM start_date) <= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)

                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM now()) + EXTRACT (DOY FROM start_date)
                     ELSE   EXTRACT (DOY FROM start_date) - EXTRACT (DOY FROM NOW())
                end as diff,
                FALSE as active
                  FROM
                    public.sales
                  INNER JOIN public.sales_i18n on
                  public.sales.id = public.sales_i18n.sales_id
                  WHERE
                    public.sales.id <> :current_sale_id
                    AND
                    lang_id = :lang_id
                    AND
                    (
                      (start_date + INTERVAL '1' day, end_date)
                      OVERLAPS
                      (NOW(), NOW() + INTERVAL '1' day + INTERVAL '2' month )
                      AND start_date > NOW()

                     OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                            EXTRACT (DOY FROM start_date)
                            BETWEEN
                            EXTRACT (DOY FROM NOW() + INTERVAL '1' day)
                            AND
                            EXTRACT (DOY FROM NOW() + INTERVAL '1' day + INTERVAL '2' month)

                            OR
                            (
                                EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM NOW() + INTERVAL '2' month)
                                AND
                                (
                                  EXTRACT (DOY FROM start_date) > EXTRACT (DOY FROM NOW())
                                  OR
                                  EXTRACT (DOY FROM start_date) <= EXTRACT (DOY FROM NOW() +  INTERVAL '2' month)
                                )
                            )
                        )

                      )
                    )
                  ORDER BY diff
                  ASC
            "
            ,
            [
                'lang_id' => $lang_id,
                'current_sale_id' => $sale_id
            ],

            -1
        );
    }


    public function getActiveSeasonalSales($lang_id)
    {
        return $this->get(
            "
                SELECT *,
                CASE WHEN   EXTRACT (DOY FROM NOW())
                            BETWEEN
                            EXTRACT (DOY FROM start_date)
                            AND
                            EXTRACT (DOY FROM end_date + INTERVAL '1' day)
                            THEN EXTRACT (DOY FROM end_date + INTERVAL '1' day) - EXTRACT (DOY FROM NOW())
                     WHEN   EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                            AND
                            (EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date))
                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM NOW()) + EXTRACT (DOY FROM end_date  + INTERVAL '1' day)
                end as diff,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month
                FROM
                   public.sales
                INNER JOIN public.sales_i18n on
                public.sales.id = public.sales_i18n.sales_id
                WHERE
                    lang_id = :lang_id
                AND
                    is_seasonal = TRUE
                AND
                    (
                      NOW()
                      BETWEEN
                      start_date and end_date + INTERVAL '1' day
                      OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                          EXTRACT (DOY FROM NOW())
                          BETWEEN
                          EXTRACT (DOY FROM start_date)
                          AND
                          EXTRACT (DOY FROM end_date)
                          OR
                          EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                          AND
                          (
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)
                          )
                        )
                      )
                    )
                ORDER BY diff
                asc
            "
            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );

    }

    public function getFutureSeasonalSales($lang_id)
    {
        return $this->get(
            "
                SELECT *,
                CASE WHEN   EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM NOW())

                            THEN EXTRACT (DOY FROM start_date) - EXTRACT (DOY FROM NOW())
                     WHEN   EXTRACT (DOY FROM start_date) < EXTRACT (DOY FROM NOW())

                            THEN EXTRACT (DOY FROM (date_trunc('year', now()) - INTERVAL '1' day)::date)
                                 - EXTRACT (DOY FROM now()) + EXTRACT (DOY FROM start_date)
                end as diff,
                DATE_PART('day', end_date) as end_day,
                DATE_PART('day', start_date) as start_day,
                DATE_PART('month', end_date) as end_month,
                DATE_PART('month', start_date) as start_month
                FROM
                   public.sales
                INNER JOIN public.sales_i18n on
                public.sales.id = public.sales_i18n.sales_id
                WHERE
                    lang_id = :lang_id
                AND
                    is_seasonal = TRUE
                AND NOT
                    (
                      NOW()
                      BETWEEN
                      start_date and end_date + INTERVAL '1' day
                      OR
                      (
                        is_seasonal = TRUE
                        AND
                        (
                          EXTRACT (DOY FROM NOW())
                          BETWEEN
                          EXTRACT (DOY FROM start_date)
                          AND
                          EXTRACT (DOY FROM end_date)
                          OR
                          EXTRACT (DOY FROM start_date) >= EXTRACT (DOY FROM end_date)
                          AND
                          (
                            EXTRACT (DOY FROM NOW()) >= EXTRACT (DOY FROM start_date)
                            OR
                            EXTRACT (DOY FROM NOW()) <= EXTRACT (DOY FROM end_date)
                          )
                        )
                      )
                    )
                ORDER BY diff
                asc
            "
            ,
            [
                'lang_id' => $lang_id
            ],
            -1
        );

    }

    public function alterTable() {
        return $this->exec(
            "ALTER TABLE public.sales
             DROP COLUMN seasonal_cover,
             DROP COLUMN classic_cover,
             DROP COLUMN banner");
    }
}