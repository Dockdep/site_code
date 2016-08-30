<?php

namespace
{

    class MyMailer extends \core
    {
        public $from_name;
        public $from_email;
        public $to_email    = '';
        public $title       = '';
        public $mailMessage = '';
        public $to_name     = '';
        public $mailer;
        public $deliveryService;


        function __construct(){
            $this->from_name = !empty($name) ? $name : \config::get('global#name');
            $this->from_email = 'andrey.belyy@gmail.com';
            $this->mailer = new \unisender('5xaiqb1pnuu8jsun4rwxhow4shj11e55zdhjf5do','3877503');

        }

        public function getDelivService()
        {
            $delivery_db = $this->getDi()->get('models')->getDelivery();
            $delivery_email_db = $this->getDi()->get('models')->getDeliveryEmail();
            if($this->deliveryService instanceof \deliveryServ) {
                return $this->deliveryService;
            } else {
                return $this->deliveryService = new \deliveryServ($delivery_db,$delivery_email_db);
            }
        }

        function setFromName($name)
        {
            return $this->from_name = $name;
        }

        function setFromEmail($email)
        {
            return $this->from_email = $email;
        }

        function setToMail($email = array(), $string = false)
        {
           if($string) {
               $sendTo = array();

              foreach($email as $user){
                $sendTo[] = $user['email'];
              }

              $email =implode(",", $sendTo);

              return $this->to_email = $email;
          } else {

             return $this->to_email = $email;
          }


        }

        function setTitle($title)
        {
            return $this->title = $title;
        }

        function setMailMessage($mailMessage)
        {
            return $this->mailMessage = $mailMessage;
        }

        function setToName($to_name)
        {
            return $this->to_name = $to_name;
        }

        function getUsers($id='')
        {
            $model = $this->getDi()->get('models')->getCustomers();
            if(!empty($id)){
                $id = implode(",", $id);
                $model = $model->getActiveUsersData($id);
            } else {
                $model = $model->getAllUsers();
            }

            return $model;
        }


        public function SendForSelect($template, $data)
        {
            $model = $this->getDi()->get('models')->getCustomers();
            $users = $this->getUsers($data, $model);
            foreach($users as $user){
                $this->setToMail($user['email']);
                $this->setMailMessage($template['text']);
                $this->setTitle($template['title']);
                $this->SenByUni();
            }
        }





        public function SenByUni()
        {
            $this->mailer->SendMail($this->to_email, '', $this->from_email, $this->from_name, $this->title, $this->mailMessage);
        }

        public function SendDelivery($template, $data)
        {

            $users = $this->getUsers($data['users_id']);
            $this->setToMail($users, true);
            $this->setMailMessage($template['text']);
            $this->setTitle($template['title']);

            $campaign_id = $this->mailer->createCampaignDelivery($this->to_email,  $this->from_email, $this->from_name, $this->title, $this->mailMessage);

            $this->getDelivService()->addProp(array(
                'campaign_id' => $campaign_id,
                'campaign'    => $data['utm_campaign'],
                'name'        => $data['name'],
                'event_id'    => $data['id'],
                'date'        => date( 'd.m.Y H:i:s' ),
                'status'      => '0'
            ));
            $this->getDelivService()->save($campaign_id);
        }



        public function getDeliveryStatus($campaign_id)
        {
            $status = $this->mailer->getCampaignStatus($campaign_id);
            p($status);
            $this->getDelivService()->addProp(array(
                'status'      => $status
            ));
        }


        public function getCampaignDeliveryStats($campaign_id)
        {
            $status = $this->mailer->getCampaignDeliveryStats($campaign_id);
            p($status);
        }
        public  function  getCampaignAggregateStats($campaign_id)
        {
            $result = $this->mailer->getCampaignAggregateStats($campaign_id);
p($result);
            $this->getDelivService()->addProp(array(
                'total'           => $result->result->total,
                'ok_unsubscribed' => !empty($result->result->data->ok_unsubscribed) ? $result->result->data->ok_unsubscribed : null,
                'ok_delivered'    => !empty($result->result->data->ok_delivered) ? $result->result->data->ok_delivered : null,
                'ok_read'         => !empty($result->result->data->ok_read) ? $result->result->data->ok_read : null,
                'ok_fbl'          => !empty($result->result->data->ok_fbl) ? $result->result->data->ok_fbl : null,
                'ok_link_visited' => !empty($result->result->data->ok_link_visited) ? $result->result->data->ok_link_visited : null


            ));
            $this->getDelivService()->addProp(array(
                'delivered'       => $this->getDelivService()->getDelivered()
            ));

        }

        public function getVisitedLinks($campaign_id)
        {
            $status = $this->mailer->getVisitedLinks($campaign_id);

        }


        public function updateDeliveryData($campaign_id)
        {
            return $this->getDelivService()->save($campaign_id);
        }


        public function SendDeliveryForAll($template, $data){

            $this->setMailMessage($template['text']);
            $this->setTitle($template['title']);
            $campaign_id = $this->mailer->createCampaignDelivery(null, $this->from_email, $this->from_name, $this->title, $this->mailMessage);
            $this->getDelivService()->addProp(array(
                'campaign_id' => $campaign_id,
                'status'      => '0',
                'name'        => $data['name'],
                'campaign'    => $data['utm_campaign'],
                'event_id'    => $data['id'],
                'date'        => date( 'd.m.Y H:i:s' )

            ));
            $this->getDelivService()->save($campaign_id);
        }
    }
}