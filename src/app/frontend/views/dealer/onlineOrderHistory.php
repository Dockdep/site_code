<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<?php if(!empty($orders)): ?>
    <table border="0" cellpadding="0" cellspacing="0" id="history_zakaz">
        <tr>
            <td width="150"><?= $t->_('order_number') ?></td>
            <td id="greytd" align="center"><?= $t->_('status') ?></td>
            <td align="center" id="right_border"><?= $t->_('date') ?></td>
            <td align="center"><?= $t->_('sum') ?></td>
            <td id="greytd" width="40"></td>
        </tr>
        <?php foreach($orders as $o): ?>
        <tr>
            <td><a href="<?= $this->seoUrl->setUrl($this->router->getRewriteUri().'/'.$o['id']) ?>"><?= $t->_('orders') ?> №<?= $o['id'] ?></a></td>
            <td id="greytd" align="center">
                <li class="order_status <?= $o['status'][1] ?>"><?= $o['status'][0] ?></li>
            </td>
            <td align="center" id="right_border"><?= $o['created_date'] ?></td>
            <td align="center" class="status_price"><span id="price_sum"><?= $o['price'] ?></span> грн.</td>
            <td id="greytd" align="center">
                <iframe style="border: 0" width="20px" height="20px" src="<?= $this->seoUrl->setUrl($this->url->get([ 'for' => 'print_order' ]).$o['id']) ?>"></iframe>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</section>
