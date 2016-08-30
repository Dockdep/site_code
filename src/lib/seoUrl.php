<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace
{

    class seoUrl extends \core
    {
        private  $link;
        public   $result;

        function getMainUrl()
        {
            return $this->getDi()->get('request')->get('_url');
        }


        function getLink($array = false)
        {
            $link = $_SERVER['REQUEST_URI'];
            if($array) {
                return explode("/", $link);
            }
            return $link;
        }

        function getSeoData($model)
        {

            $link = $this->getLink();
			$l_arr = explode('/sort',$link);
			//print_r($l_arr);exit;
			$link = $l_arr[0];
            foreach($model as $item) {
                if($item['url'] == $link) {
                    $this->result = $item;
                }
            }
            return $this->result;

        }

        function setUrl($url)
        {
            $lang_val = $this->getDi()->get('session')->get('language');

            $lang = explode( '/', $this->getMainUrl());

            if(!empty($lang)){
                if(array_pop($lang) == 'ru'){
                    $lang_val = 'ru';
                } else {
                    $lang_val = '';
                }


            }

            $lang = !empty($lang_val) ? $lang_val : '';
            if($lang_val){
                $lang = '/'.$lang;
            }

            if(isset($url{2})  && $url{2}=='/' && $url{0}=='/' ){
                $url = substr($url,2);
            }else if(isset($url{1})  && $url{1}=='/' && $url{0}=='/' ){
                $url = substr($url,1);
            }

            if($url{0} == '/'){
                if($url == '/' && $lang == '/ru'){
                    return $lang;
                }
                return $url.$lang;

            } else {
                return '/'.$url.$lang;
            }




        }

        function getLangId()
        {
            $lang = explode( '/', $this->getMainUrl());
            if(!empty($lang)){
                $lang_name = array_pop($lang);
                if($lang_name == 'ru'){
                    $lang_id = '2';
                } else {
                    $lang_id = '1';
                }
                return $lang_id;
            }
        }

        function getLangName()
        {
            $lang = explode( '/', $this->getMainUrl());
            if(!empty($lang)){
                $lang_name = array_pop($lang);
                if($lang_name == 'ru'){
                    $lang_name = '/ru';
                } else {
                    $lang_name = '';
                }
                return $lang_name;
            }
        }

        function getChangeLangUrl($array = array())
        {

            $lang_id = $this->getLangId();



            if($lang_id == 2){
                $change_lang = 1;
            } else {
                $change_lang = 2;
            }
            $url[$lang_id] = $this->getMainUrl();
            $url[$change_lang] = $this->getMainUrl();

            $except = $this->checkException($url[$lang_id]);

            if($except){
                $count = 4;
            } else {
                $count = count($array);
            }


            switch($count){
                case 1:
                    $type = '/'.$array[0];
                    $new_url = $this->getDi()->get('models')->getCatalog()->getCatalogUrl($type, $change_lang);
                    if($new_url){
                        $url[$change_lang] = str_replace($type, $new_url[0]['full_alias'], $this->getMainUrl());
                    } else {
                        $url[$change_lang] = '';
                    }

                    break;
                case 2:
                    $subtype = '/'.implode( '/', $array);
                    $new_url = $this->getDi()->get('models')->getCatalog()->getCatalogUrl($subtype, $change_lang);
                    if($new_url){
                        $url[$change_lang] = str_replace($subtype, $new_url[0]['full_alias'], $this->getMainUrl());
                    } else {
                        $url[$change_lang] = '';
                    }

                    break;
                case 3:
                    $item = array_pop($array);
                    $subtype = '/'.implode( '/', $array);
                    $new_url = $this->getDi()->get('models')->getCatalog()->getCatalogUrl($subtype, $change_lang);
                    $new_item = $this->getDi()->get('models')->getItems()->getItemsUrl($item, $change_lang);
                    if($new_url && $new_item){
                        $url[$change_lang] = str_replace($subtype.'/'.$item, $new_url[0]['full_alias'].'/'.$new_item[0]['alias'], $this->getMainUrl());
                    } else {
                        $url[$change_lang] = '';
                    }

                    break;
                case 4:
                    //exception
                    break;

            }

            if($change_lang == 2) {
                $url[$change_lang] = $url[$change_lang].'/ru';
            } else {
                $url[$change_lang] = $this->getUaUrl($url[$change_lang]); //убрать из строки /ru
            }


            return $url;
        }


        function checkException($url) {

            $url = explode( '/', $url);
            $exception = $this->getException();
            foreach($exception as $exept){
                if($url[0] == $exept ) {
                    return true;
                }
            }
        }

        function getException(){
            return [
                'basket',
                'o-kompanii-1',
                'dostavka-i-oplata-2',
                'news-actions',
                'news-actions',
                'contacts',
                'partneri-dileri-3'
            ];
        }

        function getUaUrl($string){
            $items = explode( '/', $string);
            $num = count($items);
            for($i = 0; $i<$num; $i++){
                if($items[$i] == 'ru'){
                    unset($items[$i]);
                }
            }
            $items = implode('/', $items);
            return $items;
        }



    }
}

