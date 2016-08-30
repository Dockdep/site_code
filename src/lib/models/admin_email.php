<?php
namespace models;

class admin_email extends \db
{


    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.admin_email
            ',
            [

            ],
            -1
        );
    }

    public function getAllData()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.admin_email
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
                    public.admin_email
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
                    public.admin_email
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
                    public.admin_email
                WHERE
                    section_id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addData($data, $id)
    {

        return $this->get(
            '
                INSERT INTO
                    public.admin_email
                        (
                            email,
                            section_id
                        )
                        VALUES
                        (
                            :email,
                            :section_id
                        )
                        RETURNING id
            ',
            [
                'email' => $data,
                'section_id' => $id
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.admin_email
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

    public function getAdminEmailLike($like){
        return $this->get(
            '
                SELECT * FROM
                    public.admin_email
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }



}