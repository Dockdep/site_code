<?php
namespace models;

class campaign extends \db
{

    public function getAllData()
    {

        return $this->get(
            '
                SELECT * FROM
                    public.campaign
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
                    public.campaign
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
                    public.campaign
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
                    public.campaign
                WHERE
                    id  = :id
            ',
            [
                'id'     => $id
            ]
        );
    }

    public function addData($data, $date)
    {

        return $this->get(
            '
                INSERT INTO
                    public.campaign
                        (
                            name,
                            date
                        )
                        VALUES
                        (
                            :name,
                            :date
                        )
                        RETURNING id
            ',
            [
                'name' => $data,
                'date' => $date
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.campaign
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

    public function getCampaignLike($like){
        return $this->get(
            '
                SELECT DISTINCT name FROM
                    public.campaign
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }



}