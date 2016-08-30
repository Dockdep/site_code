<?php
namespace
{

    class languages extends \core
    {
        public function getTranslation()
        {
            p("hello",1);
            $lang_val = $this->getDi()->get('session')->get('language');

            $lang     = explode( '/', $this->getDi()->get('request')->get('_url'));

            if(!empty($lang)){
                if(array_pop($lang) == 'ru'){
                    $lang_val = 'ru';
                } else {
                    $lang_val = 'ua';
                }


            }

            $messages = require( ROOT_PATH.config::get( 'dirs/messagesDir' ).$lang_val.'.php' );

            // Возвращение объекта работы с переводом
            return new \Phalcon\Translate\Adapter\NativeArray(array(
                "content" => $messages
            ));

        }

    }
}