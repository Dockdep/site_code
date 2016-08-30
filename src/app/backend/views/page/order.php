<div id="orders">
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">

                    <?= $this->partial('partial/sidebar') ?>

                    <div class="order_menu float">
                        <div class="clearfix">
                            <ul class="order_menu_name">
                                <li>Меню заказов</li>
                            </ul>
                            <ul>
                                <li class="order_menu_title clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа">Статус заказа</a></li>
                                <li class="order_menu_list active status_new clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="color_1 float">Новый</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['1'] ) && !empty( $status['1'] ) ? $status['1'] : 0) ?></a>
                                </li>
                                <li class="order_menu_list status_ok clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 2 ]) ?>" title="Статус заказа: Обработанный" class="color_2 float">Обработанный</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['2'] ) && !empty( $status['2'] ) ? $status['2'] : 0) ?></a>
                                </li>
                                <li class="order_menu_list status_done clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 3 ]) ?>" title="Статус заказа: Выполнен" class="color_3 float">Выполнен</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['3'] ) && !empty( $status['3'] ) ? $status['3'] : 0) ?></a>
                                </li>
                                <li class="order_menu_list status_postponed clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 4 ]) ?>" title="Статус заказа: Отложен" class="color_4 float">Отложен</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['4'] ) && !empty( $status['4'] ) ? $status['4'] : 0) ?></a>
                                </li>
                                <li class="order_menu_list status_canceled clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 5 ]) ?>" title="Статус заказа: Отменен" class="color_5 float">Отменен</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['5'] ) && !empty( $status['5'] ) ? $status['5'] : 0) ?></a>
                                </li>
                                <li class="order_menu_list status_return clearfix">
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 6 ]) ?>" title="Статус заказа: Возврат" class="color_6 float">Возврат</a>
                                    <a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status', 'sort_id' => 1 ]) ?>" title="Статус заказа: Новый" class="without_background float_right"><?= (isset( $status['6'] ) && !empty( $status['6'] ) ? $status['6'] : 0) ?></a>
                                </li>
                            </ul>
                            <ul>
                                <li class="order_menu_title clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status_pay', 'sort_id' => 1 ]) ?>"                  title="Статус оплаты">Статус оплаты</a></li>
                                <li class="order_menu_list status_paid clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status_pay', 'sort_id' => 1 ]) ?>"       title="Статус оплаты: Оплачен">Оплачен</a></li>
                                <li class="order_menu_list status_not_paid clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'status_pay', 'sort_id' => 2 ]) ?>"   title="Статус оплаты: Неоплачен">Неоплачен</a></li>
                            </ul>
                            <ul>
                                <li class="order_menu_title clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'pay', 'sort_id' => 1 ]) ?>"         title="Способ оплаты">Способ оплаты</a></li>
                                <li class="order_menu_list cash clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'pay', 'sort_id' => 1 ]) ?>"     title="Способ оплаты: Наличный">Наличный</a></li>
                                <li class="order_menu_list cashless clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'pay', 'sort_id' => 2 ]) ?>" title="Способ оплаты: Безналичный">Безналичный</a></li>
                            </ul>
                            <ul>
                                <li class="order_menu_title clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 1 ]) ?>"            title="Доставка">Доставка</a></li>
                                <li class="order_menu_list pickup clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 1 ]) ?>"     title="">Самовывоз</a></li>
                                <li class="order_menu_list courier clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 2 ]) ?>"      title="">Курьером по Киеву</a></li>
                                <li class="order_menu_list novaposhta clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 3 ]) ?>"  title="">Новая почта (склад)</a></li>
                                <li class="order_menu_list novaposhta clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 4 ]) ?>"  title="">Новая почта (курьером)</a></li>
                                <li class="order_menu_list novaposhta clearfix"><a href="<?= $this->url->get([ 'for' => 'admin_orders_sorted', 'sort_type' => 'delivery', 'sort_id' => 5 ]) ?>"  title="">Служба перевозки</a></li>

                                <li class="order_menu_list all_orders"><a href="<?= $this->url->get([ 'for' => 'admin_orders' ]) ?>" title="Все заказы">Все заказы</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="h_700">
                    <div class="content_wrapper_list clearfix">
                        <div class="table_name header_gradient">Заказы</div>
                        <!--<div class="table_search header_gradient clearfix">
                            <div class="float"><input type="text" name="" value="поиск" /></div>
                            <div class="float"><input type="text" name="" value="код товара" /></div>
                            <div class="float"><input type="text" name="" value="менеджер" /></div>
                            <div class="float"><input type="text" name="" value="" /></div>
                            <div class="float"><input type="text" name="" value="" /></div>
                            <div class="float"><input type="submit" value="Поиск" class="table_search_search" /></div>
                        </div>-->
                        <div class="table_checked"></div>


                        <?php

                        if( !empty( $orders ) )
                        {
                            $data_orders =
                                '<div class="table_wrapper">
                                    <table>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>№</th>
                                            <th>Дата</th>
                                            <th>ФИО</th>
                                            <th>Телефон</th>
                                            <th>Сумма</th>
                                            <th>Комментарий</th>
                                            <th>Статус</th>
                                            <th>Оплата</th>
                                            <th class="last_cell">Доставка</th>
                                        </tr>';

                            foreach( $orders as $k => $v )
                            {
                                $data_orders .=
                                    '<tr class="'.( $k%2 == 0 ? 'even' : 'odd' ).'">'.
                                        '<td><input type="checkbox" id="compare_order_'.$v['id'].'" value="'.$v['id'].'" /><label for="compare_order_'.$v['id'].'"><span></span></label></td>'.
                                        '<td><a href="#" class="color_'.$v['status'].'" title="">'.$v['id'].'</td>'.
                                        '<td>'.date( 'd.m.Y', strtotime($v['created_date']) ).'</td>'.
                                        '<td class="w_50">'.$v['name'].'</td>'.
                                        '<td>'.$v['phone'].'</td>'.
                                        '<td>'.$v['sum'].'</td>'.
                                        '<td class="w_50">'.$v['comments'].'</td>'.
                                        '<td>'.
                                            '<select>'.
                                                '<option value="1" '.( $v['status'] == 1 ? 'selected="selected"' : '' ).'>Новый</option>'.
                                                '<option value="2" '.( $v['status'] == 2 ? 'selected="selected"' : '' ).'>Обработанный</option>'.
                                                '<option value="3" '.( $v['status'] == 3 ? 'selected="selected"' : '' ).'>Выполнен</option>'.
                                                '<option value="4" '.( $v['status'] == 4 ? 'selected="selected"' : '' ).'>Отложен</option>'.
                                                '<option value="5" '.( $v['status'] == 5 ? 'selected="selected"' : '' ).'>Отменен</option>'.
                                                '<option value="6" '.( $v['status'] == 6 ? 'selected="selected"' : '' ).'>Возврат</option>'.
                                            '</select>'.
                                        '</td>'.
                                        '<td>'.
                                            '<select>'.
                                                '<option value="1" '.( $v['status_pay'] == 1 ? 'selected="selected"' : '' ).'>Оплачен</option>'.
                                                '<option value="2" '.( $v['status_pay'] == 2 ? 'selected="selected"' : '' ).'>Не оплачен</option>'.
                                            '</select>'.
                                        '</td>'.
                                        '<td class="last_cell">'.$v['delivery_val'].'</td>'.
                                    '</tr>';
                            }

                            $data_orders .= '</table></div>';
                        }
                        else
                        {
                            $data_orders = '<div class="table_wrapper"><p class="table_empty_orders">По выбранной категории нет заказов</p></div>';
                        }

                        echo( $data_orders );

                        ?>

                    </div>
                </div>

                <?php

                if( $total > \config::get( 'limits/admin_orders') )
                {
                    echo('<div class="inner"><div class="paginate">');
                    $this->common->adminPaginate(
                        [
                            'page'              => $page,
                            'items_per_page'    => \config::get( 'limits/admin_orders', 5),
                            'total_items'       => $total,
                            'url_for'           => [ 'for' => 'admin_orders_paginate', 'page' => $page ],
                        ]
                    );
                    echo('</div></div>');
                }

                ?>

            </div>

        </div>
    </div>
</div>
 