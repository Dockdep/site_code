<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class CustomersController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getCustomers()->getAllData($page);
        $total = $this->models->getCustomers()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'customers_index_paged', 'page' => $page ],
                    'index_page'       => 'customers_index'
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
        $this->models->getCustomers()->deleteData($id);
        return $this->response->redirect([ 'for' => 'customers_index' ]);
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
            $data['email'] = $this->request->getPost('email', 'string', NULL );
            $data['password'] = $this->request->getPost('password', 'string', NULL );
            $data['birth_date'] = $this->request->getPost('birth_date', 'string', NULL );
            $data['phone'] = $this->request->getPost('phone', 'string', NULL );
            $data['city'] = $this->request->getPost('city', 'string', NULL );
            $data['address'] = $this->request->getPost('address', 'string', NULL );
            $data['delivery'] = $this->request->getPost('delivery', 'int', NULL );
            $data['pay'] = $this->request->getPost('pay', 'int', NULL );
            $data['subscribed'] = $this->request->getPost('subscribed', 'int', NULL );
            $data['comments'] = $this->request->getPost('comments', 'string', NULL );
            $data['status'] = $this->request->getPost('status', 'int', NULL );
            $data['users_group_id'] = $this->request->getPost('users_group', 'string', NULL );
            $data['special_users_id'] = $this->request->getPost('special_users', 'string', NULL );

            $data['pay']        = empty( $data['pay'] ) ? 0 : 1;
            $data['subscribed'] = empty( $data['subscribed'] ) ? 0 : 1;
            $data['status']     = empty( $data['status'] ) ? 0 : 1;

            if( !empty( $data['password'] ) )
            {
                $data['password'] = $this->common->hashPasswd($data['password']);
            }


            if( !empty( $data ) && !isset($this->models->getCustomers()->getCustomerByEmail($data['email'])['0']) )
            {
                if( $this->models->getCustomers()->UpdateData( $data, $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'customers_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
            else
            {
                $this->flash->error('Пользователь с таким эмейлом уже существует');
            }
        }

        $users_group = $this->models->getUsersGroup()->getAllData(1);
        $special_users = $this->models->getSpecialUsers()->getAllData(1);
        $data = $this->models->getCustomers()->getOneData($id);
        $this->view->pick( 'customers/addEdit' );

        $this->view->setVars([
            'users_group'=> !empty($users_group) ? $users_group : array(),
            'special_users' => !empty($special_users) ? $special_users : array(),
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
            $data['email']      = $this->request->getPost('email', 'string', NULL );
            $data['password']   = $this->request->getPost('password', 'string', NULL );
            $data['birth_date'] = $this->request->getPost('birth_date', 'string', NULL );
            $data['phone']      = $this->request->getPost('phone', 'string', NULL );
            $data['city']       = $this->request->getPost('city', 'string', NULL );
            $data['address']    = $this->request->getPost('address', 'string', NULL );
            $data['delivery']   = $this->request->getPost('delivery', 'int', NULL );
            $data['pay']        = $this->request->getPost('pay', 'int', NULL );
            $data['subscribed'] = $this->request->getPost('subscribed', 'int', NULL );
            $data['comments']   = $this->request->getPost('comments', 'string', NULL );
            $data['status']     = $this->request->getPost('status', 'int', NULL );
            $data['users_group_id'] = $this->request->getPost('users_group', 'string', NULL );
            $data['special_users_id'] = $this->request->getPost('special_users', 'string', NULL );


            $data['pay']        = empty( $data['pay'] ) ? 0 : 1;
            $data['subscribed'] = empty( $data['subscribed'] ) ? 0 : 1;
            $data['status']     = empty( $data['status'] ) ? 0 : 1;


            if( !empty( $data['password'] ) )
            {
                $data['password'] = $this->common->hashPasswd($data['password']);

            }

            if( !empty( $data ) && !isset($this->models->getCustomers()->getCustomerByEmail($data['email'])['0']) )
            {
                if( $this->models->getCustomers()->addData( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'customers_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления. Повторите попытку позже' );
                }
            }
            else
            {
                $this->flash->error('Пользователь с таким эмейлом уже существует');
            }
        }
        $users_group = $this->models->getUsersGroup()->getAllData(1);
        $special_users = $this->models->getSpecialUsers()->getAllData(1);
        $this->view->pick( 'customers/addEdit' );

        $this->view->setVars([
            'users_group'=> !empty($users_group) ? $users_group : array(),
            'special_users' => !empty($special_users) ? $special_users : array()
        ]);

    }
}