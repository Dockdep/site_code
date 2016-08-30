<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class PageController extends \Phalcon\Mvc\Controller
{
    ///////////////////////////////////////////////////////////////////////////

    public function indexAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }
        else
        {
            return $this->response->redirect([ 'for' => 'admin_orders' ]);
        }
    }

    ///////////////////////////////////////////////////////////////////////////

    public function orderAction( $page = 1 )
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $orders         = $this->models->getOrders()->getAllOrders( $page );
        $total          = $this->models->getOrders()->countAllOrders();
        $status         = [];

        if( !empty( $orders ) )
        {
            $status_temp    = $this->models->getOrders()->countStatus();

            foreach( $status_temp as $s )
            {
                $status[$s['status']] = $s['total'];
            }

            $orders_ids = $this->common->array_column( $orders, 'id' );

            $orders_sum = $this->models->getOrders()->getOrdersWithIds( $orders_ids );

            foreach( $orders_sum as $s )
            {
                $orders_total_sum[$s['order_id']] = 0;
                $orders_total_sum[$s['order_id']] += $s['item_count']*$s['price'];
            }

            foreach( $orders as $k => $o )
            {
                $orders[$k]['sum']          = isset($orders_total_sum[$o['id']]) ? $orders_total_sum[$o['id']] : 0;
                $orders[$k]['delivery_val'] = isset(\config::get( 'admin_delivery' )[$o['delivery']]) ? \config::get( 'admin_delivery' )[$o['delivery']] : null;
            }
        }

        $this->view->setVars([
            'orders'    => $orders,
            'page'      => $page,
            'total'     => $total['0']['total'],
            'status'    => $status
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function orderSortAction( $sort_type, $sort_id, $page = 1 )
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $total          = $this->models->getOrders()->countSortedOrders( $sort_type, $sort_id );
        $status         = [];
        $orders         = $this->models->getOrders()->getSortedOrders( $sort_type, $sort_id, $page );

        $status_temp    = $this->models->getOrders()->countStatus();

        foreach( $status_temp as $s )
        {
            $status[$s['status']] = $s['total'];
        }

        if( !empty( $orders ) )
        {
            $orders_ids = $this->common->array_column( $orders, 'id' );

            $orders_sum = $this->models->getOrders()->getOrdersWithIds( $orders_ids );

            foreach( $orders_sum as $s )
            {
                $orders_total_sum[$s['order_id']] = 0;
                $orders_total_sum[$s['order_id']] += $s['item_count']*$s['price'];
            }

            foreach( $orders as $k => $o )
            {
                $orders[$k]['sum']          = $orders_total_sum[$o['id']];
                $orders[$k]['delivery_val'] = \config::get( 'admin_delivery' )[$o['delivery']];
            }
        }

        $this->view->pick( 'page/order' );

        $this->view->setVars([
            'orders'    => $orders,
            'page'      => $page,
            'total'     => $total['0']['total'],
            'status'    => $status
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function loginAction()
    {
        if( $this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_orders' ]);
        }
        if( $this->request->isPost() )
        {
            $registration['email']              = $this->request->getPost('email', 'email', NULL );
            $passwd                             = $this->request->getPost('passwd', 'string', NULL );
            $registration['passwd']             = $this->common->hashPasswd( $passwd );

            //p($registration,1);

            switch( $this->models->getAdmins()->adminLogin( $registration ) )
            {
                case 1:
                    // OK
                    // redirect
                    return $this->response->redirect([ 'for' => 'admin_orders' ]);
                    break;

                case -1:
                default:
                    $this->flash->error('Неправильный логин или пароль');
                    return $this->response->redirect([ 'for' => 'admin_login' ]);
                    break;

                case 2: // admin with status 0
                default:
                    $this->flash->notice('Ваш статус еще не подтвержден');
                    return $this->response->redirect([ 'for' => 'admin_login' ]);
                    break;
            }
        }

        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);

        $this->view->setVars([

        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function adminLogoutAction()
    {
        // unauthorize user
        $this->session->remove('isAdminAuth');
        $this->session->remove('adminId');
        //$this->session->destroy();

        return $this->response->redirect([ 'for' => 'admin_login' ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function staticPageAction()
    {

        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        $params         = $this->dispatcher->getParams();

        $page           = !empty( $params['page']  ) ? $params['page'] : 1;

        $total = $this->models->getPages()->countData();

        if( $total['0']['total'] > \config::get( 'limits/items') )
        {

            $paginate = $this->common->paginate(
                [
                    'page'              => $page,
                    'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                    'total_items'       => $total[0]['total'],
                    'url_for'           => [ 'for' => 'static_page_paged', 'page' => $page ],
                    'index_page'       => 'static_page'
                ], true
            );


        }

        $pages = $this->models->getPages()->getAdminPages($page);

        $this->view->setVars([
            'pages' => $pages,
            'paginate' => !empty($paginate['output']) ? $paginate['output'] : '' ,
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function staticPageEditAction( $page_id )
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        //p($_SERVER['REQUEST_URI'],1);

        $page = $this->models->getPages()->getAdminPageById( $page_id );

        foreach( $page as $p )
        {
            $page_with_lang[$p['lang_id']] = $p;
        }

        if( $this->request->isPost() )
        {


            $page_edit['page_title']               = $this->request->getPost('page_title', 'string', NULL );
            $page_edit['page_alias']               = $this->request->getPost('page_alias', 'string', NULL );
            //$page_edit['page_content_text']        = $this->request->getPost('page_content_text', 'string', NULL );
            $page_edit['page_content_text']['1']          = $this->request->getPost('page_content_text_ua' );
            $page_edit['page_content_text']['2']          = $this->request->getPost('page_content_text_ru' );
            $page_edit['page_meta_title']          = $this->request->getPost('page_meta_title', 'string', NULL );
            $page_edit['page_meta_keywords']       = $this->request->getPost('page_meta_keywords', 'string', NULL );
            $page_edit['page_meta_description']    = $this->request->getPost('page_meta_description', 'string', NULL );

            $page_edit['page_status']              = $this->request->getPost('page_status', 'int', NULL );
            $page_edit['page_status']['1']         = empty( $page_edit['page_status']['1'] ) ? 0 : 1;
            $page_edit['page_status']['2']         = empty( $page_edit['page_status']['2'] ) ? 0 : 1;

            //p($page_edit['page_content_text'],1);

            if( !empty($page_edit['page_title']['1']) && !empty($page_edit['page_alias']['1']) && !empty($page_edit['page_content_text']['1']) )
            {
                foreach( $page_edit as $k => $p )
                {
                    $page_edit_with_lang['1'][$k]           = $p['1'];
                    $page_edit_with_lang['1']['page_id']    = $page_id;
                }
            }

            if( !empty($page_edit['page_title']['2']) && !empty($page_edit['page_alias']['2']) && !empty($page_edit['page_content_text']['2']) )
            {
                foreach( $page_edit as $k => $p )
                {
                    $page_edit_with_lang['2'][$k] = $p['2'];
                    $page_edit_with_lang['2']['page_id']    = $page_id;
                }
            }


            //p($page_edit,1);

            if( !empty( $page_edit_with_lang ) )
            {
                if( $this->models->getPages()->updatePages( $page_edit_with_lang, $page_id ) )
                {
                    $this->flash->success( 'Вы удачно обновили статическую страницу' );
                    return $this->response->redirect([ 'for' => 'static_page' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время обновления страницы. Повторите попытку позже' );
                }
            }
        }

        $this->view->pick( 'page/addEdit' );

        $this->view->setVars([
            'page' => $page_with_lang
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function staticPageAddAction()
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->request->isPost() )
        {


            $page_add['page_title']                 = $this->request->getPost('page_title', 'string', NULL );
            $page_add['page_alias']                 = $this->request->getPost('page_alias', 'string', NULL );
            $page_add['page_content_text']['1']          = $this->request->getPost('page_content_text_ua' );
            $page_add['page_content_text']['2']          = $this->request->getPost('page_content_text_ru' );
            $page_add['page_meta_title']            = $this->request->getPost('page_meta_title', 'string', NULL );
            $page_add['page_meta_keywords']         = $this->request->getPost('page_meta_keywords', 'string', NULL );
            $page_add['page_meta_description']      = $this->request->getPost('page_meta_description', 'string', NULL );

            $page_add['page_status']                = $this->request->getPost('page_status', 'int', NULL );
            $page_add['page_status']['1']           = empty( $page_add['page_status']['1'] ) ? 0 : 1;
            $page_add['page_status']['2']           = empty( $page_add['page_status']['2'] ) ? 0 : 1;
            $page_add_with_lang                     = [];
       
            if( !empty($page_add['page_title']['1']) && !empty($page_add['page_alias']['1']) && !empty($page_add['page_content_text']['1']) )
            {

                foreach( $page_add as $k => $p )
                {
                    $page_add_with_lang['1'][$k]           = $p['1'];
                }
            }

            if( !empty($page_add['page_title']['2']) && !empty($page_add['page_alias']['2']) && !empty($page_add['page_content_text']['2']) )
            {
                foreach( $page_add as $k => $p )
                {
                    $page_add_with_lang['2'][$k] = $p['2'];
                }
            }

            //p($page_add_with_lang,1);

            if( !empty( $page_add_with_lang ) )
            {
                if( $this->models->getPages()->addPages( $page_add_with_lang ) )
                {
                    $this->flash->success( 'Вы удачно добавили статическую страницу' );
                    return $this->response->redirect([ 'for' => 'static_page' ]);
                }
                else
                {
                    $this->flash->error( 'Произошла ошибка во время добавления страницы. Повторите попытку позже' );
                }
            }
        }

        $this->view->pick( 'page/addEdit' );

        $this->view->setVars([

        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function staticPageDeleteAction( $page_id )
    {
        if( !$this->session->get('isAdminAuth') )
        {
            return $this->response->redirect([ 'for' => 'admin_login' ]);
        }

        if( $this->models->getPages()->deletePages( $page_id ) )
        {
            $this->flash->success( 'Вы удачно удалили статическую страницу' );
            return $this->response->redirect([ 'for' => 'static_page' ]);
        }
        else
        {
            $this->flash->error( 'Произошла ошибка во время удаления страницы. Повторите попытку позже' );
            return $this->response->redirect([ 'for' => 'static_page' ]);
        }
    }

    public function downloadImgAction( )
    {
        if ($this->request->hasFiles() == true) {

            foreach ($this->request->getUploadedFiles() as $file){

                $allowed_filetypes = array('.jpg','.JPG', '.png', '.PNG', '.gif', '.GIF');

                $ext = substr($file->getName() ,strpos($file->getName() ,'.'),strlen($file->getName() )-1);
                if(in_array($ext,$allowed_filetypes))
                {
                    $path = $file->getTempName();

                    $md5_file = md5_file($path);

                    $image_path = $this->storage->getPhotoPath( 'temp', $md5_file, 'original' );
                    if(!file_exists(substr($image_path ,0,strlen($image_path )-13)))
                    {
                        $this->storage->mkdir( 'temp', $md5_file );
                        $file->moveTo($image_path);
                    }
                    $image_url = $this->storage->getPhotoUrl( $md5_file, 'temp', 'original' );
                    $message = 'Файл успешно загружен';
                } else {
                    $image_url = '';
                    $message =  'Произошла ошибка. Не верный формат файла.';
                }
                $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
                $callback = $_REQUEST['CKEditorFuncNum'];
                echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$image_url.'", "'.$message.'" );</script>';



            }
        }



    }

    public function downloadImagesAction()
    {
        if ($this->request->hasFiles() == true) {
            $data['directory'] = $this->request->getPost('directory' );
            foreach ($this->request->getUploadedFiles() as $file){

                $allowed_filetypes = array('.jpg','.JPG', '.png', '.PNG', '.gif', '.GIF');

                $ext = substr($file->getName() ,strpos($file->getName() ,'.'),strlen($file->getName() )-1);
                if(!$data['directory']) {
                    $data['directory'] = md5(microtime());
                }


                if(in_array($ext,$allowed_filetypes))
                {
                    $image_path = $this->storage->getEmailTemplatePath( 'temp', $data['directory']);
                    if(!file_exists($image_path))
                    {
                        mkdir( $image_path, 0777, true );
                    }
                    $file->moveTo($image_path.$file->getName());
                    $data['message'] = 'Загрузка файла '.$file->getName().' выполнена успешно.';
                } else {
                    $data['message'] = 'Произошла ошибка. Не верный формат файла.';
                }
                $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
                echo json_encode($data);



            }
        }
    }

    public function checkAjaxDataAction()
    {
        $name = $this->request->getQuery('name');
        $id = $this->request->getQuery('id');
        $result = $this->models->getEventEmail()->checkName($name, $id);
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        if($result) {
            echo "false";
        }
        else {
            echo "true";
        }
    }

    public function getCampaignListAction()
    {
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $name = $this->request->getQuery('term');
        $result = $this->models->getDelivery()->getCampaignLike($name);
        echo json_encode(
            array_reduce(
                $result,
                function($return, $elem) {
                    $return[] = array(
                        "label" => $elem['campaign'],
                        "value" => $elem['campaign']
                    );
                    return $return;
                }
            )
        );
    }

    public function csvAction()
    {
        $csv = dirname(__FILE__) . '/dealer.csv';
        $dealers = [];
        if (($handle = fopen($csv, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $data[1] = $this->common->generatePasswd(6);
                $data[2] = $this->common->hashPasswd($data[1]);
                $dealers[] = $data;
            }
            fclose($handle);
        }
        //$this->models->getCustomers()->updateUserPass($dealers);
        $new = $this->models->getCustomers()->getByName($dealers);

        $pass = dirname(__FILE__) . '/dealer.csv';
        if (($handle = fopen($csv, "w")) !== FALSE) {
            foreach($new as $v) {
                fputcsv($handle, $v);
            }
            fclose($handle);
        }

    }

    ///////////////////////////////////////////////////////////////////////////
}
