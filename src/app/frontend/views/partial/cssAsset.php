<?php if(!empty($css)): ?>
    <?php foreach ($css as $item): ?>
        <link href='<?= $item ?>' rel='stylesheet' type='text/css'>
    <?php endforeach; ?>
<?php endif;
