<div id="orders">
    <div class="inner"><?= $this->flash->output(); ?></div>
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">
                    <?= $this->partial('partial/sidebar') ?>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="content_wrapper_list clearfix">
                    <div class="table_name header_gradient">Статистика</div>
                    <div class="table_wrapper">
                        <table>
                                <tr>
                                    <th >#</th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_more_info', 'id' => 'name' ]) ?>" >Название</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'date' ]) ?>" >Дата</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'campaign' ]) ?>" >Campaign</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'total' ]) ?>" >Отправлено</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'delivered' ]) ?>" >Доставленные</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'ok_read' ]) ?>" >Открытые</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'ok_link_visited' ]) ?>" >Переходов</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'ok_fbl' ]) ?>" >Спам</a></th>
                                    <th ><a href="<? $this->url->get([ 'for' => 'delivery_sort_info', 'id' => 'ok_unsubscribed' ]) ?>" >Отписавшихся</a></th>
                                    <th class="table-buttons"></th>
                                </tr>

                        <?php if( !empty( $info ) ) :?>
                            <?php foreach ($info as $item):?>
                                <tr>
                                    <td><?= $item['campaign_id']; ?></td>
                                    <td><?= $item['name']; ?></td>
                                    <td class="date"><?= $item['date']; ?></td>
                                    <td><?= $item['campaign']; ?></td>
                                    <td><?= $item['total']; ?></td>
                                    <td><?= !empty($item['delivered']) ? $item['delivered'].'%' : '' ?></td>
                                    <td><?= !empty($item['ok_read']) ? $item['ok_read'].'%' : ''; ?></td>
                                    <td><?= !empty($item['ok_link_visited']) ? $item['ok_link_visited'].'%' : ''; ?></td>
                                    <td><?= !empty($item['ok_fbl']) ? $item['ok_fbl'].'%' : ''; ?></td>
                                    <td><?= !empty($item['ok_unsubscribed']) ? $item['ok_unsubscribed'].'%' : ''; ?></td>
                                    <td>
                                        <a class="news_submit float" href="<?= $this->url->get([ 'for' => 'delivery_update', 'id' => $item['campaign_id'] ]) ?>" title="Обновить данные">Обновить</a>
                                        <a class="news_submit float" href="<?= $this->url->get([ 'for' => 'delivery_more_info', 'id' => $item['campaign_id'] ]) ?>" title="Обновить данные">Подробнее</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif ?>
                        </table>
                    </div>
                </div>
                <div class="inner">
                    <div class="paginate">
                        <?=$paginate?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

