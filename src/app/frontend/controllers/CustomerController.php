<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class CustomerController extends \controllers\ControllerBase
{

    public function customerLoginAction(  )
    {
        if( $this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'cabinet' , 'language' => $this->lang_name ]);
        }

        $this->session->set( 'return_url', 'cabinet' );

        if( $this->request->isPost() )
        {
            $registration['email']              = $this->request->getPost('email', 'email', NULL );
            $passwd                             = $this->request->getPost('passwd', 'string', NULL );
            $registration['passwd']             = $this->common->hashPasswd( $passwd );

            switch( $this->models->getCustomers()->customerLogin( $registration ) )
            {
                case 1:
                    // OK
                    // redirect
                    if($this->session->get('special_users_id') != null) {
                        return $this->response->redirect(['for' => 'personal_data', 'language' => $this->lang_name]);
                    }
                    return $this->response->redirect(['for' => 'cabinet', 'language' => $this->lang_name]);

                    break;

                case -1:
                default:
                    $this->flash->error($this->languages->getTranslation()->_("incorrect_login_or_password"));
                    return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name  ]);
                    break;

                case 2: // user with status 0
                default:
                    $this->flash->success($this->languages->getTranslation()->_("please_change_the_password" ));
                    $this->session->set( 'customer_email', $registration['email'] );
                    return $this->response->redirect([ 'for' => 'finish_registration', 'language' => $this->lang_name  ]);
                    break;

            }

        }

        $this->view->setVars([
            'no_robots' => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function customerLoginSocialAction(  )
    {
        $params = $this->dispatcher->getParams();
        $mechanism = $params['mechanism'];
        if( isset($_GET['code']) )
        {
            $result = $this->social->authorizeWithSocial( $mechanism, $_GET['code'] );

            if( $result )
            {
                return $this->response->redirect([ 'for' => $this->session->get('return_url'), 'language' => $this->lang_name ]);
            }
            else
            {
                $this->flash->error($this->languages->getTranslation()->_("authentication_error" ));
                return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
            }
        }
        elseif( isset($_GET['error']) )
        {
            if( trim($_GET['error'])=='access_denied' )
            {
                $error_message = $this->languages->getTranslation()->_("social_authentication_error" );         // Ошибка авторизации: Пользователь отм
            }
            else
            {
                $error_message = trim($_GET['error']);
            }

            $this->flash->error($error_message);
            return $this->response->redirect([ 'for' => $this->session->get('return_url'), 'language' => $this->lang_name ]);
        }
    }

    ///////////////////////////////////////////////////////////////////////////

    public function customerLogoutAction()
    {
        // unauthorize user
        $this->session->remove('isAuth');
        $this->session->remove('id');
        $this->session->remove('special_users_id');
        $this->session->remove('users_group_id');
        return $this->response->redirect([ 'for' => 'homepage']);
    }
    ///////////////////////////////////////////////////////////////////////////

    public function emailCancelAction($confirm_key){
        $this->lang_name = $this->seoUrl->getLangName();


        $emailSettings = $this->models->getEmailSettings()->getCustomerByConfirmKey( $confirm_key );

        $customer = $this->models->getCustomers()->getCustomer( $emailSettings[0]['user_id']  );

        if($customer){
            $this->getDi()->get('session')->set( 'isAuth',      true );
            $this->getDi()->get('session')->set( 'id',          $customer[0]['id'] );

        }

        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }

        $orders     = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );

        $month_names = $this->languages->getTranslation()->_("month_list");

        if( $this->request->isPost() && $emailSettings )
        {
            if($this->request->getPost('step-1')){
                $emailSettings[0]['user_id']         = $this->session->get('id');
                $emailSettings[0]['frequency']       = $this->request->getPost('frequency', 'string');

                $this->models->getEmailSettings()->updateData( $emailSettings[0] );
                return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name  ]);

            } elseif($this->request->getPost('step-2')){
                $emailSettings[0]['delivery_status'] = 0;
                $emailSettings[0]['user_id']         = $this->session->get('id');
                $emailSettings[0]['cancel_reason']   = $this->request->getPost('cancel_reason', 'string');

                $this->models->getEmailSettings()->updateData( $emailSettings[0] );
                return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name  ]);

            }



        }

        $this->view->setVars([
            'customer'      => $customer[0],
            'emailSettings' => $emailSettings[0],
            'month_names'   => $month_names,
            'orders'        => $orders
        ]);
    }

    public function emailSettingsKeyAction($confirm_key)
    {

        $emailSettings = $this->models->getEmailSettings()->getCustomerByConfirmKey( $confirm_key );

        $customer = $this->models->getCustomers()->getCustomer( $emailSettings[0]['user_id']  );

        if($customer){
            $this->getDi()->get('session')->set( 'isAuth',      true );
            $this->getDi()->get('session')->set( 'id',          $customer[0]['id'] );
            return $this->response->redirect([ 'for' => 'cabinet_email_settings', 'language' => $this->lang_name  ]);
        } else {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }

    }

    public function emailSubscrAction(){
        $name = $this->request->getPost('name', 'string');
        $email = $this->request->getPost('email', 'string');
        $this->models->getCustomers()->subscrCustomer( $name,$email);
        die($name.' '.$email);
    }


    public function cabinetSettingsKeyAction($confirm_key){
        
        $emailSettings = $this->models->getEmailSettings()->getCustomerByConfirmKey( $confirm_key );

        $customer = $this->models->getCustomers()->getCustomer( $emailSettings[0]['user_id']  );

        if($customer){
            $this->getDi()->get('session')->set( 'isAuth',      true );
            $this->getDi()->get('session')->set( 'id',          $customer[0]['id'] );
            return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name  ]);
        } else {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }
    }

    public function emailSettingsAction()
    {
        
        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }

        $customer   = $this->models->getCustomers()->getCustomer( $this->session->get('id') );
        $orders     = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );
        $emailSettings     = $this->models->getEmailSettings()->getSettings( $this->session->get('id') );

        if( $this->request->isPost() )
        {
            $email_settings['delivery_status'] = $this->request->getPost('delivery_status', 'int',0);
            $email_settings['section_one']     = $this->request->getPost('section_one', 'int',0);
            $email_settings['section_two']     = $this->request->getPost('section_two', 'int',0);
            $email_settings['section_three']   = $this->request->getPost('section_three', 'int',0);
            $email_settings['section_four']    = $this->request->getPost('section_four', 'int',0);
            $email_settings['section_five']    = $this->request->getPost('section_five', 'int',0);
            $email_settings['section_six']     = $this->request->getPost('section_six', 'int',0);
            $email_settings['events']          = $this->request->getPost('events', 'int',0);
            $email_settings['novelty']         = $this->request->getPost('novelty', 'int',0);
            $email_settings['materials']       = $this->request->getPost('materials', 'int',0);
            $email_settings['user_id']         = $this->session->get('id');
            $email_settings['frequency']       = $this->request->getPost('frequency', 'string');
            $email_settings['confirm_key']     = md5( $customer[0]['email'].'just_sum_text' );
            $email_settings['cancel_reason']   = '';

            if($emailSettings){
                $this->models->getEmailSettings()->updateData( $email_settings );
            }else {
                $this->models->getEmailSettings()->addData( $email_settings );
            }


        }

        $this->view->setVars([
            'email_settings'=> !empty($emailSettings[0]) ? $emailSettings[0] : null,
            'orders'        => $orders

        ]);
    }
    ///////////////////////////////////////////////////////////////////////////

    public function registrationAction(  )
    {

        if( $this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
        }

        $err = 0;

        if( $this->request->isPost() )
        {

            $registration['name']               = $this->request->getPost('registration_name', 'string', NULL );
            $registration['email']              = $this->request->getPost('registration_email', 'email', NULL );
            $registration['passwd']             = $this->request->getPost('registration_passwd', 'string', NULL );
            $registration['confirm_passwd']     = $this->request->getPost('registration_confirm_passwd', 'string', NULL );

            foreach( $registration as $o )
            {
                if( empty($o) )
                {
                    $err = 1;
                }
            }

            if( $registration['confirm_passwd'] === $registration['passwd'] && empty( $err ) )
            {
                $registration['passwd']          = $this->common->hashPasswd( $registration['passwd'] );

                if( $registration['confirm_key'] = $this->models->getCustomers()->registrateCustomer( $registration ) )
                {

                    $email_settings['delivery_status'] = 1;
                    $email_settings['section_one']     = 1;
                    $email_settings['section_two']     = 1;
                    $email_settings['section_three']   = 1;
                    $email_settings['section_four']    = 1;
                    $email_settings['section_five']    = 1;
                    $email_settings['section_six']     = 1;
                    $email_settings['events']          = 1;
                    $email_settings['novelty']         = 1;
                    $email_settings['materials']       = 1;
                    $email_settings['user_id']         = $this->models->getCustomers()->getLastCustomer( );
                    $email_settings['frequency']       = 'one_week';
                    $email_settings['confirm_key']     = md5( $registration['email'].'just_sum_text' );


                    $this->models->getEmailSettings()->addData( $email_settings );

                    $this->sendmail->addCustomer( 5, $registration );
                    $this->flash->success( $this->languages->getTranslation()->_("finish_registration_email"));
                    return $this->response->redirect([ 'for' => 'registration_canceled', 'language' => $this->lang_name ]);
                }
                else
                {

                    $this->session->set( 'customer_email', $registration['email'] );
                    $this->flash->error( $this->languages->getTranslation()->_("email_already_exists").'.&nbsp;<a href="'.$this->url->get([ 'for' => 'restore_passwd' ]).'">'.$this->languages->getTranslation()->_("forgot_your_password").'</a>' );
                    return $this->response->redirect([ 'for' => 'registration', 'language' => $this->lang_name ]);
                }
            }

        }

        $this->view->setVars([
            'no_robots'         => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function confirmRegistrationAction( $confirm_key )
    {
        $params = $this->dispatcher->getParams();
        $confirm_key = $params['confirm_key'];
        switch( $this->models->getCustomers()->checkCustomerByConfirmKey( $confirm_key ) )
        {
            case 1:
                // OK
                // redirect
                $this->flash->success($this->languages->getTranslation()->_("success_message"));
                return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
                break;

            case 0:
            default:
                $this->flash->error($this->languages->getTranslation()->_("user_email_not_exist"));
                break;

        }


    }

    ///////////////////////////////////////////////////////////////////////////

    public function restorePasswdAction()
    {
        if( $this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
        }

        if( $this->request->isPost() )
        {
            $email                  = $this->request->getPost('email', 'email', NULL );
            $registration['email']  = filter_var( $email, FILTER_VALIDATE_EMAIL );

            if( !empty( $registration['email'] ) )
            {
                if( $confirm_key = $this->models->getCustomers()->restorePasswd( $email ) )
                {
                    $registration['confirm_key']    = $confirm_key['confirm_key'];
                    $registration['name']           = $confirm_key['name'];
                    $this->sendmail->addCustomer( 6, $registration );

                    $this->flash->success($this->languages->getTranslation()->_("visit_email_message"));
                    return $this->response->redirect([ 'for' => 'restore_passwd', 'language' => $this->lang_name ]);
                }
                else
                {
                    $this->flash->error($this->languages->getTranslation()->_("user_email_not_exist"));
                    return $this->response->redirect([ 'for' => 'restore_passwd', 'language' => $this->lang_name ]);
                }
            }
            else
            {
                $this->flash->error($this->languages->getTranslation()->_("please_enter_a_valid_email"));
                return $this->response->redirect([ 'for' => 'restore_passwd', 'language' => $this->lang_name ]);
            }

        }

        $this->view->setVars([
            'no_robots'         => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function resetPasswdAction( $confirm_key  )
    {
        $params = $this->dispatcher->getParams();
        $confirm_key = $params['confirm_key'];
        if( $this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
        }

        if( $this->request->isPost() )
        {
            $passwd                             = $this->request->getPost('passwd', 'string', NULL );
            $confirm_passwd                     = $this->request->getPost('confirm_passwd', 'string', NULL );

            if( $passwd === $confirm_passwd )
            {
                $registration['passwd']          = $this->common->hashPasswd( $passwd );
                $registration['confirm_key']     = $confirm_key;

                switch( $this->models->getCustomers()->resetPasswd( $registration ) )
                {
                    case 1:
                        // OK
                        // redirect
                        $this->flash->success($this->languages->getTranslation()->_("successfully_edited_your_password"));
                        return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
                        break;

                    case 0:
                    default:
                        $this->flash->error($this->languages->getTranslation()->_("user_email_not_exist"));
                        return $this->response->redirect([ 'for' => 'reset_passwd', 'language' => $this->lang_name ]);
                        break;

                }
            }

        }

        $this->view->pick('customer/finishRegistration');

        $this->view->setVars([
            'breadcrambs_title' => $this->languages->getTranslation()->_("changing_password"),
            'no_robots'         => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function finishRegistrationAction(  )
    {
        if( $this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
        }

        if( $this->request->isPost() )
        {
            $passwd                             = $this->request->getPost('passwd', 'string', NULL );
            $confirm_passwd                     = $this->request->getPost('confirm_passwd', 'string', NULL );

            if( $passwd === $confirm_passwd )
            {
                $registration['passwd']          = $this->common->hashPasswd( $passwd );
                $registration['email']           = $this->session->get('customer_email');

                if( $this->models->getCustomers()->finishRegistration( $registration ) )
                {
                    $this->flash->success( $this->languages->getTranslation()->_("success_message") );
                    return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name ]);
                }
            }

        }

        $this->view->setVars([
            'no_robots'         => 1
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function registrationCancelAction()
    {

    }

    ///////////////////////////////////////////////////////////////////////////

    public function cabinetAction(  )
    {
        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name ]);
        }

        $customer   = $this->models->getCustomers()->getCustomer( $this->session->get('id') );
        $orders     = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );

        $month_names = $this->languages->getTranslation()->_("month_list");

        if( $this->request->isPost() )
        {
            $customer_edit['id']                = $this->session->get('id');
            $customer_edit['name']              = $this->request->getPost('order_name', 'string', NULL );
            $customer_edit['email']              = $this->request->getPost('order_email', 'string', NULL );
            $customer_edit['phone']             = $this->request->getPost('order_phone', 'string', NULL );
            $customer_edit['city']              = $this->request->getPost('order_city', 'string', NULL );
            $order_passwd_new           = 			$this->request->getPost('order_passwd_new', 'string', NULL );
            $order_passwd           = 			$this->request->getPost('order_passwd', 'string', NULL );
            $customer_edit['passwd'] = (strlen($order_passwd_new)>0) ? $this->common->hashPasswd($order_passwd_new) : $order_passwd;
            $customer_edit['users_group_id'] = $this->request->getPost('users_group_id', 'string', NULL );

            /*foreach( $customer_edit as $o )
            {
                if( strlen($o) == 0 )
                {
                    $err = 1;
                }
            }
            */
            $customer_edit['address']           = $this->request->getPost('order_address', 'string', NULL );
            $customer_edit['email']             = $this->request->getPost('order_email', 'email', NULL );

            $year   = $this->request->getPost('date_birth_year', 'int', '1970' );
            $month  = $this->request->getPost('date_birth_month', 'int', '1970' );
            $day    = $this->request->getPost('date_birth_day', 'int', '1970' );

            $customer_edit['birth_date'] =
                !empty( $year ) && !empty( $month ) && !empty( $day )
                    ?
                    $year.'-'.$month.'-'.$day
                    :
                    NULL;
            $customer_edit_get_info             = $this->request->getPost('order_get_info', 'string', NULL );
            $customer_edit['subscribed']        = empty( $customer_edit_get_info ) ? 0 : 1;

            if( $this->models->getCustomers()->editCustomer( $customer_edit ) )
            {
                $this->flash->success( $this->languages->getTranslation()->_("successfully_changed_your_profile") );
                $this->session->set('users_group_id', $customer_edit['users_group_id']);
                return $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
            else
            {

                $this->flash->error( $this->languages->getTranslation()->_("editing_profile_error") );
            }

        }
        $lang_url = $this->seoUrl->getChangeLangUrl();

        $this->view->setVars([
            'customer'        => $customer['0'],
            'month_names'     => $month_names,
            'orders'          => $orders,
            'change_lang_url' => $lang_url
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////

    public function listOrdersAction( $order_id )
    {
        $this->lang_name = $this->seoUrl->getLangName();
        $params = $this->dispatcher->getParams();
        $order_id = $params['order_id'];

        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name  ]);
        }

        $orders     = $this->models->getOrders()->getOrdersByCustomerId( $this->session->get('id') );
        $order      = $this->models->getOrders()->getOrdersByOrderId( $order_id, $this->lang_id );

        $orders_with_id = [];

        $month_names = $this->languages->getTranslation()->_("second_month_list");

        if( !empty( $orders ) )
        {
            foreach( $orders as $o )
            {
                if( $o['id'] == $order_id )
                {
                    $orders_with_id['date'] =
                        date('d', strtotime($o['created_date'])).' '.
                        $month_names[date('m', strtotime($o['created_date']))-1].' '.
                        date('Y', strtotime($o['created_date']));

                    $orders_with_id['delivery'] = \config::get( 'global#delivery/'.$this->lang_id.'/'.$o['delivery'] );
                    $orders_with_id['status']   = \config::get( 'global#status/'.$this->lang_id.'/'.$o['status'] );
                }
            }
        }

        $total_count = 0;

        if( !empty( $order ) )
        {
            foreach( $order as $k => $o )
            {
                $order[$k]['link']          = $this->url->get([ 'for' => 'item', 'type' => $o['type_alias'], 'subtype' => $o['subtype_alias'], 'group_alias' => $o['group_alias'], 'item_id' => $o['item_id'] ]);
                $order[$k]['image']         = !empty( $o['cover'] ) ? $this->storage->getPhotoUrl( $o['cover'], 'avatar', '200x' ) : '/images/packet.jpg';
                $order[$k]['total_count']   = $o['price2']*$o['item_count'];

                $total_count += $o['price2']*$o['item_count'];
            }
        }

        $this->view->setVars([
            'order'             => $order,
            'orders'            => $orders,
            'order_id'          => $order_id,
            'orders_with_id'    => $orders_with_id,
            'total_count'       => $total_count
        ]);

    }

    ///////////////////////////////////////////////////////////////////////////

    public function changeCustomerPasswdAction(  )
    {
        if( !$this->session->get('isAuth') )
        {
            return $this->response->redirect([ 'for' => 'customer_login', 'language' => $this->lang_name  ]);
        }

        if( $this->request->isPost() )
        {
            $customer_edit_passwd['id'] = $this->session->get('id');
            $previous_passwd            = $this->request->getPost('previous_passwd', 'string', NULL );
            $passwd                     = $this->request->getPost('passwd', 'string', NULL );
            $confirm_passwd             = $this->request->getPost('confirm_passwd', 'string', NULL );

            if( $confirm_passwd === $passwd )
            {
                $customer_edit_passwd['previous_passwd']  = $this->common->hashPasswd( $previous_passwd );
                $customer_edit_passwd['passwd']           = $this->common->hashPasswd( $passwd );

                switch( $this->models->getCustomers()->editCustomerPasswd( $customer_edit_passwd ) )
                {
                    case 1:
                        // OK
                        // redirect
                        $this->flash->success( $this->t->_("successfully_changed_your_password") );
                        return $this->response->redirect([ 'for' => 'cabinet', 'language' => $this->lang_name  ]);
                        break;

                    case -1:
                    default:
                        $this->flash->error($this->t->_("wrong_previous_password"));
                        return $this->response->redirect([ 'for' => 'change_customer_passwd' , 'language' => $this->lang_name ]);
                        break;

                }

            } else {
                $this->flash->error($this->t->_("password_mismatch"));
            }
        }

        $this->view->setVars([
            'no_robots'         => 1

        ]);
    }

    ///////////////////////////////////////////////////////////////////////////
}