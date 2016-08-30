<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

namespace
{
    /**
     * models
     *
     * @author      Roman Telychko
     * @version     0.1.20130712
     */
    class models extends \db
    {
        /////////////////////////////////////////////////////////////////////////////

        protected   $_filters                       = false;
        protected   $_items                         = false;
        protected   $_properties                    = false;
        protected   $_orders                        = false;
        protected   $_pages                         = false;
        protected   $_news                          = false;
        protected   $_customers                     = false;
        protected   $_catalog                       = false;
        protected   $_admins                        = false;
        protected   $_partners                      = false;
        protected   $_callback                      = false;
        protected   $_seo_info                      = false;
        protected   $_slider                        = false;
        protected   $_navigation                    = false;
        protected   $_users_groups                  = false;
        protected   $_email_templates               = false;
        protected   $_event_email                   = false;
        protected   $_campaign                      = false;
        protected   $_admin_email                   = false;
        protected   $_admin_email_sections          = false;
        protected   $_delivery                      = false;
        protected   $_delivery_email                = false;
		protected   $_rubrics_news					= false;
        protected   $_email_settings    			= false;
        protected   $_special_users                 = false;
        protected   $_prices                        = false;
        protected   $_actions                       = false;
        protected   $_preorders                     = false;
        protected   $_banner                        = false;
        protected   $_customer_ideas                = false;
        protected   $_promo_codes                   = false;
        protected   $_payment                       = false;
        protected   $_sales                         = false;
        protected   $_reviews                       = false;
        protected   $_modal                         = false;
        protected   $_manager_mail                  = false;



        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getFilters
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140321
         *
         * @return    	obj
         */
        public function getFilters()
        {
            if( empty($this->_language) )
            {
                $this->_filters = new \models\filters();
                $this->_filters->setDi( $this->getDi() );
            }

            return $this->_filters;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getItems
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140327
         *
         * @return    	obj
         */
        public function getItems()
        {
            if( empty($this->_items) )
            {
                $this->_items = new \models\items();
                $this->_items->setDi( $this->getDi() );
            }

            return $this->_items;
        }
        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getRubricsNews
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140327
         *
         * @return    	obj
         */
        public function getRubricsNews()
        {
            if( empty($this->_rubrics_news) )
            {
                $this->_rubrics_news = new \models\RubricsNews();
                $this->_rubrics_news->setDi( $this->getDi() );
            }

            return $this->_rubrics_news;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getProperties
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140404
         *
         * @return    	obj
         */
        public function getProperties()
        {
            if( empty($this->_properties) )
            {
                $this->_properties = new \models\properties();
                $this->_properties->setDi( $this->getDi() );
            }

            return $this->_properties;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getOrders
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140422
         *
         * @return    	obj
         */
        public function getOrders()
        {
            if( empty($this->_orders) )
            {
                $this->_orders = new \models\orders();
                $this->_orders->setDi( $this->getDi() );
            }

            return $this->_orders;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getPages
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140423
         *
         * @return    	obj
         */
        public function getPages()
        {
            if( empty($this->_pages) )
            {
                $this->_pages = new \models\pages();
                $this->_pages->setDi( $this->getDi() );
            }

            return $this->_pages;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getNews
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140423
         *
         * @return    	obj
         */
        public function getNews()
        {
            if( empty($this->_news) )
            {
                $this->_news = new \models\news();
                $this->_news->setDi( $this->getDi() );
            }

            return $this->_news;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getCustomers
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140425
         *
         * @return    	obj
         */
        public function getCustomers()
        {
            if( empty($this->_customers) )
            {
                $this->_customers = new \models\customers();
                $this->_customers->setDi( $this->getDi() );
            }

            return $this->_customers;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getCatalog
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140428
         *
         * @return    	obj
         */
        public function getCatalog()
        {
            if( empty($this->_catalog) )
            {
                $this->_catalog = new \models\catalog();
                $this->_catalog->setDi( $this->getDi() );
            }

            return $this->_catalog;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getAdmins
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140505
         *
         * @return    	obj
         */
        public function getAdmins()
        {
            if( empty($this->_admins) )
            {
                $this->_admins = new \models\admins();
                $this->_admins->setDi( $this->getDi() );
            }

            return $this->_admins;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getPartners
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140506
         *
         * @return    	obj
         */
        public function getPartners()
        {
            if( empty($this->_partners) )
            {
                $this->_partners = new \models\partners();
                $this->_partners->setDi( $this->getDi() );
            }

            return $this->_partners;
        }

        /////////////////////////////////////////////////////////////////////////////

        /**
         * models::getCallback
         *
         * @author      Jane Bezmaternykh
         * @version     0.1.20140507
         *
         * @return    	obj
         */
        public function getCallback()
        {
            if( empty($this->_callback) )
            {
                $this->_callback = new \models\callback();
                $this->_callback->setDi( $this->getDi() );
            }

            return $this->_callback;
        }
        ////////////////////////////////////////////////////////////////////////////
        /**
         * models::getSeoInfo
         *
         * @author      Vitaliy
         * @version     0.1.20140507
         *
         * @return    	obj
         */
        public function getSeoInfo()
        {
            if( empty($this->_seo_info) )
            {
                $this->_seo_info = new \models\seo_info();
                $this->_seo_info->setDi( $this->getDi() );
            }

            return $this->_seo_info;
        }

        /////////////////////////////////////////////////////////////////////////////

        public function getSlider()
        {
            if( empty($this->_slider) )
            {
                $this->_slider = new \models\slider();
                $this->_slider->setDi( $this->getDi() );
            }

            return $this->_slider;
        }
        ////////////////////////////////////////////////////////////////////////////////
        public function getNavigation()
        {
            if( empty($this->_navigation) )
            {
                $this->_navigation = new \models\navigation();
                $this->_navigation->setDi( $this->getDi() );
            }

            return $this->_navigation;
        }

        ////////////////////////////////////////////////////////////////////////////////
        public function getUsersGroup()
        {
            if( empty($this->_users_groups) )
            {
                $this->_users_groups = new \models\users_groups();
                $this->_users_groups->setDi( $this->getDi() );
            }

            return $this->_users_groups;
        }

        public function getSpecialUsers()
        {
            if( empty($this->_special_users) )
            {
                $this->_special_users = new \models\special_users();
                $this->_special_users->setDi( $this->getDi() );
            }

            return $this->_special_users;
        }

        public function getPrices()
        {
            if( empty($this->_prices) )
            {
                $this->_prices = new \models\prices();
                $this->_prices->setDi( $this->getDi() );
            }

            return $this->_prices;
        }

        public function getActions()
        {
            if( empty($this->_actions))
            {
                $this->_actions = new \models\actions();
                $this->_actions->setDi($this->getDi());
            }

            return $this->_actions;
        }

        public function getPreOrders()
        {
            if( empty($this->_preorders))
            {
                $this->_preorders = new \models\preorders();
                $this->_preorders->setDi($this->getDi());
            }

            return $this->_preorders;
        }

        ////////////////////////////////////////////////////////////////////////////////
        public function getEmailTemplates()
        {
            if( empty($this->_email_templates) )
            {
                $this->_email_templates = new \models\email_templates();
                $this->_email_templates->setDi( $this->getDi() );
            }

            return $this->_email_templates;
        }

        ////////////////////////////////////////////////////////////////////////////////
        public function getEventEmail()
        {
            if( empty($this->_event_email) )
            {
                $this->_event_email = new \models\event_email();
                $this->_event_email->setDi( $this->getDi() );
            }

            return $this->_event_email;
        }

        public function getCampaign()
        {
            if( empty($this->_campaign) )
            {
                $this->_campaign = new \models\campaign();
                $this->_campaign->setDi( $this->getDi() );
            }

            return $this->_campaign;
        }

        public function getAdminEmail()
        {
            if( empty($this->_admin_email) )
            {
                $this->_admin_email = new \models\admin_email();
                $this->_admin_email->setDi( $this->getDi() );
            }

            return $this->_admin_email;
        }

        public function getAdminEmailSections()
        {

            if( empty($this->_admin_email_sections) )
            {
                $this->_admin_email_sections = new \models\admin_email_sections();
                $this->_admin_email_sections->setDi( $this->getDi() );
            }

            return $this->_admin_email_sections;
        }

        public function getDelivery()
        {

            if( empty($this->_delivery) )
            {
                $this->_delivery = new \models\delivery();
                $this->_delivery->setDi( $this->getDi() );
            }

            return $this->_delivery;
        }

        public function getDeliveryEmail()
        {

            if( empty($this->_delivery_email) )
            {
                $this->_delivery_email = new \models\delivery_email();
                $this->_delivery_email->setDi( $this->getDi() );
            }

            return $this->_delivery_email;
        }
        public function getEmailSettings()
        {

            if( empty($this->_email_settings) )
            {
                $this->_email_settings = new \models\email_settings();
                $this->_email_settings->setDi( $this->getDi() );
            }

            return $this->_email_settings;
        }

        public function getBanner()
        {

            if( empty($this->_banner) )
            {
                $this->_banner = new \models\banner();
                $this->_banner->setDi( $this->getDi() );
            }

            return $this->_banner;
        }

        public function getCustomerIdeas()
        {
            if( empty($this->_customer_ideas) )
            {
                $this->_customer_ideas = new \models\customer_ideas();
                $this->_customer_ideas->setDi( $this->getDi() );
            }

            return $this->_customer_ideas;
        }

        public function getPromoCodes()
        {
            if( empty($this->_promo_codes) )
            {
                $this->_promo_codes = new \models\promo_codes();
                $this->_promo_codes->setDi( $this->getDi() );
            }

            return $this->_promo_codes;
        }

        public function getPayment()
        {
            if( empty($this->_payment) )
            {
                $this->_payment = new \models\payment();
                $this->_payment->setDi( $this->getDi() );
            }

            return $this->_payment;
        }

        public function getSales()
        {
            if( empty($this->_sales) )
            {
                $this->_sales = new \models\sales();
                $this->_sales->setDi( $this->getDi() );
            }

            return $this->_sales;
        }

        public function getReviews()
        {
            if( empty($this->_reviews) )
            {
                $this->_reviews = new \models\reviews();
                $this->_reviews->setDi( $this->getDi() );
            }

            return $this->_reviews;
        }
        public function getModal()
        {
            if( empty($this->_modal) )
            {
                $this->_modal = new \models\modal();
                $this->_modal->setDi( $this->getDi() );
            }

            return $this->_modal;
        }

        public function getManagerMail()
        {
            if( empty($this->_manager_mail) )
            {
                $this->_manager_mail = new \models\manager_mail();
                $this->_manager_mail->setDi( $this->getDi() );
            }

            return $this->_manager_mail;
        }
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
