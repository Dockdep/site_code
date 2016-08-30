<?php
namespace models;

class delivery extends \db
{


    function getWHERE($array)
    {
        $where = '';
        if(!empty($array)) {
            $i = 0;
            while (list ($key, $val) = each($array)){
                if($i == 0){
                    $where = !empty($key) && !empty($val) ? "WHERE ".$key." = '".$val."'" : '';
                } else {
                    $where .= !empty($key) && !empty($val) ? " AND ".$key." = '".$val."'" : '';
                }
                $i++;
            }


        }
        return $where;
    }

    public function getAllData($page,$order = '',$method = '', $array = array())
    {
        $where = $this->getWHERE($array);
        $orderBy = !empty($order) && !empty($method) ? "ORDER BY".$order." ".$method : '';

        return $this->get(
            "
                SELECT * FROM
                    public.delivery
                ".
                $where." ".$orderBy
                ."
                LIMIT
                    ".\config::get( "limits/admin_orders" )."
                OFFSET
                    ".($page-1)*(\config::get( "limits/admin_orders" ))
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
                    public.delivery
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



    public function CheckDelivery($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.delivery
                WHERE
                    campaign_id = :campaign_id
                LIMIT
                    1
            ',
            [
                'campaign_id'     => $id
            ],
            -1
        );
    }


    public function getOneData($id)
    {

        return $this->get(
            '
                SELECT * FROM
                    public.delivery
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
                    public.delivery
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
                    public.delivery
                        (
                            name,
                            campaign_id,
                            date,
                            status,
                            total,
                            ok_delivered,
                            ok_read,
                            campaign,
                            event_id,
                            ok_unsubscribed,
                            ok_fbl,
                            ok_link_visited,
                            delivered
                        )
                        VALUES
                        (
                            :name,
                            :campaign_id,
                            :date,
                            :status,
                            :total,
                            :ok_delivered,
                            :ok_read,
                            :campaign,
                            :event_id,
                            :ok_unsubscribed,
                            :ok_fbl,
                            :ok_link_visited,
                            :delivered
                        )
                        RETURNING id
            ',
            [
                'name' => $data['name'],
                'campaign_id' => $data['campaign_id'],
                'date' => $data['date'],
                'status' => $data['status'],
                'total' => $data['total'],
                'ok_delivered' => $data['ok_delivered'],
                'ok_read' => $data['ok_read'],
                'campaign' => $data['campaign'],
                'event_id' => $data['event_id'],
                'ok_unsubscribed' => $data['ok_unsubscribed'],
                'ok_fbl'          => $data['ok_fbl'],
                'ok_link_visited' => $data['ok_link_visited'],
                'delivered' => $data['delivered']


            ],
            -1
        );



    }

    public function UpdateData($data)
    {

        return $this->exec(
            '
                UPDATE
                    public.delivery
                SET
                            name            = :name,
                            date            = :date,
                            status          = :status,
                            total           = :total,
                            ok_delivered    = :ok_delivered,
                            ok_read         = :ok_read,
                            campaign        = :campaign,
                            event_id        = :event_id,
                            ok_unsubscribed = :ok_unsubscribed,
                            ok_fbl          = :ok_fbl,
                            ok_link_visited = :ok_link_visited,
                            delivered       = :delivered
                WHERE
                   campaign_id = :campaign_id
            ',
            [
                'name' => $data['name'],
                'campaign_id' => $data['campaign_id'],
                'date' => $data['date'],
                'status' => $data['status'],
                'total' => $data['total'],
                'ok_delivered' => $data['ok_delivered'],
                'ok_read' => $data['ok_read'],
                'campaign' => $data['campaign'],
                'event_id' => $data['event_id'],
                'ok_unsubscribed' => $data['ok_unsubscribed'],
                'ok_fbl'          => $data['ok_fbl'],
                'ok_link_visited' => $data['ok_link_visited'],
                'delivered' => $data['delivered']
            ]
        );
    }

    public function getDeliveryLike($like){
        return $this->get(
            '
                SELECT * FROM
                    public.delivery
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }

    public function getCampaignLike($like){
        return $this->get(
            '
                SELECT DISTINCT campaign FROM
                    public.delivery
                WHERE
                    name LIKE \'%'.$like.'%\''
            ,
            [
            ],
            -1
        );
    }
    public function countData( $array)
    {
        $where = $this->getWHERE($array);

        return $this->get(
            "
                SELECT
                    COUNT(id) AS total
                FROM
                    public.delivery
                ".$where

            ,
            [

            ],
            -1
        );
    }



}