<?php

namespace models;


class special_users extends \db
{
    ///////////////////////////////////for_backend///////////////////////////////////////////
    public function getAllData($lang_id = 2, $first_status = 1)
    {

        return $this->get(
            '
                SELECT su.*, special_users_i18n.title FROM
                    public.special_users su
                INNER JOIN public.special_users_i18n
                ON su.id = special_users_i18n.special_users_id
                WHERE lang_id = :lang_id AND status >= :first_status
                ORDER BY
                     status ASC
            '
            ,
            [
                'lang_id' => $lang_id,
                'first_status' => $first_status
            ],
            -1
        );
    }



    public function getOneData($id)
    {
        return $this->get(
            '
                SELECT *
                FROM public.special_users
                WHERE
                    id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function getOneDataByLang($id, $lang_id)
    {

        return $this->get(
            '
                SELECT su.*, special_users_i18n.title FROM
                    public.special_users su
                INNER JOIN public.special_users_i18n
                ON su.id = special_users_i18n.special_users_id
                WHERE
                    id = :id AND lang_id = :lang_id
            ',
            [
                'id'     => $id,
                'lang_id'=> $lang_id
            ],
            -1
        );
    }

    public function getOneDataByName($name)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.special_users
                WHERE
                    name = :name
            ',
            [
                'name'     => $name
            ],
            -1
        );
    }

    public function getOneDataByStatus($status, $lang_id)
    {

        return $this->get(
            '
                SELECT su.*, special_users_i18n.title FROM
                    public.special_users su
                INNER JOIN public.special_users_i18n
                ON su.id = special_users_i18n.special_users_id
                WHERE
                    status = :status AND lang_id = :lang_id
            ',
            [
                'status'     => $status,
                'lang_id'    => $lang_id
            ],
            -1
        );
    }

    public function deleteData($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.special_users
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addData($data)
    {

        return $this->get(
            '
                INSERT INTO
                    public.special_users
                        (
                            name

                        )
                        VALUES
                        (
                            :name
                        )
                        RETURNING id
            ',
            [
                'name'             => $data['name']
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.special_users
                SET
                            discount = :discount,
                            year_budget = :year_budget,
                            first_order = :first_order
                WHERE
                    id              = :id
            ',
            [
                'discount'         => $data['discount'],
                'year_budget'      => $data['year_budget'],
                'first_order'      => $data['first_order'],
                "id" => $id
            ]
        );
    }


    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.special_users
            ',
            [

            ],
            -1
        );
    }

    public function getPriceNum($id)
    {
        return $this->get(
            '
            SELECT
              price_num
            FROM
              special_users
            WHERE
              id = :id
            ',
            [
                'id' => $id
            ],
            -1
        );
    }

}