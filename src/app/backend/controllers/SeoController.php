<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class SeoController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $seo = $this->seoUrl->getSeoData($this->models->getSeoInfo());
        $info = $this->models->getSeoInfo()->getAllSeo();
        $this->view->setVars([
            'info' => $info
        ]);
    }

    function setPdfFileAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file){
                //Move the file into the application
                $route = STORAGE_PATH.'temp/catalog.pdf';
                $file->moveTo($route);
            }
        }

    }

    function deleteAction()
    {
        $id = $this->request->get('id');
        $this->models->getSeoInfo()->deleteSeo($id);
        return $this->response->redirect([ 'for' => 'seo_info_index' ]);
    }

    function addAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() ){
            $data                = $this->request->getPost('data');
            $this->models->getSeoInfo()->addSeoData($data);
            return $this->response->redirect([ 'for' => 'seo_info_index' ]);
        }

        $this->view->setVars([

        ]);
    }

    function updateAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() ){
            $data                = $this->request->getPost('data');
            $this->models->getSeoInfo()->UpdateSeo($data);
            return $this->response->redirect([ 'for' => 'seo_info_index' ]);
        }

        $id = $this->request->get('id');
        $data = $this->models->getSeoInfo()->getOneSeo($id);

        $this->view->pick( 'seo/addEdit' );

        $this->view->setVars([
            'page' => $data
        ]);
    }

    function getPriceListAction(){
        $list_ru = $this->models->getItems()->getItemsList(2);
        $list_ua = $this->models->getItems()->getItemsList(1);
        $filename = 'products_seo.csv';

        $fp = fopen(STORAGE_PATH.'temp/'.$filename, 'w');

        foreach ($list_ru as $fields) {
            foreach ($fields as $k => $v) {
                if ($k == 'image_url') {

                    $fields[$k] = $this->storage->getPhotoUrl($v, 'group', '800x');
                }
            }

            fputcsv($fp, $fields, ",");
        }

        foreach ($list_ua as $fields) {
            foreach ($fields as $k => $v) {
                if ($k == 'image_url') {

                    $fields[$k] = $this->storage->getPhotoUrl($v, 'group', '800x');
                }
            }

            fputcsv($fp, $fields, ",");
        }

        fclose($fp);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        // читаем файл и отправляем его пользователю
        readfile(STORAGE_PATH.'temp/'.$filename);
        unlink(STORAGE_PATH.'temp/'.$filename);
        exit;
    }

    function getUsersListAction(){
        $list = $this->models->getCustomers()->getAllUsersD();

        $filename = 'users_list.csv';
        $fp = fopen(STORAGE_PATH.'temp/'.$filename, 'w');

        foreach ($list as $fields) {
            $fields['key'] ="http://semena.in.ua/cabinet/email-cancel/".md5( $fields['email'].'just_sum_text' );
            $fields['key_two'] ="http://semena.in.ua/cabinet/email-settings-key/".md5( $fields['email'].'just_sum_text' );
            $fields['key_three'] ="http://semena.in.ua/cabinet/key/".md5( $fields['email'].'just_sum_text' );
            fputcsv($fp, $fields, ",");
        }



        fclose($fp);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        // читаем файл и отправляем его пользователю
        readfile(STORAGE_PATH.'temp/'.$filename);
        unlink(STORAGE_PATH.'temp/'.$filename);
        exit;
    }


    function setReconciliationAction(){
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $post['text'] = $this->request->getPost('text', 'string', NULL );
        if(!(empty($post['text']))){
            $this->models->getManagerMail()->UpdateData($post);

            $data = $this->models->getManagerMail()->getData();

            return $this->response->redirect([ 'for' => 'set_reconciliation','page' => $data[0] ]);
        } else {
            $data = $this->models->getManagerMail()->getData();

            $this->view->setVars([
                'page' => $data[0]
            ]);
        }
    }

}