<?php

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;

    class security extends Plugin
    {
        public function getAcl()
        {
            if (!isset($this->persistent->acl)) {

                $acl = new Phalcon\Acl\Adapter\Memory();

                $acl->setDefaultAction(Phalcon\Acl::DENY);

                //Register roles
                $roles = array(
                    "admin" => new Phalcon\Acl\Role('Admin'),
                    'guests' => new Phalcon\Acl\Role('Guests'),
                    'user' => new Phalcon\Acl\Role('User'),
                    'staff' => new Phalcon\Acl\Role('Staff')
                );
                foreach ($roles as $role) {
                    $acl->addRole($role);
                }

                //Private area resources
                $adminResources = array(
                    "seo"=>array("index")

                );

                foreach ($adminResources as $resource => $actions) {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }

                //Public area resources
                $publicResources = array(
                    'page' => array('index','login',"logout")
                );
                foreach ($publicResources as $resource => $actions) {
                    $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
                }

                //Grant access to public areas
                foreach ($roles as $role) {
                    foreach ($publicResources as $resource => $actions) {
                        $acl->allow($role->getName(), $resource, '*');
                    }
                }

                //Grant acess to private area to role Admin
                foreach ($adminResources as $resource => $actions) {
                    foreach ($actions as $action){
                        $acl->allow('Admin', $resource, $action);
                    }
                }

                //The acl is stored in session, APC would be useful here too
                $this->persistent->acl = $acl;
            }

            return $this->persistent->acl;
        }

        /**
         * This action is executed before execute any action in the application
         */
        public function check(Dispatcher $dispatcher)
        {

            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            $acl = $this->getAcl();
            if ($this->session->get("user-status")){
                $status = $this->session->get("user-status");
            } else {
                $status = 'Guests';
            }

            $allowed = $acl->isAllowed($status, $controller, $action);
            if ($allowed) {
                return true;
            } else {
                return false;
            }

        }

}