<?php
namespace{
    class plugins{
        static function getShortText($text){
            $pos = 16;
            $text = strip_tags($text);
            if(mb_strlen($text, 'UTF-8') > $pos)
            {
                $text = mb_substr($text, 0, $pos, 'UTF-8');
                return $text.'...';
            }
            else
                return $text;
        }
    }
}
