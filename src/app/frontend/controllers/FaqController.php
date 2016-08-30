<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
use \Phalcon\Mvc\View;

class FaqController extends \controllers\ControllerBase
{
    ///////////////////////////////////////////////////////////////////////////

    public function IndexAction(  )
    {
        $lang_url = $this->seoUrl->getChangeLangUrl();
        $this->view->setVars([
            'change_lang_url'   => $lang_url,
        ]);
    }

}
 