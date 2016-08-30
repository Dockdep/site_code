<div class="one_item float <?= ( ($k+1) % $limit == 0 ? 'last' : '' ) ?>">
    <div class="new_top">
        <?= ( isset( $i['is_new'] ) && !empty( $i['is_new'] )
        ?
        '<div class="float">
            <img src="/images/new.png" alt="Новинки" width="47" height="14" />
        </div>'
        :
        '').
        ( isset( $i['is_top'] ) && !empty( $i['is_top'] )
        ?
        '<div class="float">
            <img src="/images/top.png" alt="Топ продаж" width="63" height="14" />
        </div>'
        :
        '') ?>
    </div>
    <div class="one_item_image">
        <a href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="<?= $i['title'] ?>" style="position:relative;">
            <?php if($i['count_available'] == 0){
                echo "<div class='not_availiable ".$t->_("lang_name")."'></div>";
            }
            ?>
            <img src="<?= $i['cover'] ?>" alt="<?= $i['title'] ?>" width="126" height="200" />
        </a>
    </div>
    <div class="one_item_title">
        <a href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="<?= $i['title'] ?>">
            <h3><?= \plugins::getShortText($i['title']) ?></h3>
        </a>
    </div>
    <div class="align_bottom">
        <div class="one_item_price"><?= $t->_("price_from") ?> <span><?= $i['price'] ?></span> грн</div>
        <div class="one_item_buttons">
            <a href="<?= $this->seoUrl->setUrl($i['alias']) ?>" title="" class="btn grey"><?= $t->_("details") ?></a>
            <a data-group_id="<?= $i['group_id'] ?>" href="javascript:;" title="" class="<?= $i['count_available'] != 0 ? 'btn green buy' : 'not_available grey'?>"><?= $t->_("buy") ?></a>
        </div>
        <div class="one_item_compare">
            <input type="checkbox" id="items_compare_item_<?= $i['id'] ?>" value="<?= $i['type_id'].'-'.$i['catalog'].'-'.$i['id'] ?>" <?= ( !empty($i['checked']) ? 'checked' : '' ) ?> />
            <label for="items_compare_item_<?= $i['id'] ?>"><span></span><?= $t->_("compared_to") ?></label>
        </div>
    </div>
</div>