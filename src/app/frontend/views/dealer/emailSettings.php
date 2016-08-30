<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
    <div id="content" class="clearfix">
        <?= $this->partial('partial/emailSettings', ['email_settings' => $email_settings]); ?>
    </div>
</section>
