<?php

namespace controllers;


class CustomerIdeasController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getCustomerIdeas()->getAllData($page);
        $total = $this->models->getCustomerIdeas()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'customer_ideas_index_paged', 'page' => $page ],
                    'index_page'        => 'customer_ideas_index'
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

    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() ) {
        }

            $data = $this->models->getCustomerIdeas()->getOneData($id);
            $this->view->pick('customer_ideas/addEdit');

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



    }
}