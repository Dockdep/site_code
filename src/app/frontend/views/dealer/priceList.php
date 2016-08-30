<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<table border="0" cellpadding="0" cellspacing="0" class="mnblock_table_one prices">
    <tr align="center">
        <td class="td_brdbtm w170 titles"><?= $t->_('name'); ?></td>
        <td class="greytd td_brdbtm w184 td_brdlft titles"><?= $t->_('price_format') ?></td>
        <td class="td_brdbtm td_brdlft w147 titles"><?= $t->_('update_date') ?></td>
        <td class="td_brdbtm td_brdlft w82 titles">Формат</td>
        <td class="td_brdbtm td_brdlft w199 titles"> </td>
    </tr>
    <?php foreach($prices as $p): ?>
    <tr align="center">
        <td class="td_brdbtm cell"><span><?= $p['name'] ?></span></td>
        <td class="greytd td_brdbtm td_brdlft cell"><div class="opt_status <?= $p['css'] ?> greytd"><?= $p['special_user'] ?></div></td>
        <td class="td_brdbtm td_brdlft cell"><?= $p['update_date'] ?></td>
        <td class="td_brdbtm td_brdlft cell"><img src="/images/xlsico.png"></td>
        <td class="td_brdbtm td_brdlft cell"><a href="<?= $p['file'] ?>" class="green_but"><?= $t->_('download') ?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
</section>