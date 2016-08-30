<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class NavigationController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $news = $this->models->getNavigation()->getAllData(1);

        $this->view->setVars([
            'info' => $news
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getNavigation()->deleteData($id);
        return $this->response->redirect([ 'for' => 'navigation_index' ]);
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
            $data['url']['1']    = $this->request->getPost('url_1', 'string', NULL );
            $data['weight']['1'] = $this->request->getPost('weight_1', 'int', NULL );

            $data['name']['2']   = $this->request->getPost('name_2', 'string', NULL );
            $data['url']['2']    = $this->request->getPost('url_2', 'string', NULL );
            $data['weight']['2'] = $this->request->getPost('weight_2', 'int', NULL );



            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;

            if( !empty($data['name']['1']) && !empty($data['url']['1']) && !empty($data['weight']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['name']['2']) && !empty($data['url']['2']) && !empty($data['weight']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }


            //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {
                if( $this->models->getNavigation()->UpdateData( $data_lang, $id ) )
                {
                    $this->flash->success( 'Вы удачно обновили пункт меню' );
                    return $this->response->redirect([ 'for' => 'navigation_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
        }
        $data_lang = array();
        $data = $this->models->getNavigation()->getOneData($id);
        $this->view->pick( 'navigation/addEdit' );
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
            $data['url']['1']    = $this->request->getPost('url_1', 'string', NULL );
            $data['weight']['1'] = $this->request->getPost('weight_1', 'int', NULL );

            $data['name']['2']   = $this->request->getPost('name_2', 'string', NULL );
            $data['url']['2']    = $this->request->getPost('url_2', 'string', NULL );
            $data['weight']['2'] = $this->request->getPost('weight_2', 'int', NULL );



            $status              = $this->request->getPost('status', 'int', NULL );
            $data['status']['1'] = $data['status']['2'] = empty( $status ) ? 0 : 1;


            if( !empty($data['name']['1']) && !empty($data['url']['1']) && !empty($data['weight']['1']) )
            {

                foreach( $data as $k => $p )
                {

                    $data_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($data['name']['2']) && !empty($data['url']['2']) && !empty($data['weight']['2']) )
            {
                foreach( $data as $k => $p )
                {
                    $data_lang['2'][$k] = $p['2'];
                }
            }


            //p($page_add_with_lang,1);

            if( !empty( $data_lang ) )
            {
                if( $this->models->getNavigation()->addData( $data_lang ) )
                {
                    $this->flash->success( 'Вы удачно добавили  пункт меню' );
                    return $this->response->redirect([ 'for' => 'navigation_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления. Повторите попытку позже' );
                }
            }
        }

        $this->view->pick( 'navigation/addEdit' );

        $this->view->setVars([

        ]);

    }
}