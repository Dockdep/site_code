<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class SliderController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        $params         = $this->dispatcher->getParams();

        $page           = !empty( $params['page']  ) ? $params['page'] : 1;

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $news = $this->models->getSlider()->getAllData($page );
        $total = $this->models->getSlider()->countData();


        if( $total['0']['total'] > \config::get( 'limits/items') )
        {

            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => 10,
                    'total_items'       => $total[0]['total']/2,
                    'url_for'           => [ 'for' => 'slider_index_paged', 'page' => $page ],
                    'index_page'       => 'slider_index'
                ], true
            );
        }

        $this->view->setVars([
            'info' => $news,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getSlider()->deleteData($id);
        return $this->response->redirect([ 'for' => 'slider_index' ]);
    }

    function updateAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['name']['1']   = $this->request->getPost('name_1', 'string', NULL );
            $data['weight']['1'] = $this->request->getPost('weight_1', 'int', NULL );
            $data['image']['1']  = $this->request->getPost('existing_image_1', 'string', NULL );
            $data['link']['1']  = $this->request->getPost('link_1', 'string', NULL );


            $data['name']['2']   = $this->request->getPost('name_2', 'string', NULL );
            $data['weight']['2'] = $this->request->getPost('weight_2', 'int', NULL );
            $data['image']['2']  = $this->request->getPost('existing_image_2', 'string', NULL );
            $data['link']['2']  = $this->request->getPost('link_2', 'string', NULL );

            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;


            //Check if the user has uploaded files
            if ($this->request->hasFiles() == true) {
                //Print the real file names and their sizes
                foreach ($this->request->getUploadedFiles() as $file){

                    $allowed_filetypes = array('.jpg','.JPG','.gif','.GIF');

                    $num = str_replace('image_', '', $file->getKey());

                    $data['image'][$num]  = $file->getName();

                    $ext = substr($data['image'][$num] ,strpos($data['image'][$num] ,'.'),strlen($data['image'][$num] )-1);

                    if(in_array($ext,$allowed_filetypes)){

                        $file->moveTo('../storage/cat/' . $file->getName());

                    } else {
                        $this->flash->error( 'Произошла ошибка. Не верный формат файла.' );
                    }

                }
            }

            if( !empty($data['name']['1'])  && !empty($data['weight']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['name']['2'])  && !empty($data['weight']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }

                //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {
                if( $this->models->getSlider()->UpdateData( $data_lang, $id ) )
                {
                    $this->flash->success( "Обновление прошло успешно" );
                    return $this->response->redirect([ 'for' => 'slider_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
                }
            }
        }
        $data_lang = array();

        $data = $this->models->getSlider()->getOneData($id);
        $this->view->pick( 'slider/addEdit' );
        foreach($data as $p )
        {
            $data_lang[$p['lang_id']] = $p;
        }
        $this->view->setVars([
            'page' => $data_lang
        ]);

    }

    function addAction()
    {


        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['name']['1']   = $this->request->getPost('name_1', 'string', NULL );
            $data['weight']['1'] = $this->request->getPost('weight_1', 'int', NULL );
            $data['image']['1']  = $this->request->getPost('existing_image_2', 'int', NULL );
            $data['link']['1']  = $this->request->getPost('link_1', 'string', NULL );


            $data['name']['2']   = $this->request->getPost('name_2', 'string', NULL );
            $data['weight']['2'] = $this->request->getPost('weight_2', 'int', NULL );
            $data['image']['2']  = $this->request->getPost('existing_image_2', 'int', NULL );
            $data['link']['2']  = $this->request->getPost('link_2', 'string', NULL );

            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;


            //Check if the user has uploaded files
            if ($this->request->hasFiles() == true) {
                //Print the real file names and their sizes
                foreach ($this->request->getUploadedFiles() as $file){

                    $allowed_filetypes = array('.jpg','.JPG','.gif','.GIF');

                    $num = str_replace('image_', '', $file->getKey());

                    $data['image'][$num]  = $file->getName();

                    $ext = substr($data['image'][$num] ,strpos($data['image'][$num] ,'.'),strlen($data['image'][$num] )-1);

                    if(in_array($ext,$allowed_filetypes)){

                        $file->moveTo('../storage/cat/' . $file->getName());

                    } else {
                        $this->flash->error( 'Произошла ошибка. Не верный формат файла.' );
                    }

                }
            }

            if( !empty($data['name']['1'])  && !empty($data['weight']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['name']['2'])  && !empty($data['weight']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }



            //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {
                if( $this->models->getSlider()->addData( $data_lang) )
                {
                    $this->flash->success( 'Добавление прошло успешно' );
                    return $this->response->redirect([ 'for' => 'slider_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
                }
            }
        }

        $this->view->pick( 'slider/addEdit' );

        $this->view->setVars([

        ]);

    }
}