<?php
namespace models;

class headings extends \db
{


    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.headings
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
                    public.headings
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
                    public.headings
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
                    public.headings
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
                    public.headings
                WHERE
                    section_id  = :id
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
                    public.headings
                        (
                            name,
                            post_type
                        )
                        VALUES
                        (
                            :name,
                            :post_type
                        )
                        RETURNING id
            ',
            [
                'name' => $data['name'],
                'post_type' => $data['post_type']
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.headings
                SET
                            name = :name
                WHERE
                    id              = :id
            ',
            [
                'name'      => $data['name'],
                'post_type' => $data['post_type'],
                "id"        => $id
            ]
        );
    }

    public function getAdminEmailLike($like){
        return $this->get(
            '
                SELECT * FROM
                    public.headings
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }



}