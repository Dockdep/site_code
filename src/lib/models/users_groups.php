<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class users_groups extends \db
{
    ///////////////////////////////////for_backend///////////////////////////////////////////
    public function getAllData($page='1')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.users_groups
                ORDER BY
                     id ASC
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
                SELECT * FROM
                    public.users_groups
                WHERE
                    id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function getOneDataByName($name)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.users_groups
                WHERE
                    name = :name
            ',
            [
                'name'     => $name
            ],
            -1
        );
    }

    public function getAllDataWithGoods($lang_id)
    {

        return $this->get(
            '
                SELECT users_groups_i18n.users_groups_id, users_groups_i18n.goods_description FROM
                    public.users_groups
                INNER JOIN users_groups_i18n
                ON
                    users_groups.id = users_groups_i18n.users_groups_id
                WHERE
                    lang_id = :lang_id
            ',
            [
                'lang_id'  => $lang_id
            ],
            -1
        );
    }

    public function deleteData($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.users_groups
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
                    public.users_groups
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
                    public.users_groups
                SET
                            name = :name
                WHERE
                    id              = :id
            ',
            [
                'name'             => $data['name'],
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
                    public.users_groups
            ',
            [

            ],
            -1
        );
    }

    ////////////////////////////////////end_for_backend//////////////////////////////////////////
}