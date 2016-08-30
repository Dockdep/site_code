<?php
namespace models;

class email_templates extends \db
{

    public function getAllData($page='1', $event_id = '0')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.email_templates
                WHERE
                    event_id = :event_id

                ORDER BY
                     id ASC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                    OFFSET
                        '.($page-1)*(\config::get( 'limits/admin_orders' ))
            ,
            [
                'event_id' => $event_id
            ],
            -1
        );
    }




    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.email_templates
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
                    public.email_templates
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
                    public.email_templates
                        (
                            name,
                            title,
                            text,
                            directory,
                            event_id

                        )
                        VALUES
                        (
                            :name,
                            :title,
                            :text,
                            :directory,
                            :event_id
                        )
                        RETURNING id
            ',
            [
                'name'           => $data['name'],
                'title'           => $data['title'],
                'text'            => $data['text'],
                'directory'        => $data['directory'],
                'event_id'       => $data['event_id']
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.email_templates
                SET
                            name = :name,
                            title = :title,
                            text = :text,
                            directory = :directory
                WHERE
                    id              = :id
            ',
            [
                'name'           => $data['name'],
                'title'           => $data['title'],
                'text'            => $data['text'],
                'directory'       => $data['directory'],
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
                    public.email_templates
            ',
            [

            ],
            -1
        );
    }
}