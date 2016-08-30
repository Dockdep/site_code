<?php
namespace
{

    class sms
    {
        public function sendSMS($tel,$text){

            $text = iconv('windows-1251', 'utf-8', htmlspecialchars($text));
            $description = iconv('windows-1251', 'utf-8', htmlspecialchars('Отправка номера заказа клиенту'));



            /*
                $content = implode("",file("http://yandex.ru"));
                $content = str_replace(">","",$content);
                $content = str_replace("<","",$content);
                $content = str_replace("/","",$content);
                $content = str_replace("'","",$content);
                $content = str_replace('"',"",$content);
                $content = str_replace(":","",$content);
                list($a,$b)=spliti("b-region__time",$content,2);
                list($times,$b)=spliti("!",$b,2);
                $times = preg_replace("/[^0-9]+/","",$times);

                $times1 = substr($times,2,2);
                $times2 = substr($times,0,2);
                $times = strtotime(date("d-m-Y")." ".$times2.":".$times1.":00");
            */

            $times = time();



        //$start_time = date("Y-m-d H:i:s",$times+360);
        //$end_time = date("Y-m-d H:i:s", $times+360); // плюс 3 часа

            $start_time = 'AUTO';
            $end_time = 'AUTO';

        //echo $start_time."(".date("Y-m-d H:i:s").")"."=>".$end_time;
            $rate = 120;
            $livetime = 4;
            $source = 'semena'; // Alfaname
            $recipient = $tel;
            $user = '380674064008';
            $password = 'smsartweb2012';

            $myXML 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            $myXML 	.= "<request>";
            $myXML 	.= "<operation>SENDSMS</operation>";
            $myXML 	.= '		<message start_time="'.$start_time.'" end_time="'.$end_time.'" livetime="'.$livetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'">'."\n";
            $myXML 	.= "		<body>".$text."</body>";
            $myXML 	.= "		<recipient>".$recipient."</recipient>";
            $myXML 	.=  "</message>";
            $myXML 	.= "</request>";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERPWD , $user.':'.$password);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, 'http://sms-fly.com/api/api.php');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
            $response = curl_exec($ch);
            curl_close($ch);
        /*echo $response;
        exit;*/

        }
    }
}