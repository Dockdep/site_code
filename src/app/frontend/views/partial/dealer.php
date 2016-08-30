<?php
    $in_cart = $this->session->get('in_cart', []);
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= $t->_('reconciliation') ?></h4>
            </div>
            <div class="modal-body">
                <form id="callback_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>" method="post" >
                    <div class="form-group">
                        <label for="DateReservation" class="sr-only">Дата</label>
                        <div class="input-group col-sm-10">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input placeholder="Дата" type="text" name="date" class="form-control" id="DateReservation">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="sr-only">Email</label>
                        <div class="input-group col-sm-10">
                            <div class="input-group-addon">@</div>
                            <input type="email"  name="email" value="<?= !empty( $customer['email'] ) ? $customer['email'] : '' ?>" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone" class="sr-only">Телефон</label>
                        <div class="input-group col-sm-10">
                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                            <input type="text"  name="phone"  value="<?= !empty( $customer['phone'] ) ? $customer['phone'] : '' ?>"  class="form-control" id="inputPhone" placeholder="Телефон">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="sr-only"><?= $t->_('firstname') ?></label>
                        <div class="input-group col-sm-10">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" name="name"  value="<?= !empty( $customer['name'] ) ? $customer['name'] : '' ?>" class="form-control" id="Name" placeholder="<?= $t->_('firstname') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="comment"><?= $t->_('comment_text') ?></label>
                        <div class="input-group col-sm-10">
                            <textarea placeholder="<?= $t->_('comment_text') ?>" name="comments" id="comment" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class=" green_but"><?= $t->_('reconciliation') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <span class="logo-mini">
                <img style="max-width: 45px;" alt="Інтернет-магазин насіння" title="Магазин насіння Semena.in.ua" src="/images/logo.png">
            </span>
            <span class="logo-lg">
                <img alt="Інтернет-магазин насіння" title="Магазин насіння Semena.in.ua" src="/images/logo.png" width="260px" height="50px">
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <a style="float: left; padding: 16px 15px;" href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'index_dealer' ])) ?>">
                <img height="12px" src="/images/catalog.jpg">
                <span class="catalog_link">Каталог</span>
            </a>
            <a style="float: left; padding: 16px 15px; position:relative;" href="<?= $this->seoUrl->setUrl('/basket') ?>">
                <img src="/images/basket.png" style="height: 12px;margin-top: 2px;">
                <span class="catalog_link"><?= $t->_("your_cart")?></span>
                <span style="color: white;background: #67b73e;padding: 1px 5px;border-radius: 50%;font-size: 11px;box-shadow: inset 2px 1px 10px 0 #417e24;position: absolute;width: 16px;height: 16px;text-align: center;top: 17px;right: -8px;"><?= !empty( $in_cart ) ? count( $in_cart ) : '0' ?></span>
            </a>
            <div class="clearfix compare_wrapper">

                <?= !empty( $compare ) ? '<div class="compare"><a href="#" title="'.$t->_("comparison_list").'">'.$t->_("comparison_list").' '.$count.'</a></div>' : '' ?>

                <?php

                if( !empty( $compare_ ) )
                {
                    $data_compare =
                        '<div class="compare_list">'.
                        '<div class="compare"><a href="#" title="'.$t->_("comparison_list").'">'.$t->_("comparison_list").' '.$count.'</a></div>'.
                        '<ul>';
                    foreach( $compare_ as $comp )
                    {
                        foreach( $comp as $k => $c )
                        {
                            $data_compare .= '<li class="clearfix"><a href="'.$this->seoUrl->setUrl($c['url']).'" title="" class="float">'.$c['title'].' '.$c['count'].'</a><a href="'.$this->seoUrl->setUrl($c['url_del']).'" title="" class="float"><img src="/images/compare_del.jpg" alt="" height="8" width="8" /></a></li>';
                        }
                    }

                    $data_compare .= '</ul></div>';

                    echo( $data_compare );
                }

                ?>

            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <div style="display: inline-block;margin: 5px" class="site_search nav-search">
                            <form action="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'dealer_search_items' ])) ?>" method="get">
                                <div class="search_result_wrapper">
                                    <input type="text" name="search" id="search_item" value="<?= isset($search) && !empty($search) ? $search : '' ?>" class="ui-autocomplete-input" autocomplete="off"/>
                                    <label><img src="/images/search.png" alt="search" width="16" height="17" /></label>
                                    <div class="search_result_display" id="search_result_display">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= isset($customer['avatar'])
                                ? $this->storage->getPhotoUrl($customer['avatar'], 'dealers', '160x')  : \config::get('frontend#defaults/default_user_image') ?>" class="img-circle user-image" alt="User Image" />
                            <span class="hidden-xs"><?= !empty( $customer['name'] ) ? $customer['name'] : 'User' ?></span>
                        </a>
<ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
        <img src="<?= isset($customer['avatar'])
            ? $this->storage->getPhotoUrl($customer['avatar'], 'dealers', '160x') : \config::get('frontend#defaults/default_user_image') ?>" class="img-circle" alt="<?= !empty( $customer['name'] ) ? $customer['name'] : 'User' ?>"/>
        <p>
            <?= !empty( $customer['name'] ) ? $customer['name'] : 'User' ?>
            <small><?= !empty( $customer['email'] ) ? $customer['email'] : 'Email' ?></small>
        </p>
    </li>
    <!-- Menu Body -->
    <!-- Menu Footer-->
    <li class="user-footer">
        <div class="pull-left">
            <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'personal_data' ])) ?>" title="<?= $t->_("cabinet")?>" class="btn btn-default btn-flat"><?= $t->_('cabinet') ?></a>
        </div>
        <div class="pull-right">
            <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'customer_logout' ])) ?>" title="<?= $t->_("exit")?>" class="btn btn-default btn-flat"><?= $t->_('exit') ?></a>
        </div>
    </li>
</ul>
</li>
<!-- Control Sidebar Toggle Button -->
<li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
</li>
</ul>
</div>
</nav>
</header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= isset($customer['avatar'])
                    ? $this->storage->getPhotoUrl($customer['avatar'], 'dealers', '160x')
                    : \config::get('frontend#defaults/default_user_image') ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?= !empty( $customer['name'] ) ? $customer['name'] : 'User' ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>

        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'cart' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cart' ])) ?>">
                    <i class="fa fa-shopping-cart"></i> <span><?= $t->_('online_order'); ?></span>
                    <span class="count_cart"><?= $count_cart ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'wholesale_prices' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'wholesale_prices' ])) ?>">
                    <i class="fa fa-usd"></i> <span><?= $t->_('wholesale_prices'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'useful_materials' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'useful_materials' ])) ?>">
                    <i class="fa fa-book"></i> <span><?= $t->_('useful_materials'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'top_items' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'top_items' ])) ?>">
                    <i class="fa fa-star"></i> <span><?= $t->_('top_orders'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'recommended_items' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'recommended_items' ])) ?>">
                    <i class="fa fa-list-alt"></i> <span><?= $t->_('recommended_items'); ?></span></a>
            </li>
            <li class="<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'top_dealer_items' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'top_dealer_items' ])) ?>">
                    <i class="fa fa-star-o"></i> <span><?= $t->_('top_dealer_orders'); ?></span>
                </a>
            </li>
            <li class="<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'new_items' ])) !== false ? 'active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'new_items' ])) ?>">
                    <i class="fa fa-newspaper-o"></i> <span><?= $t->_('novelty'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'equipment' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get(['for' => 'equipment'])) ?>">
                    <i class="fa fa-laptop"></i> <span><?= $t->_('equipment'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'price_list' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'price_list' ])) ?>">
                    <i class="fa fa-files-o"></i> <span><?= $t->_('price_list'); ?></span>
                </a>
            </li>
            <li class="<?= strstr($_SERVER['REQUEST_URI'], 'financial') !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'financial_calculations' ])) ?>"><i class="fa fa-calculator"></i>
                    <span><?= $t->_('financial_calculations'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'personal_data' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'personal_data' ])) ?>">
                    <i class="fa fa-user"></i> <span><?= $t->_('personal_data'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'online_order_history' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'online_order_history' ])) ?>">
                    <i class="fa fa-history"> </i> <span><?= $t->_('online_order_history'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'shipment_history' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'shipment_history' ])) ?>">
                    <i class="fa fa-history"> </i> <span><?= $t->_('shipment_history'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'help' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'help' ])) ?>">
                    <i class="fa fa-question-circle"></i> <span><?= $t->_('help'); ?></span>
                </a>
            </li>
            <li class="treeview<?= strstr($_SERVER['REQUEST_URI'], $this->url->get([ 'for' => 'email_settings' ])) !== false ? ' active_tab' : '';  ?>">
                <a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'email_settings' ])) ?>">
                    <i class="fa fa-envelope"></i> <span><?= $t->_('email_preferences'); ?></span>
                </a>
            </li>
            <li class="treeview">
                <a href="<?= $this->storage->getOrderBlank() ?>">
                    <i class="fa fa-files-o"></i> <span><?= $t->_('order_blank'); ?></span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading"><?= $t->_('recent_order_status') ?></h3>
            <ul>
                <?php foreach($orders as $i => $o):
                if($i == 5) break; ?>
                <li style="color: #ffffff;" class="order_status_sidebar <?= $o['status'][1] ?>">
                    <a style="color: #ffffff; display: inline" href="<?= $this->seoUrl->setUrl('dealer/online_order_history/'.$o['id']) ?>"><?= $t->_('orders') ?> №<?= $o['id'] ?></a>
                    <br><?= $o['status'][0] ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <div>
                <h3 class="control-sidebar-heading"><?= $t->_('editing') ?></h3>
                <form id="edit_user_info_<?= ($lang_id == 1 ? 'ua' : 'ru') ?>"  method="post" action="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" name="edit_user_info">
                    <ul style="margin: 0" class="form clearfix">
                        <li class="clearfix align-center">
                            <div id="img_block">
                                <img width="160px" height="160px" src="<?= isset($customer['avatar'])
                                    ? $this->storage->getPhotoUrl($customer['avatar'], 'dealers', '160x') : \config::get('frontend#defaults/default_user_image') ?>" class="img-circle" alt="User Image">
                            </div>
                        </li>
                        <li class="clearfix align-center">
                            <div style="display: inline-block; width: auto" class="input">
                                <label id="btn_file" class="btn btn-default">
                                    <span><?= $t->_('load_photo') ?></span>
                                    <input class="fileupload" name="files[]"  type="file">
                                </label>
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_name"><?= $t->_("n_s")?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="order_name" id="order_name" class="name" value="<?= isset($customer['name']) && !empty($customer['name']) ? $customer['name'] : '' ?>"></div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_email">E-mail<span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="order_email" id="order_email" class="name" value="<?= isset($customer['email']) && !empty($customer['email']) ? $customer['email'] : '' ?>"></div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_psw"><?= $t->_("new_password") ?></label></div>
                            <div class="input float"><input type="password" name="order_passwd_new" id="order_psw" class="psw" value="" /><input type="hidden" name="order_passwd" value="<?= isset($customer['passwd']) && !empty($customer['passwd']) ? $customer['passwd'] : '' ?>"></div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_phone"><?= $t->_("m_phone")?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="order_phone" class="order_phone" class="name" value="<?= isset($customer['phone']) && !empty($customer['phone']) ? $customer['phone'] : '' ?>"></div>
                        </li>

                        <li class="clearfix">
                            <div class="label float"><label for="edit-date-birth"><?= $t->_("date_of_birth")?></label></div>
                            <div class="input float">
                                <select name="date_birth_day" class="form-text birth">
                                    <?php
                                    echo('<option value=""></option>');
                                    for( $i=1; $i<=31; $i++ )
                                    {
                                        echo(
                                            '<option value="'.( $i < 10 ? '0' : '' ).$i.'" '.
                                            (
                                            ( isset( $customer['birth_date'] ) )
                                                ?
                                                (
                                                ( $i == date( 'j', strtotime( $customer['birth_date'] ) ) )
                                                    ?
                                                    'selected="selected"'
                                                    :
                                                    ''
                                                )
                                                :
                                                ''
                                            ).'>'.$i.'</option>'
                                        );
                                    }
                                    ?>
                                </select>

                                <select name="date_birth_month"  class="form-text birth">
                                    <?php
                                    echo('<option value=""></option>');
                                    for( $i=1; $i<=12; $i++ )
                                    {
                                        echo(
                                            '<option value="'.( $i < 10 ? '0' : '' ).$i.'" '.
                                            (
                                            ( isset( $customer['birth_date'] ) )
                                                ?
                                                (
                                                ( $i == date( 'm', strtotime( $customer['birth_date'] ) ) )
                                                    ?
                                                    'selected="selected"'
                                                    :
                                                    ''
                                                )
                                                :
                                                ''
                                            ).'>'.$month_names[$i-1].'</option>'
                                        );
                                    }
                                    ?>
                                </select>

                                <select name="date_birth_year" class="form-text birth">
                                    <?php
                                    echo('<option value=""></option>');
                                    for( $i=date('Y')-90; $i<=date('Y')-18; $i++ )
                                    {
                                        echo(
                                            '<option value="'.$i.'" '.
                                            (
                                            ( isset( $customer['birth_date'] ) )
                                                ?
                                                ( $i == date( 'Y', strtotime( $customer['birth_date'] ) ) )
                                                    ?
                                                    'selected="selected"'
                                                    :
                                                    ''
                                                :
                                                ''
                                            ).'>'.$i.'</option>'
                                        );
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_city"><?= $t->_("city")?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="order_city" id="order_city" class="name" value="<?= isset($customer['city']) && !empty($customer['city']) ? $customer['city'] : '' ?>"></div>
                        </li>
                        <li class="clearfix">
                            <div class="label float"><label for="order_address"><?= $t->_("your_address") ?><span class="required">&#8727;</span></label></div>
                            <div class="input float"><input type="text" name="order_address" id="order_address" class="name" value="<?= isset($customer['address']) && !empty($customer['address']) ? $customer['address'] : '' ?>"></div>
                        </li>

                    </ul>
                    <div class="submit clearfix" style="margin-right: 23px;">
                        <input type="submit" value="<?= $t->_("save")?>" class="btn green float float_right">
                        <!--<a href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'cabinet' ])) ?>" class="float float_right"><?= $t->_("cancel") ?></a> -->
                    </div>
                    <!--<div class="submit clearfix">
                        <a style="font-size: 12px; margin: 25px 30px 0 0;" href="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'change_customer_passwd' ])) ?>" class="float float_right change_passwd"><?= $t->_('change_password')?></a>
                    </div>-->

                </form>
            </div>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>