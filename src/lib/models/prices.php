<?php

namespace models;


class prices extends \db
{
    public function getAllData($lang_id)
    {

        return $this->get(
            '
                SELECT p.name as name, p.update_date as update_date, p.file as file,
                    special_users.css_class as css, special_users_i18n.title as special_user FROM
                    public.prices p
                INNER JOIN special_users ON
                    p.special_users_id = special_users.id
                INNER JOIN special_users_i18n ON
                    p.special_users_id = special_users_i18n.special_users_id
                WHERE lang_id = :lang_id
                ORDER BY
                     update_date DESC
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
                SELECT * FROM
                    public.prices
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
                    public.prices
                WHERE
                    name = :name
            ',
            [
                'name'     => $name
            ],
            -1
        );
    }

    public function deleteData($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.prices
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
                    public.prices
                        (
                            name,
                            file,
                            special_users_id
                        )
                        VALUES
                        (
                            :name,
                            :file,
                            :special_users_id

                        )
                        RETURNING id
            ',
            [
                'name'             => $data['name'],
                'file'             => $data['file'],
                'special_users_id' => $data['special_users_id']
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.prices
                SET
                            name = :name,
                            file = :file,
                            special_users_id = :special_users_id,
                            update_date = :update_date
                WHERE
                    id              = :id
            ',
            [
                'name'             => $data['name'],
                'file'             => $data['file'],
                'special_users_id' => $data['special_users_id'],
                'update_date'      => $data['update_date'],
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
                    public.prices
            ',
            [

            ],
            -1
        );
    }
}