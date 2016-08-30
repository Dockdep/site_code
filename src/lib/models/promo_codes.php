<?php

namespace models;


class promo_codes extends \db
{
    ///////////////////////////////////for_backend///////////////////////////////////////////
    public function getAllData()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.promo_codes
            '
            ,
            [
            ],
            -1
        );
    }


    public function getOneData($id)
    {
        return $this->get(
            '
                SELECT *
                FROM public.promo_codes
                WHERE
                    id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

    public function getOneDataByCode($code)
    {
        return $this->get(
            "
                SELECT *
                FROM public.promo_codes
                WHERE
                    code = :code
                    AND
                    NOW()
                    BETWEEN start_date AND end_date + interval '1' day
            ",
            [
                'code' => $code
            ],
            -1
        );
    }

    public function getPromoByCode($code) {
        return $this->get(
            '
                SELECT *
                FROM public.promo_codes
                WHERE
                    code = :code',
            [
                'code' => $code
            ],
            -1
        );
    }

    public function deleteData($id)
    {
        return $this->exec(
            '   DELETE
                FROM
                    public.promo_codes
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

        return $this->get(
            '
                INSERT INTO
                    public.promo_codes
                        (
                          code,
                          name,
                          discount,
                          description,
                          group_ids,
                          catalog_ids,
                          all_items,
                          image,
                          start_date,
                          end_date
                        )
                        VALUES
                        (
                          :code,
                          :name,
                          :discount,
                          :description,
                          :group_ids,
                          :catalog_ids,
                          :all_items,
                          :image,
                          :start_date,
                          :end_date
                        )
                        RETURNING id
            ',
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'discount' => $data['discount'],
                'description' => $data['description'],
                'group_ids' => !empty($data['group_ids']) ? '{'. implode(', ', $data['group_ids']) . '}' : null,
                'catalog_ids' => !empty($data['catalog_ids']) ? '{'. implode(', ', $data['catalog_ids']) . '}' : null,
                'all_items' => $data['all_items'],
                'image' => $data['image'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ],
            -1
        );


    }

    public function updateData($data, $id)
    {

        return $this->exec(
            '
                UPDATE
                    public.promo_codes
                SET
                    code = :code,
                    name = :name,
                    discount = :discount,
                    description = :description,
                    group_ids = :group_ids,
                    all_items = :all_items,
                    image = :image,
                    start_date = :start_date,
                    end_date = :end_date
                WHERE
                    id  = :id
            ',
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'discount' => $data['discount'],
                'description' => $data['description'],
                'group_ids' => !empty($data['group_ids']) ? '{'. implode(', ', $data['group_ids']) . '}' : null,
                'all_items' => $data['all_items'],
                'image' => $data['image'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'id' => $id
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
                    public.promo_codes
            ',
            [

            ],
            -1
        );
    }
}