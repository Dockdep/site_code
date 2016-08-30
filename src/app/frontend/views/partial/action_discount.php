<?php foreach($action_discount as $v): ?>
    <div class="actions_block">
        <label style="text-decoration: none">
            <img style="width: 150px" height="110px" src="<?= $this->storage->getPhotoUrlDev($v['cover'], 'actions', 'original') ?>">
            <div style="width: 150px;">
                <?= $t->_('discount') ?> <?= $v['name'] ?>% <?= $t->_('on_order') ?>
            </div>
            <input data-id="<?= $v['id'] ?>" type="radio" name="action">
        </label>
    </div>
<?php endforeach; ?>