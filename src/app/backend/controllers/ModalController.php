<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ModalController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        $params         = $this->dispatcher->getParams();

        $page           = !empty( $params['page']  ) ? $params['page'] : 1;

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $news = $this->models->getModal()->getAllData($page );
        $total = $this->models->getModal()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => 20,
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'modal_index_paged', 'page' => $page ],
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
        $this->models->getModal()->deleteData($id);
        return $this->response->redirect([ 'for' => 'modal_index' ]);
    }

    function updateAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['text']['1']   = $this->request->getPost('text_1', 'string', NULL );
            $data['link']['1']  = $this->request->getPost('link_1', 'string', NULL );


            $data['text']['2']   = $this->request->getPost('text_2', 'string', NULL );
            $data['link']['2']  = $this->request->getPost('link_2', 'string', NULL );

            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;



            if( !empty($data['text']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['text']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }

            //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {
                if( $this->models->getModal()->UpdateData( $data_lang, $id ) )
                {
                    $this->flash->success( "Обновление прошло успешно" );
                    return $this->response->redirect([ 'for' => 'modal_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
                }
            }
        }
        $data_lang = array();

        $data = $this->models->getModal()->getOneData($id);
        $this->view->pick( 'modal/addEdit' );
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

            $data['text']['1']   = $this->request->getPost('text_1', 'string', NULL );
            $data['link']['1']  = $this->request->getPost('link_1', 'string', NULL );


            $data['text']['2']   = $this->request->getPost('text_2', 'string', NULL );
            $data['link']['2']  = $this->request->getPost('link_2', 'string', NULL );

            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;



            if( !empty($data['text']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['text']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }



            //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {

                if( $this->models->getModal()->addData( $data_lang) )
                {
                    $this->flash->success( 'Добавление прошло успешно' );
                    return $this->response->redirect([ 'for' => 'modal_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления банера. Повторите попытку позже' );
                }
            }
          ;
        }

        $this->view->pick( 'modal/addEdit' );

        $this->view->setVars([

        ]);


    }








}