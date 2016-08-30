<div id="addEdit">
    <div class="inner"><?= $this->flash->output(); ?></div>
    <div class="inner">
        <div class="sidebar_content_wrapper clearfix">
            <div class="sidebar_wrapper float">
                <div class="sidebar clearfix">
                    <?= $this->partial('partial/sidebar') ?>
                </div>
            </div>
            <div class="content_wrapper float">
                <div class="content_wrapper_list clearfix">
                    <div class="table_name header_gradient"></div>

                    <div class="table_pages_wrapper">
                        <form enctype="multipart/form-data" method="post" action="" id="email_event_add_edit">

                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="status" name="status" class="status" value="1" '.( isset( $page['0']['status'] ) && !empty( $page['0']['status'] ) && $page['0']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                <label for="status"><span></span>Статус ивента</label>
                            </div>



                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="name">Название ивента*</label></div>
                                <div class="input"><input type="text" name="name" id="name" value='<?=  (isset( $page['0']['name'] ) && !empty( $page['0']['name'] ) ? $page['0']['name'] : '') ?>'></div>
                            </div>

                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="templates_block">Шаблон</label></div>
                                <div class="input"><select name="templates_block" id="templates_block">
                                        <option value="" disabled selected >Название</option>
                                        <?php if(isset( $templates ) && !empty( $templates)) {
                                            foreach($templates as $template){
                                                if(isset( $page['0']['template_id'] ) && !empty( $page['0']['template_id'])):?>
                                                    <option value="<?= $template['id']?>"<?= ($template['id']==$page['0']['template_id'])?"selected":''?>><?= $template['name']?></option>
                                                <?php else: ?>
                                                    <option value="<?= $template['id']?>" ><?= $template['name']?></option>
                                                <?php endif;
                                            }
                                        }?>
                                    </select>
                                </div>
                            </div>



                            <div class="clearfix input_wrapper">
                                <fieldset>
                                    <legend>Шаблон</legend>
                                    <input type="hidden" value="<?=  (isset( $temp['0']['directory'] ) && !empty( $temp['0']['directory'] ) ? $temp['0']['directory'] : '') ?>" name="directory" id="directory">

                                    <input type="hidden" value="<?=  (isset( $page['0']['template_id'] ) && !empty( $page['0']['template_id'] ) ? $page['0']['template_id'] : '') ?>" name="template_id" id="template_id">

                                    <input type="hidden" value="<?=  (isset( $page['0']['id'] ) && !empty( $page['0']['id'] ) ? $page['0']['id'] : '') ?>" name="id" id="id">

                                        <div class="clearfix input_wrapper">
                                            <input type="file" name="uploadify" id="uploadify" />
                                        </div>

                                        <div class="clearfix input_wrapper">
                                            <div class="label"><label for="template_title">Название шаблона*</label></div>
                                            <div class="input"> <input type="text" value="<?=  (isset( $temp['0']['name'] ) && !empty( $temp['0']['name'] ) ? $temp['0']['name'] : '') ?>" name="template_name" id="template_name"></div>
                                        </div>


                                        <div class="clearfix input_wrapper">
                                            <div class="label"><label for="template_title">Заголовок*</label></div>
                                            <div class="input"><input type="text" name="template_title" id="template_title" value='<?=  (isset( $temp['0']['title'] ) && !empty( $temp['0']['title'] ) ? $temp['0']['title'] : '') ?>'></div>
                                        </div>



                                        <div class="clearfix input_wrapper" >
                                            <div class="label"><label for="template_text">Вид шаблона</label></div>
                                            <div class="input"><textarea id="template_text" class="template" name="template_text"><?=  (isset( $temp['0']['text'] ) && !empty( $temp['0']['text'] ) ? $temp['0']['text'] : '') ?></textarea></div>
                                        </div>
                                </fieldset>
                            </div>



                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="utm_status" name="utm_status" class="utm_status" value="1" '.( isset( $page['0']['utm_status'] ) && !empty( $page['0']['utm_status'] ) && !$page['0']['utm_status'] ? '' : 'checked="checked"').' />' ?>
                                <label for="utm_status"><span></span>Автоматическое добавление UTM-меток</label>
                            </div>

                            <div class="clearfix input_wrapper">
                                <fieldset>
                                    <legend>Настройка UTM-метки</legend>
                                    <div class="clearfix input_wrapper">
                                        <div class="label"><label for="utm_source">Источник кампании*</label></div>
                                        <div class="input"><input type="text" name="utm_source" id="utm_source" value='<?=  (isset( $page['0']['utm_source'] ) && !empty( $page['0']['utm_source'] ) ? $page['0']['utm_source'] : '') ?>'></div>
                                    </div>

                                    <div class="clearfix input_wrapper">
                                        <div class="label"><label for="utm_medium">Канал кампании*</label></div>
                                        <div class="input"><input type="text" name="utm_medium" id="utm_medium" value='<?=  (isset( $page['0']['utm_medium'] ) && !empty( $page['0']['utm_medium'] ) ? $page['0']['utm_medium'] : 'email') ?>'></div>
                                    </div>

                                    <div class="clearfix input_wrapper">
                                        <div class="label"><label for="utm_term">Ключевое слово кампании</label></div>
                                        <div class="input"><input type="text" readonly name="utm_term" id="utm_term" value='Указан индекс ссылки'></div>
                                    </div>

                                    <div class="clearfix input_wrapper">
                                        <div class="label"><label for="utm_content">Содержание кампании</label></div>
                                        <div class="input"><input type="text" name="utm_content" id="utm_content" value='<?=  (isset( $page['0']['utm_content'] ) && !empty( $page['0']['utm_content'] ) ? $page['0']['utm_content'] : '') ?>'></div>
                                    </div>

                                    <div class="clearfix input_wrapper">
                                        <div class="label"><label for="utm_campaign">Название кампании*</label></div>
                                        <div class="input"><input type="text" name="utm_campaign" id="utm_campaign" value='<?=  (isset( $page['0']['utm_campaign'] ) && !empty( $page['0']['utm_campaign'] ) ? $page['0']['utm_campaign'] : '') ?>'></div>
                                    </div>
                                </fieldset>
                            </div>
                            
                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'event_email_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" name="save" value="Сохранить">
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
