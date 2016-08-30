<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class EmailTemplatesController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getEmailTemplates()->getAllData($page);
        $total = $this->models->getEmailTemplates()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'email_templates_index_paged', 'page' => $page ],
                    'index_page'       => 'email_templates_index'
                ], true
            );
        }
        $this->view->setVars([
            'info' => $data,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getEmailTemplates()->deleteData($id);
        return $this->response->redirect([ 'for' => 'email_templates_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['title']          = $this->request->getPost('title', 'string', NULL );
            $data['name']           = $this->request->getPost('name', 'string', NULL );
            $data['text']           = $this->request->getPost('page_content_text_1');
            $data['directory']      = $this->request->getPost('directory', 'string', NULL );
            $data['event_id']       = '0';

            $parse['picture_url'] = $this->storage->getEmailTemplateUrl( 'temp', $data['directory']);

            $data['text'] = str_replace('%!picture_url!%', $parse['picture_url'], $data['text']);


            if( !empty( $data['name'] ) && !empty( $data['text']))
            {
                if( $this->models->getEmailTemplates()->UpdateData( $data, $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'email_templates_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления.' );
                }
            }
        }


        $data = $this->models->getEmailTemplates()->getOneData($id);
        $this->view->pick( 'email_templates/addEdit' );

        $this->view->setVars([
            'page' => $data
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

            $data['title']          = $this->request->getPost('title', 'string', NULL );
            $data['name']           = $this->request->getPost('name', 'string', NULL );
            $data['text']           = $this->request->getPost('page_content_text_1');
            $data['directory']      = $this->request->getPost('directory', 'string', NULL );
            $data['event_id']       = '0';

            $parse['picture_url'] = $this->storage->getEmailTemplateUrl( 'temp', $data['directory']);


            preg_match_all('/\%!(.+)\!%/U', $data['text'], $matches);
            $data['text'] = str_replace('%!picture_url!%', $parse['picture_url'], $data['text']);


            if( !empty( $data['name'] ) && !empty( $data['text']))
            {
                if( $this->models->getEmailTemplates()->addData( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'email_templates_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления.' );
                }
            }
        }

        $this->view->pick( 'email_templates/addEdit' );

        $this->view->setVars([

        ]);

    }

    function ajaxAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        if( $this->request->isPost() )
        {
            $id = $this->request->getPost('id', 'int', NULL );
            $data =  $this->models->getEmailTemplates()->getOneData($id);
            $data = json_encode($data['0']);
            $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);

            echo !empty($data) ? $data : '';
        }


    }
}