<?php
namespace models;

class event_email extends \db
{

    public function getAllData($page='')
    {

        return $this->get(
            '
                SELECT * FROM
                    public.event_email
                ORDER BY
                     id ASC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                    OFFSET
                        '.($page-1)*(\config::get( 'limits/admin_orders' ))
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
                    public.event_email
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

    public function addTemplateId($template_id, $id)
    {
        return $this->exec(
            '
                UPDATE
                    public.event_email
                SET
                            template_id = :template_id

                WHERE
                    id              = :id
            ',
            [
                'template_id' => $template_id,
                "id"          => $id
            ]
        );
    }


    public function getAllEmailData($page='', $email_type)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.event_email
                WHERE
                    email_type = :email_type
                ORDER BY
                     id ASC
                LIMIT
                    '.\config::get( 'limits/admin_orders' ).'
                    OFFSET
                        '.($page-1)*(\config::get( 'limits/admin_orders' ))
            ,
            [
                'email_type' => $email_type
            ],
            -1
        );
    }




    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.event_email
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
                    public.event_email
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
                    public.event_email
                        (
                            name,
                            utm_status,
                            utm_campaign,
                            utm_medium,
                            utm_source,
                            status,
                            email_type
                        )
                        VALUES
                        (
                            :name,
                            :utm_status,
                            :utm_campaign,
                            :utm_medium,
                            :utm_source,
                            :status,
                            :email_type
                        )
                        RETURNING id
            ',
            [
                'name' => $data['name'],
                'utm_status' => $data['utm_status'],
                'utm_campaign' => $data['utm_campaign'],
                'utm_medium' => $data['utm_medium'],
                'utm_source' => $data['utm_source'],
                'status' => $data['status'],
                'email_type'   => $data['type']
            ],
            -1
        );



    }

    public function UpdateData($data,$id)
    {

        return $this->exec(
            '
                UPDATE
                    public.event_email
                SET
                            name = :name,
                            utm_status = :utm_status,
                            utm_campaign = :utm_campaign,
                            utm_medium = :utm_medium,
                            utm_source = :utm_source,
                            status = :status,
                            email_type = :email_type,
                            template_id = :template_id
                WHERE
                    id              = :id
            ',
            [
                'name' => $data['name'],
                'utm_status' => $data['utm_status'],
                'utm_campaign' => $data['utm_campaign'],
                'utm_medium' => $data['utm_medium'],
                'utm_source' => $data['utm_source'],
                'status' => $data['status'],
                'email_type' => $data['type'],
                'template_id' => $data['template_id'],
                "id"          => $id
            ]
        );
    }


    public function countData( $email_type )
    {
        return $this->get(
            '
                SELECT
                    COUNT(id) AS total
                FROM
                    public.event_email
                WHERE
                  email_type = :email_type
            ',
            [
                'email_type' => $email_type
            ],
            -1
        );
    }
}