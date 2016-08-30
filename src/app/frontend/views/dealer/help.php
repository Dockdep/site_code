<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
<div class="block_content block930 top8" align="center">

    <h3 class="table_title top15"><?= $t->_('help_title') ?></h3>

    <div class="st_table_mrgn">
        <div class="status_table">
            <div class="st_block" class="noborder">
                <div class="st_title">Ваш статус:</div>
                <div class="opt_status <?= $special_users['css_class'] ?> active_status"><?= $special_users['title'] ?></div>
            </div>
            <div class="st_block">
                <div class="text_left">
                    <div class="manager_name">
                        Спеціалісти з питання овочів:
                        <br>Баранецька Валентина (050)414-45-89
                        <br>Іващенко Марина (050)449-98-00
                        <br>Левченко Людмила (050)388-17-72
                        <br>
                        <br>Спеціалісти з питання засобів захисту та добрив:
                        <br>Мозок Тетяна (095)428-94-05
                        <br>Баранецька Валентина (050)414-45-89
                        <br>
                        <br>Спеціалісти з питання квітів:
                        <br>Костюк Леся (050)386-24-54
                        <br>Гаврись Людмила (050)410-03-92
                        <br>Левченко Людмила (050)388-17-72 (цибулькові)
                        <br>
                        <br>Адміністратор сайту:
                        <br>Чиж Ольга (050)443-80-89
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $t->_('help_table_title') ?>
    <img src="/images/help1.jpg" class="helpimg">
    <h3 class="table_title"><?= $t->_('pre_order') ?></h3>
    <img src="/images/help2.jpg" class="helpimg">
    <h3 class="table_title"><?= $t->_('help_order_history') ?></h3>
    <img src="/images/help3.jpg" class="helpimg">

    <?= $t->_('suggestions') ?>
    <div class="hght_gr_but">
        <a href="#" class="green_but" data-toggle="modal" data-target="#ideaModal"><?= $t->_('send_idea') ?></a>
    </div>
    <div class="clear170"></div>
    <div class="modal fade" id="ideaModal" tabindex="-1" role="dialog" aria-labelledby="modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="idea_form" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-label">Ідея</h4>
                </div>
                <div class="modal-body">
                    <textarea id="idea_text" style="resize: none" name="idea_text" form="idea_form" rows="10" cols="50">
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="green_but">Відправити</button>
                </div>
                </form>
            </div>
        </div>
</div>
</section>
