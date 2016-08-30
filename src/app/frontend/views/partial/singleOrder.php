<div class="order-header" style="width: 950px">
    <h2 style="display: inline-block" class="content-header">
        <?= $t->_('orders').' №'.$order_id ?>
    </h2>
    <div style="display: inline-block; float: right; margin: 15px 10px 0px;">
        <a href="#" class="print_but">
            <img style="position: relative; top: 3px" src="/images/print.png" border="0">
            <?= $t->_('print_version') ?>
        </a>
    </div>
</div>
<section style="overflow: visible" class="content">
    <table border="0" cellpadding="0" cellspacing="0" class="mnblock_table_one">
        <tr align="center">
            <td align="left" class="td_brdbtm titles"><?= $t->_('name') ?></td>
            <td class="td_brdbtm titles"><?= $t->_('packing') ?></td>
            <td class="td_brdbtm titles w120"><?= $t->_('cost_per_unit') ?></td>
            <td class="td_brdbtm titles"><?= $t->_('number_of') ?></td>
            <td class="td_brdbtm titles"></td>
            <td class="td_brdbtm titles w120"><?= $t->_('cost') ?></td>
            <td class="td_brdbtm titles w199"></td>
        </tr>
        <?php foreach($order['groups'] as $g): ?>
        <tr>
            <td class="group_items" colspan="5">
                <a style="text-decoration: none;" href="<?= $this->seoUrl->setUrl($g['full_alias']) ?>" title="<?= $g['title'] ?>"><?= $g['title'] ?></a>
            </td>
        </tr>
        <?php foreach($g['items'] as $i): ?>
            <tr align="center">
                <td align="left" class="td_brdbtm">
                    <div style="padding-left: 50px" class="tovar_block">
                        <div class="tovar_bl">
                            <a style="text-decoration: none; display: inline" href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="<?= $i['title'] ?>">
                                <img width="45px" height="40px" src="<?= $i['cover'] ?>">
                            </a>
                        </div>
                        <div class="tovar_bl">
                            <a style="text-decoration: none; display: inline" href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="<?= $i['title'] ?>">
                            <?= $i['title'] ?>
                            </a>
                        </div>
                    </div>
                </td>
                <td class="td_brdbtm cell">
                    <a style="left: 20px; text-align: start;" href="#" class="group_sizes active">
                        <span class="group_sizes_header"></span>
                        <span class="group_sizes_content"><?= $i['size'] ?></span>
                    </a>
                </td>
                <td class="price td_brdbtm cell"><span><?= $i['price2'] ?></span> грн.</td>
                <td class="td_brdbtm cell"><span class="bold18"><?= $i['item_count'] ?></span></td>
                <td class="td_brdbtm cell">
                    <a href="#">
                        <?php if(!empty($i['firm']) && $i['firm']): ?>
                            <img src="/images/minilogo.png">
                        <?php endif; ?>
                    </a>
                </td>
                <td class="price td_brdbtm cell greytd"><span><?= $i['price2'] * $i['item_count'] ?></span> грн.</td>
                <td class="td_brdbtm cell"><a data-item_id="<?= $i['item_id'] ?>" data-group_id="<?= $i['group_id'] ?>" href="#" class="green_but buy"><?= $t->_('add_to_order') ?></a></td>
            </tr>
        <?php endforeach; ?>
        <?php endforeach; ?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><span><?= $t->_('total') ?>:</span></td>
                <td style="text-align: center" class="price td_brdbtm cell greytd"><span><?= $order['total_price'] ?></span> грн.</td>
                <td></td>
            </tr>
    </table>
</section>
