<?php

namespace
{

    class UTMParser
    {
        public $url;
        public $utm_source;
        public $utm_medium;
        public $utm_term;
        public $utm_content;
        public $utm_campaign;


        public function replaceData($target, $replacement, $str)
        {
            $text = str_replace($target, $replacement, $str);
            return $text;
        }

        public function getUtm($data, $i)
        {  $utm = '';

            if(!empty($data['utm_source'])){
                $utm = "utm_source=".$data['utm_source'];
            }

            if(!empty($data['utm_medium'])) {
                $utm .= "&utm_medium=".$data['utm_medium'];
            }

            if(!empty($i)) {
                $utm .= "&utm_term=".$i;
            }

            if(!empty($data['utm_content'])) {
                $utm .= "&utm_content=".$data['utm_content'];
            }

            if(!empty($data['utm_campaign'])) {
                $utm .= "&utm_campaign=".$data['utm_campaign'];
            }
            return $utm;
        }

        public function parse($data, $template)
        {

            preg_match_all( "/href[\s]*=[\s]*[\"\'](?!.*(?:\.ico|\.css|\?utm))(.[^\"\']*)[\"\']/i", $template['text'], $match,PREG_SET_ORDER );
            $i = 1;
            foreach($match as $row ) {
                $target = $row[0];
                $utm = $this->getUtm($data, $i++);
                $replacement = "href = '$row[1]?$utm'";
                $template['text'] = $this->replaceData($target, $replacement, $template['text']);
            }

            return $template['text'];
        }


    }
}