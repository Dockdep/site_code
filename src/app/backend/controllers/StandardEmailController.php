<?php

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class StandardEmailController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params = $this->dispatcher->getParams();
        $page   = !empty( $params['page']  ) ? $params['page'] : 1;
        $data   = $this->models->getEventEmail()->getAllEmailData($page, "standard");
        $total  = $this->models->getEventEmail()->countData("standard");

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {
            $paginate = $this->common->paginate(
                [
                    'page'           => $page,
                    'items_per_page' => \config::get( 'limits/admin_orders', 5),
                    'total_items'    => $total[0]['total'],
                    'url_for'        => [ 'for' => 'standard_email_index_paged', 'page' => $page ],
                    'index_page'     => 'standard_email_index'
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

        return $this->response->redirect([ 'for' => 'standard_email_index' ]);
    }

    function updateAction($id)
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {
            $data['id']          = $this->request->getPost('id', 'int', NULL );
            $data['send']        = $this->request->getPost('send');
            $data['name']        = $this->request->getPost('name', 'string', NULL );
            $data['utm_status']  = $this->request->getPost('utm_status', 'int', NULL );
            $data['utm_campaign']= $this->request->getPost('utm_campaign', 'string', NULL );
            $data['utm_medium']  = $this->request->getPost('utm_medium', 'string', NULL );
            $data['utm_source']  = $this->request->getPost('utm_source', 'string', NULL );
            $data['utm_term']    = $this->request->getPost('utm_term', 'string', NULL );
            $data['utm_content'] = $this->request->getPost('utm_content', 'string', NULL );
            $data['status']      = $this->request->getPost('status', 'string', NULL );
            $data['template_id'] = $template_id  = $this->request->getPost('template_id', 'int', NULL );
            $data['users_id']    = $this->request->getPost('user_id');
            $data['type']        = 'standard';
            $data['utm_status']  = empty( $data['utm_status'] ) ? 0 : 1;
            $data['status']      = empty( $data['status'] ) ? 0 : 1;


            $template['title']          = $this->request->getPost('template_title', 'string', NULL );
            $template['text']           = $this->request->getPost('template_text');
            $template['directory']      = $this->request->getPost('directory', 'string', NULL );
            $template['name']           = $this->request->getPost('template_name', 'string', NULL );

            $parse['picture_url'] = $this->storage->getEmailTemplateUrl( 'temp', $template['directory']);
            $template['text'] = str_replace('%!picture_url!%', $parse['picture_url'], $template['text']);



            if( !empty( $data['name'] ) && !empty( $data['name'] ) )
            {
                if( $this->models->getEventEmail()->UpdateData( $data, $id ) )
                {


                    $template['event_id'] = $id;



                    $this->models->getEmailTemplates()->UpdateData( $template, $template_id );


                    if(isset($data['send']) && !empty($data['send'])){

                        if($data['utm_status'] && !empty($data['utm_campaign']) && !empty($data['utm_medium']) && !empty($data['utm_source'])) {

                            $template['text'] = $this->UTMParser->parse($data, $template);

                        }
                        if(isset($data['users_id']) && !empty($data['users_id'])) {
                          $this->MyMailer->SendDelivery($template,$data);
                           // $this->MyMailer->SendForSelect($template,$data['users_id']);

                        } else {
                            $this->MyMailer->SendDeliveryForAll($template,$data);


                        }
                    } else {
                        $this->flash->success( 'Сохранение прошло успешно' );
                    }
                    return $this->response->redirect([ 'for' => 'standard_email_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления.' );
                }
            }

        }


        $data      = $this->models->getEventEmail()->getOneData($id);
        $templates =  $this->models->getEmailTemplates()->getAllData();
        $temp      =  $this->models->getEmailTemplates()->getOneData($data[0]['template_id']);
        $this->view->pick( 'standard_email/addEdit' );

        $this->view->setVars([
            'page' => $data,
            'templates' => $templates,
            'temp' => $temp
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
            $data['id']          = $this->request->getPost('id', 'int', NULL );
            $data['send']        = $this->request->getPost('send');
            $data['name']        = $this->request->getPost('name', 'string', NULL );
            $data['utm_status']  = $this->request->getPost('utm_status', 'int', NULL );
            $data['utm_campaign']= $this->request->getPost('utm_campaign', 'string', NULL );
            $data['utm_medium']  = $this->request->getPost('utm_medium', 'string', NULL );
            $data['utm_term']    = $this->request->getPost('utm_term', 'string', NULL );
            $data['utm_content'] = $this->request->getPost('utm_content', 'string', NULL );
            $data['utm_source']  = $this->request->getPost('utm_source', 'string', NULL );
            $data['users_id']    = $this->request->getPost('user_id');
            $data['status']      = $this->request->getPost('status', 'string', NULL );
            $data['type']        = 'standard';

            $data['utm_status']  = empty( $data['utm_status'] ) ? 0 : 1;
            $data['status']      = empty( $data['status'] ) ? 0 : 1;


            $template['title']          = $this->request->getPost('template_title', 'string', NULL );
            $template['text']           = $this->request->getPost('template_text');
            $template['directory']      = $this->request->getPost('directory', 'string', NULL );
            $template['name']           = $this->request->getPost('template_name', 'string', NULL );

            $parse['picture_url'] = $this->storage->getEmailTemplateUrl( 'temp', $template['directory']);
            $template['text']     = str_replace('%!picture_url!%', $parse['picture_url'], $template['text']);

            if( !empty( $data['name'] ) && !empty( $data['name'] ) )
            {
                if( $template['event_id'] = $this->models->getEventEmail()->addData( $data ) )
                {

                    if($data['utm_status'] && !empty($data['utm_campaign']) && !empty($data['utm_medium']) && !empty($data['utm_source'])) {

                        $template['text'] = $this->UTMParser->parse($data, $template);

                    }

                    $template['event_id'] = $template['event_id'][0]['id'];
                    $template_id          = $this->models->getEmailTemplates()->addData( $template );
                    $this->models->getEventEmail()->addTemplateId($template_id[0]['id'] , $template['event_id'] );

                    if(isset($data['send']) && !empty($data['send'])){

                        if($data['utm_status'] && !empty($data['utm_campaign']) && !empty($data['utm_medium']) && !empty($data['utm_source'])) {

                            $template['text'] = $this->UTMParser->parse($data, $template);

                        }

                        if(isset($data['users_id']) && !empty($data['users_id'])) {

                            $this->MyMailer->SendForSelect($template,$data['users_id']);

                        } else {

                            $this->MyMailer->SendForAll($template,$data);
                        }
                    } else {
                        $this->flash->success( 'Сохранение прошло успешно' );
                    }
                    return $this->response->redirect([ 'for' => 'standard_email_index' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления.' );
                }
            }
        }


        $templates =  $this->models->getEmailTemplates()->getAllData();


        $this->view->pick( 'standard_email/addEdit' );

        $this->view->setVars([
            'templates' => $templates,
        ]);

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