<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace models;

class manager_mail extends \db
{

    public function addData($data) {
        return $this->get(
            '
            INSERT INTO
              public.manager_mail
              (
                "text"
              )
              VALUES
              (
                :text
              )
              RETURNING manager_mail_id
            ',
            [
                'text' => $data['text']
            ],
            -1
        );
    }
    public function getData()
    {

        return $this->get(
            '
                SELECT
                *
                FROM
                    public.manager_mail
                where manager_mail_id =1
            ',
            [],
            -1

        );
    }


    public function UpdateData($data)
    {
        return $this->exec(
            '
                UPDATE
                    public.manager_mail
                SET
                    text = :text
                where manager_mail_id = 1
            ',
            [
                "text" => $data['text'],
            ]
        );
    }



}