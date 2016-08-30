<?php
namespace models;
class email_settings extends \db
{
    public function getSettings( $id )
    {
        $data =  $this->get(
            '
                SELECT
                  *
                FROM
                    public.email_settings
                WHERE
                    user_id = :id
                LIMIT
                    1
            ',
            [
                'id' => $id
            ],
            -1
        );

        return $data;
    }

    public function getCustomerByConfirmKey($key){
        $data =  $this->get(
            '
                SELECT
                  *
                FROM
                    public.email_settings
                WHERE
                    confirm_key = :confirm_key
                LIMIT
                    1
            ',
            [
                'confirm_key' => $key
            ],
            -1
        );

        return $data;
    }


    public function addData($data)
    {

        return $this->get(
            '
                INSERT INTO
                    public.email_settings
                        (
                            delivery_status,
                            section_one,
                            section_two,
                            section_three,
                            section_four,
                            section_five,
                            section_six,
                            events,
                            novelty,
                            materials,
                            user_id,
                            frequency,
                            confirm_key

                        )
                        VALUES
                        (
                            :delivery_status,
                            :section_one,
                            :section_two,
                            :section_three,
                            :section_four,
                            :section_five,
                            :section_six,
                            :events,
                            :novelty,
                            :materials,
                            :user_id,
                            :frequency,
                            :confirm_key
                        )
                        RETURNING id
            ',
            [
                'delivery_status' =>$data['delivery_status'],
                'section_one'     =>$data['section_one'],
                'section_two'     =>$data['section_two'],
                'section_three'   =>$data['section_three'],
                'section_four'    =>$data['section_four'],
                'section_five'    =>$data['section_five'],
                'section_six'     =>$data['section_six'],
                'events'          =>$data['events'],
                'novelty'         =>$data['novelty'],
                'materials'       =>$data['materials'],
                'user_id'         =>$data['user_id'],
                'frequency'       =>$data['frequency'],
                'confirm_key'     =>$data['confirm_key']

            ],
            -1
        );



    }

    public function updateData($data)
    {

        return $this->exec(
            '
                UPDATE
                    public.email_settings
                SET
                            delivery_status= :delivery_status,
                            section_one    = :section_one,
                            section_two    = :section_two,
                            section_three  = :section_three,
                            section_four   = :section_four,
                            section_five   = :section_five,
                            section_six    = :section_six,
                            events         = :events,
                            novelty        = :novelty,
                            materials      = :materials,
                            user_id        = :user_id,
                            frequency      = :frequency,
                            confirm_key    = :confirm_key,
                            cancel_reason  = :cancel_reason

                WHERE
                    user_id              = :user_id
            ',
            [
                'delivery_status' =>$data['delivery_status'],
                'section_one'     =>$data['section_one'],
                'section_two'     =>$data['section_two'],
                'section_three'   =>$data['section_three'],
                'section_four'    =>$data['section_four'],
                'section_five'    =>$data['section_five'],
                'section_six'     =>$data['section_six'],
                'events'          =>$data['events'],
                'novelty'         =>$data['novelty'],
                'materials'       =>$data['materials'],
                'frequency'       =>$data['frequency'],
                "user_id"         =>$data['user_id'],
                'confirm_key'     =>$data['confirm_key'],
                "cancel_reason"   =>$data['cancel_reason']
            ]
        );
    }
}