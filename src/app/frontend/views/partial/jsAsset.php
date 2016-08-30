<?php if(!empty($js)): ?>
    <?php foreach ($js as $item): ?>
        <script src="<?= $item ?>"></script>
    <?php endforeach; ?>
<?php endif;