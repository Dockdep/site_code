<?php
namespace models;

class admin_email_sections extends \db
{


    public function countData( )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.admin_email_sections
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
                    public.admin_email_sections
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
                    public.admin_email_sections
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
                SELECT aes.id as main_id,*
                FROM
                    public.admin_email_sections as aes
                LEFT JOIN public.admin_email AS ae ON aes.id=ae.section_id
                WHERE
                   aes.id = :id
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
                    public.admin_email_sections
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
                    public.admin_email_sections
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
                    public.admin_email_sections
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
                    public.admin_email_sections
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }



}