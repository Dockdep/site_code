<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ExcelWorkerController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

    }

    function getdataAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $post['fields'] = $this->request->getPost('fields', 'string', NULL );
        $post['table'] = $this->request->getPost('table', 'string', NULL );

        if(!(empty($post['table']))){
            $fields = explode(", ", $post['fields']);
            $data = $this->models->getCatalog()->getTranslateData($post['table'],$post['fields']);
            array_unshift($data, $fields);
            $this->excelphp->getData($data,$post['table'].'.xls');
            $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        } else {
            $this->flash->error( 'Не все поля заполнены.' );
            return $this->response->redirect([ 'for' => 'excel_worker_index' ]);
        }


    }

    function deleteAction($id)
    {

    }
}