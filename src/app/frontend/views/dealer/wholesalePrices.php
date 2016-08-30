<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<table border="0" cellpadding="0" cellspacing="0" class="mnblock_table_one block930">
    <tr align="center">
        <?php for($i=0; $i < count($special_users); $i++): ?>
        <td class="<?= ($i % 2 != 0) ? 'greytd' : ''; ?> td_pdng_top20 td_pdng_btm20 td_brdbtm w232">
            <div class="opt_status <?= ($status == $special_users[$i]['status']) ? 'active_status' : ''; ?> <?= $special_users[$i]['css_class'] ?>"><?= $special_users[$i]['title'] ?></div>
        </td>
        <?php endfor; ?>
    </tr>
    <tr align="center">
        <?php for($i=0; $i < count($special_users); $i++): ?>
        <td class="<?= ($i % 2 != 0) ? 'greytd' : ''; ?> td_brdbtm">
            <h2 class="bold"><?= $special_users[$i]['discount'] ?>%</h2>
        </td>
        <?php endfor; ?>
    </tr>
    <tr align="center">
        <?php for($i=0; $i < count($special_users)-1; $i++): ?>
        <td class="<?= ($i % 2 != 0) ? 'greytd' : ''; ?> td_pdng_top20 td_pdng_btm20 td_brdbtm">
            <div class="price"><?= $t->_('from') ?> <span><?= $special_users[$i]['year_budget'] ?></span> грн./<?= $t->_('year') ?></div>
        </td>
        <?php endfor; ?>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm" rowspan="2">
<!--            <a href="#" class="green_but"><?//= $t->_('conditions') ?></a>-->
<!--            <div class="star"><?//= $t->_('region_depends') ?></div>-->
        </td>
    </tr>
    <tr align="center">
        <?php for($i=0; $i < count($special_users)-1; $i++): ?>
        <td class="<?= ($i % 2 != 0) ? 'greytd' : ''; ?> td_pdng_top20 td_pdng_btm20 td_brdbtm">
            <?= $t->_('first_order') ?>
            <div class="price_small"><?= $t->_('from') ?> <span><?= $special_users[$i]['first_order'] ?></span> грн./<?= $t->_('year') ?></div>
        </td>
        <?php endfor; ?>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            <div class="price_small"><?= $t->_('from') ?> <span>15000</span> грн./<?= $t->_('year') ?></div>
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            <div class="price_small"><?= $t->_('from') ?> <span>30000</span> грн./<?= $t->_('year') ?></div>
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            <div class="price_small"><?= $t->_('from') ?> <span>50000</span> грн./<?= $t->_('year') ?></div>
        </td>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Каталоги
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Каталоги
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Каталоги
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Каталоги
        </td>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Роздатковий матеріал
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Роздатковий матеріал
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Роздатковий матеріал
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Роздатковий матеріал
        </td>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Фірмові фартухи
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Фірмові фартухи
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Фірмові фартухи
        </td>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Виділений менеджер
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Виділений менеджер
        </td>
    </tr>
    <tr align="center">
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="greytd td_pdng_top20 td_pdng_btm20 td_brdbtm">
        </td>
        <td class="td_pdng_top20 td_pdng_btm20 td_brdbtm">
            Подарунковий банер
        </td>
    </tr>
</table>
</section>