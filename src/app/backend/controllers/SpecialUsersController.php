<?php

namespace controllers;


class SpecialUsersController extends \Phalcon\Mvc\Controller
{
    public function indexAction() {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getSpecialUsers()->getAllData($page);
        $total = $this->models->getSpecialUsers()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'special_users_index_paged', 'page' => $page ],
                    'index_page'        => 'special_users_index'
                ], true
            );
        }
        $this->view->setVars([
            'info' => $data,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    public function addAction() {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['name']       = $this->request->getPost('name', 'string', NULL );
            $data['discount'] = $this->request->getPost('discount', 'string', NULL );
            $data['year_budget'] = $this->request->getPost('year_budget', 'string', NULL );
            $data['first_order'] = $this->request->getPost('first_order', 'string', NULL );

            if( !empty( $data ) && !isset($this->models->getSpecialUsers()->getOneDataByName($data['name'])['0']) )
            {
                if( $this->models->getSpecialUsers()->addData( $data ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'special_users_index' ]);
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

        $this->view->pick( 'special_users/addEdit' );
    }

    public function deleteAction($id) {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $this->models->getSpecialUsers()->deleteData($id);

        return $this->response->redirect([ 'for' => 'special_users_index' ]);
    }

    public function updateAction($id) {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {

            $data['discount'] = $this->request->getPost('discount', 'string', NULL );
            $data['year_budget'] = $this->request->getPost('year_budget', 'string', NULL );
            $data['first_order'] = $this->request->getPost('first_order', 'string', NULL );

            if( !empty( $data ) )
            {
                if( $this->models->getSpecialUsers()->UpdateData( $data, $id ) )
                {
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'special_users_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
        }

        $data = $this->models->getSpecialUsers()->getOneData($id);
        $this->view->pick( 'special_users/addEdit' );

        $this->view->setVars([
            'page' => $data
        ]);
    }
}