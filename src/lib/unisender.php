<?php

namespace
{

    class unisender
    {
        public $api_key;
        public $list_id;



        function __construct($key, $list_id){
            $this->api_key = $key;
            $this->list_id = $list_id;
        }


        function getConnection($POST, $link)
        {
            // Устанавливаем соединение
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_URL, $link);
            return  curl_exec($ch);

        }


        public function getCampaignStatus($campaign_id)
        {
            // Создаём POST-запрос
            $POST = array (
                'api_key' => $this->api_key,
                'campaign_id' => $campaign_id
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/getCampaignStatus?format=json');
            
            if ($result) {
                // Раскодируем ответ API-сервера
                $jsonObj = json_decode($result);

                return $jsonObj->result->status;
            }

        }

        function SendMail($to, $nameto, $from, $namefrom, $title, $mailMessage, $files='') {


            // Создаём POST-запрос
            $POST = array (
                'api_key' => $this->api_key,
                'email' => $to,
                'sender_name' => $namefrom,
                'sender_email' => $from,
                'subject' => $title,
                'body' => $mailMessage,
                'list_id' => $this->list_id
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/sendEmail?format=json');

            if ($result) {
                // Раскодируем ответ API-сервера
                $jsonObj = json_decode($result);

                if(null===$jsonObj) {
                    // Ошибка в полученном ответе
                    echo "Invalid JSON";

                }
                elseif(!empty($jsonObj->error)) {
                    // Ошибка отправки сообщения
                    echo "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

                } else {
                    // Сообщение успешно отправлено
                    echo "Email message is sent. Message id " . $jsonObj->result->email_id;

                }
            } else {
                // Ошибка соединения с API-сервером
                echo "API access error";
            }
        }

        function CreateMessage($from, $namefrom, $title, $mailMessage)
        {


            $POST = array (
                'api_key' => $this->api_key,
                'sender_name' => $namefrom,
                'sender_email' => $from,
                'subject' => $title,
                'body' => $mailMessage,
                'list_id' => $this->list_id
            );


            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/createEmailMessage?format=json');

            if ($result) {
                // Раскодируем ответ API-сервера
                $jsonObj = json_decode($result);

                    return $jsonObj->result->message_id;

            }

        }

        public function createCampaignDelivery($to = null, $from, $namefrom, $title, $mailMessage)
        {

            $email_stats_links = "1";
            $email_stats_read = "1";
            $defer = '1';

            // Создаём POST-запрос
            $POST = array (
                'api_key' => $this->api_key,
                'message_id' => $this->CreateMessage($from, $namefrom, $title, $mailMessage),
                'track_read' => $email_stats_read,
                'track_links' => $email_stats_links,
                'contacts'   => $to,
                'defer'      => $defer
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/createCampaign?format=json');

            $jsonObj = json_decode($result);

            return $jsonObj->result->campaign_id;

        }

        public function getCampaignDeliveryStats($id)
        {

            $POST = array (
                'api_key' => $this->api_key,
                'campaign_id' => $id,
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/getCampaignDeliveryStats?format=json');

            return json_decode($result);



        }


        public function getCampaignAggregateStats($id)
        {
            $POST = array (
                'api_key' => $this->api_key,
                'campaign_id' => $id,
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/getCampaignAggregateStats?format=json');


             return json_decode($result);

        }

        public function getVisitedLinks($id)
        {
            $POST = array (
                'api_key' => $this->api_key,
                'campaign_id' => $id,
            );

            $result = $this->getConnection($POST, 'http://api.unisender.com/ru/api/getVisitedLinks?format=json');


            return json_decode($result);


        }

        public function getCampaigns()
        {

            $api_key = '5xaiqb1pnuu8jsun4rwxhow4shj11e55zdhjf5do';

// Создаём GET-запрос
            $api_url = "http://api.unisender.com/ru/api/getCampaigns?format=json&api_key=$api_key";

// Делаем запрос на API-сервер
            $result = file_get_contents($api_url);

            if ($result) {
                // Раскодируем ответ API-сервера
                $jsonObj = json_decode($result);

                if(null===$jsonObj) {
                    // Ошибка в полученном ответе
                    echo "Invalid JSON";

                }
                elseif(!empty($jsonObj->error)) {
                    // Ошибка получения списка рассылок
                    echo "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

                } else {
                    // Выводим коды и статусы всех имеющихся рассылок
                    echo "Here's a list of your campaigns:<br>";
                    foreach ($jsonObj->result as $one) {
                        echo "Campaign #" . $one->id . " (" . $one->status . ")". "<br>";
                    }
                }

            } else {
                // Ошибка соединения с API-сервером
                echo "API access error";
            }
        }






    }
}