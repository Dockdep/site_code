
<?php if(!empty($items)): ?>
    <div class="items">
        <?php
        $maxPrice = 0;
        $minPrice = 0;
        ?>
        <?php foreach ($items as $k => $i): ?>
            <?php $this->partial('partial/item_group', ['k' => $k, 'i' => $i, 'limit' => 5]) ?>
            <?php
            if ($i['price'] > $maxPrice) {
                $maxPrice = $i['price'];
            } elseif ($i['price'] < $maxPrice) {
                $minPrice = $i['price'];
            }
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>