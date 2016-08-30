<?php

/**
 * userActions
 *
 * @subpackage  user
 * @author		Roman
 */
class userActions extends sfActions
{
    /////////////////////////////////////////////////////////////////////////////

    /**
     *
     * @author		Roman
     */
    public function executeUserSocial(sfWebRequest $request)
    {
        ///////////////////////////////////////////////////////////////////////
    
    	$mechanism = preg_replace( '/[^a-z\_]/', '', $request->getParameter('mechanism', '') );
    	
        ///////////////////////////////////////////////////////////////////////
    	
    	if( user::isAuth() )
    	{ 
    		user::logout();
    	}
    	
        ///////////////////////////////////////////////////////////////////////
        
        $data = socialAuth::login( $mechanism );

        ///////////////////////////////////////////////////////////////////////
        
        if( !empty($data) )
        {
            // login user
            if( user::loginSocial($data) )
            {
                // redirect to previous location
                user::historyRedirect();
                die();
            }
        }

        ///////////////////////////////////////////////////////////////////////        
 
        $this->redirect( '@user_login' );
    }

    /////////////////////////////////////////////////////////////////////////////

    /**
     *
     * @author		Roman
     */
    public function executeUserConfirm(sfWebRequest $request)
    {
        if( user::isAuth() )
        {
            $this->redirect( '@homepage' );
        }

        $hash = preg_replace( '/[^0-9abcdef]/', '', $request->getParameter('hash', '') );

        if( strlen($hash)<=32 )
        {
            $this->redirect( '@user_login?confirm=2' );
        }

        $confirm_hash   = substr( $hash, 0, 32 );
        $user_id        = intval( substr( $hash, 32 ) );

        if( empty($user_id) )
        {
            $this->redirect( '@user_login?confirm=2' );
        }

        $db = db::AutoExecute(
            'sp_user_update_confirm',
            array(
                'user_id'   => $user_id,
                'confirm'   => $confirm_hash,
            ),
            -1, 0
        );

        if( !isset($db['error']) && isset($db['data']['1']) && !empty($db['data']['1']) )
        {
            // ALL OK

            $_SESSION['user']['confirm'] = array(
                'id'        => $user_id,
                'login'     => $db['data']['1']['login'],
                'name'      => $db['data']['1']['name'],
                'email'     => $db['data']['1']['email'],
            );

            $this->redirect( '@user_login?confirm=1&rnd='.md5(uniqid('',true)) );
        }
        else
        {
            switch( $db['error'] )
            {
                case 403:       // already confirmed
                    $this->redirect( '@user_login?confirm=3&rnd='.md5(uniqid('',true)) );
                    break;

                case 404:       // user not found
                    $this->redirect( '@user_login?confirm=2&rnd='.md5(uniqid('',true)) );
                    break;

                case 405:       // incorrect confirm key
                    $this->redirect( '@user_login?confirm=2&rnd='.md5(uniqid('',true)) );
                    break;

                default:
                    $this->redirect( '@user_login?confirm=0&rnd='.md5(uniqid('',true)) );
                    break;
            }
        }

        $this->redirect( '@homepage' );
    }

    /////////////////////////////////////////////////////////////////////////////

    /**
     *
     * @author		Roman
     */
    public function executeUserLogout(sfWebRequest $request)
    {
    	if( user::isAuth() )
    	{ 
    		user::logout();
    		
    		// TODO:
            /*
            setcookie("oauth_token", '', time()-100);
            setcookie("oauth_token_secret", '', time()-100);
            */
    	}

        user::historyRedirect();
        
        $this->redirect( '@homepage' );
    }
    
    /////////////////////////////////////////////////////////////////////////////    
}

