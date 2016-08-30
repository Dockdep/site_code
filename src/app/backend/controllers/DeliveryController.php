<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class DeliveryController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params = $this->dispatcher->getParams();
        $page   = !empty( $params['page']  ) ? $params['page'] : 1;
        $sort = array(
            'id' => '10'
        );
        $data   = $this->models->getDelivery()->getAllData($page, '', '', $sort);
        $total  = $this->models->getDelivery()->countData($sort);

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'           => $page,
                    'items_per_page' => \config::get( 'limits/admin_orders', 5),
                    'total_items'    => $total[0]['total'],
                    'url_for'        => [ 'for' => 'delivery_index_paged', 'page' => $page ],
                    'index_page'     => 'delivery_index'
                ], true
            );
        }

        $this->view->setVars([
            'info'     => $data,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    function deleteAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $this->models->getEventEmail()->deleteData($id);

        return $this->response->redirect([ 'for' => 'delivery_index' ]);
    }



    function moreInfoAction($id)
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }



        $this->view->pick( 'delivery/addEdit' );

        $this->view->setVars([

        ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $this->MyMailer->getDeliveryStatus($id);

        $this->MyMailer->getCampaignDeliveryStats($id);

        $this->MyMailer->getCampaignAggregateStats($id);

        $this->MyMailer->getVisitedLinks($id);





        if( $this->MyMailer->updateDeliveryData($id))
        {
            $this->flash->success( 'Обновление прошло успешно' );
        }
        else
        {
            $this->flash->error( 'Произошла ошибка во время обновления.' );
        }




        return $this->response->redirect([ 'for' => 'delivery_index' ]);

    }

    public function getUsersLikeAction()
    {
        $like = $this->request->getPost('like', 'string', NULL );
        $users = $this->models->getCustomers()->getActiveUsers($like);
        $result = json_encode($users);
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        echo $result;
    }
}