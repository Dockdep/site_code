<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class GroupsController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getUsersGroup()->getAllData($page);
        $total = $this->models->getUsersGroup()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'users_group_index_paged', 'page' => $page ],
                    'index_page'        => 'users_group_index'
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

        $this->models->getUsersGroup()->deleteData($id);

        return $this->response->redirect([ 'for' => 'users_group_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['name'] = $this->request->getPost('name', 'string', NULL );



            if( !empty( $data ) )
            {
                if( $this->models->getUsersGroup()->UpdateData( $data, $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'users_group_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
        }

        $data = $this->models->getUsersGroup()->getOneData($id);
        $this->view->pick( 'groups/addEdit' );

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

            $data['name']       = $this->request->getPost('name', 'string', NULL );


            if( !empty( $data ) && !isset($this->models->getUsersGroup()->getOneDataByName($data['name'])['0']) )
            {
                if( $this->models->getUsersGroup()->addData( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'users_group_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления. Повторите попытку позже' );
                }
            }
            else {
                $this->flash->error('Такая группа пользователей уже существует');
            }
        }

        $this->view->pick( 'groups/addEdit' );

    }
}