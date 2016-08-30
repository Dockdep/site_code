<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class AdminEmailController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        $params         = $this->dispatcher->getParams();
        $page           = !empty( $params['page']  ) ? $params['page'] : 1;
        $data = $this->models->getAdminEmailSections()->getAllData($page);
        $total = $this->models->getAdminEmailSections()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'admin_email_index_index_paged', 'page' => $page ],
                    'index_page'       => 'admin_email_index_index'
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
        $this->models->getAdminEmail()->deleteData($id);
        return $this->response->redirect([ 'for' => 'admin_email_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {
            $data['email'] = $this->request->getPost('email', 'string', NULL );
            $id = $this->request->getPost('section_id', 'int', NULL );

            $new_emails = explode(", ",$data['email']);

            $this->sendmail->addCustomer(2,array('holla', 'no holla'));


            if( !empty( $data ) )
            {
                if( $this->models->getAdminEmail()->deleteData($id) )
                {
                    foreach($new_emails as $email ){
                        $this->models->getAdminEmail()->addData($email, $id);
                    }
                    $this->flash->success( 'Сохранение прошло успешно' );
                    return $this->response->redirect([ 'for' => 'admin_email_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления. Повторите попытку позже' );
                }
            }
        }

        $emails = array();
        $data = $this->models->getAdminEmailSections()->getOneData($id);
        $this->view->pick( 'admin_email/addEdit' );
        foreach($data as $email){
            $emails[] = $email['email'];
        }
        $temp = implode(", ", $emails);
        $this->view->setVars([
            'page' => $data,
            'temp' => $temp
        ]);

    }

}