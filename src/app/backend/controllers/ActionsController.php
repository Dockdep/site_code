<?php
/**
 * Created by PhpStorm.
 * User: denys
 * Date: 06.10.15
 * Time: 10:14
 */

namespace controllers;


class ActionsController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        $data = $this->models->getActions()->getAllInfo();


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

        $this->models->getActions()->deleteData($id);

        return $this->response->redirect([ 'for' => 'actions_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() ) {
            $data['limit'] = $this->request->getPost('limit', 'string', NULL );

            if( !empty( $data ) )
            {
                if( $this->models->getActions()->updateData( $data, $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'actions_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
        }

        $data = $this->models->getActions()->getOneData($id);

        $this->view->pick('actions/addEdit');

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

        if( $this->request->isPost() ) {
            $data['limit']       = $this->request->getPost('name', 'string', NULL );

            if( !empty( $data ) )
            {
                if( $this->models->getActions()->addData( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'actions_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления. Повторите попытку позже' );
                }
            }
            else
            {
                $this->flash->error( 'Произошла ошибка во время добавления. Повторите попытку позже' );
            }
        }

        $this->view->pick( 'actions/addEdit' );

    }

}