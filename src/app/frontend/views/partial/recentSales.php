<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <?php $indicators = count($classic_sales) / 4 ?>
    <?php if($indicators > 1): ?>
        <ol class="carousel-indicators">
            <?php for($i = 0; $i < $indicators; $i++): ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?= $i ?>"<?= $i == 0 ?' class="active"' : ''?>></li>
            <?php endfor; ?>
        </ol>
    <?php endif; ?>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php foreach($classic_sales as $k => $sale): ?>
            <?php if($k % 4 == 0): ?>
                <div class="item<?= ($k == 0) ? ' active' : '' ?>">
            <?php endif; ?>
            <?= $this->partial('partial/one_sale', ['k' => $k, 'sale' => $sale]) ?>
            <?php if((($k + 1) % 4 == 0) || empty($classic_sales[$k + 1])): ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <?php if($indicators > 1): ?>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    <?php endif; ?>
</div>
