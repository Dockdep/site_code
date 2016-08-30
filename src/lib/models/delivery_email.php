<?php
namespace models;

class delivery_email extends \db
{

    public function getAllData()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.delivery_email
                ORDER BY
                     id ASC'
            ,
            [
            ],
            -1
        );
    }


    public function checkName($name, $id)
    {
        return $this->get(
            '
                SELECT
                    name
                FROM
                    public.delivery_email
                WHERE
                    name = :name
                AND
                    id != :id
                LIMIT
                    1
            ',
            [
                'name' => $name,
                'id'  => $id
            ],
            -1
        );
    }






    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.delivery_email
                WHERE
                    id = :id
            ',
            [
                'id'     => $id
            ],
            -1
        );
    }

    public function deleteData($id){
        return $this->exec(
            '   DELETE
                FROM
                    public.delivery_email
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
                    public.delivery_email
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
                'name' => $data,
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.delivery_email
                SET
                            name = :name
                WHERE
                    id              = :id
            ',
            [
                'name' => $data['name'],
                "id"          => $id
            ]
        );
    }

    public function getDelivery_emailLike($like){
        return $this->get(
            '
                SELECT * FROM
                    public.delivery_email
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }



}