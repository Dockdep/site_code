<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace
{

    class seo_url extends \core
    {
        private  $link;

        function getLink()
        {
            $link = $_SERVER['REQUEST_URI'];
            $link = explode("/", $link);
            $this->link = array_pop($link);
            return $this->link;
        }

        function getSeoData()
        {
            $link = $this->getLink();
            $data = $this->models->getSeoInfo()->getByUrl($link);
            return $data;
        }

    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
