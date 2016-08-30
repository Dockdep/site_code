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
                    <div class="table_name header_gradient">Новости и публикации</div>

                    <div class="table_pages_wrapper">
                        <form method="post" enctype="multipart/form-data" action="" id="news_add_edit">
                            <div class="clearfix input_wrapper input_wrapper_change_lang">
                                <input type="radio" class="change_lang" name="lang" id="change_lang_1" value="1"  checked><label for="change_lang_1">Украинский</label>
                                <input type="radio" class="change_lang" name="lang" id="change_lang_2" value="2"><label for="change_lang_2">Русский</label>
                            </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="rubric">Рубрика</label></div>
                                    <div class="input">
										<select name="rubric">
											<option value="0"></option>
											<?php foreach($rubrics as $r):?>
											<option value="<?php echo $r['id'];?>" <?php if(!empty($page['1']['rubric_id']) && $page['1']['rubric_id']==$r['id'])echo 'selected'; ?>><?php echo $r['name_rus'];?></option>
											<?php endforeach;?>
										</select>
                                </div>
                            <div class="clearfix input_wrapper">
                                <div class="label"><label for="image">Картинка</label></div>
                                <div class="input"><input type="file" name="image" id="image" value=''></div>
                                <input type="hidden" name="cover"  value='<?=  (isset( $page['1']['cover'] ) && !empty( $page['1']['cover'] ) ? $page['1']['cover'] : '') ?>'>
                            </div>
                            <div class="clearfix input_wrapper">
                            <?php if(isset( $page['1']['cover'] ) && !empty( $page['1']['cover'] )):?>
                                <img  src="<?= $this->storage->getPhotoUrl( $page['1']['cover'], 'news', '180x120' )?>">
                            <?php endif ?>
                            </div>

                            <div class="clearfix input_wrapper">
                                <?= '<input type="checkbox" id="pic_status" name="pic_status" class="pic_status" value="1" '.( isset( $page['1']['pic_status'] ) && !empty( $page['1']['pic_status'] ) && $page['1']['pic_status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                <label for="pic_status"><span></span>Отображать</label>
                            </div>

                            <div class="version_1 clearfix">
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Видео</label></div>
                                    <div class="input"><input type="text" name="video_1" id="video" value='<?=  (isset( $page['1']['video'] ) && !empty( $page['1']['video'] ) ? $page['1']['video'] : '') ?>'></div>
                                </div>
                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video_sort">Сорт. Видео</label></div>
                                    <div class="input"><input type="text" name="video_sort_1" id="video_sort" size="5" value='<?=  (isset( $page['1']['video_sort'] ) && !empty( $page['1']['video_sort'] ) ? $page['1']['video_sort'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <input type="radio"  name="options_1" id="change_options_1" value='is_news' <?= ( (isset( $page['1']['options'] ) && !empty( $page['1']['options'] ) && $page['1']['options'] == '"is_news"=>"1"') ? 'checked="checked"' : '') ?>><label for="change_options_1">Новини</label>
                                    <input type="radio"  name="options_1" id="change_options_2" value='is_tips' <?= ( (isset( $page['1']['options'] ) && !empty( $page['1']['options'] ) && $page['1']['options'] == '"is_tips"=>"1"') ? 'checked="checked"' : '') ?>><label for="change_options_2">Поради</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="page_status_1" name="status_1" class="page_status" value="1" '.( isset( $page['1']['status'] ) && !empty( $page['1']['status'] ) && $page['1']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="page_status_1"><span></span>Отображать статью</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_1">Название статьи</label></div>
                                    <div class="input"><?= '<input id="page_title_1" type="text" name="title_1" value="'.(isset( $page['1']['title'] ) && !empty( $page['1']['title'] ) ? $page['1']['title'] : '').'">' ?></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_1">URL</label></div>
                                    <div class="input"><?= '<input id="page_alias_1" type="text"  name="alias_1" value="'.(isset( $page['1']['alias'] ) && !empty( $page['1']['alias'] ) ? $page['1']['alias'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="abstract_1">Аннотация</label></div>
                                    <div class="input"><?= '<textarea id="abstract_1" class="abstract_1" name="abstract_1">'.(isset( $page['1']['abstract_info'] ) && !empty( $page['1']['abstract_info'] ) ? $page['1']['abstract_info'] : '').'</textarea>' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_1">Content</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_1" class="page_content_text_1" name="page_content_text_1">'.(isset( $page['1']['content'] ) && !empty( $page['1']['content'] ) ? $page['1']['content'] : '').'</textarea>' ?></div>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_title_1">Meta title</label></div>
                                    <div class="input"><?= '<input id="page_meta_title_1" type="text" name="meta_title_1" value="'.(isset( $page['1']['meta_title'] ) && !empty( $page['1']['meta_title'] ) ? $page['1']['meta_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_keywords_1">Meta keywords</label></div>
                                    <div class="input"><?= '<input id="page_meta_keywords_1" type="text" name="meta_keywords_1" value="'.(isset( $page['1']['meta_keywords'] ) && !empty( $page['1']['meta_keywords'] ) ? $page['1']['meta_keywords'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_1">Meta description</label></div>
                                    <div class="input"><?= '<textarea id="page_meta_description_1" name="meta_description_1">'.(isset( $page['1']['meta_description'] ) && !empty( $page['1']['meta_description'] ) ? $page['1']['meta_description'] : '').'</textarea>' ?></div>
                                </div>
                            </div>

                            <div class="version_2 clearfix display_none">

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video">Видео</label></div>
                                    <div class="input"><input type="text" name="video_2" id="video" value='<?=  (isset( $page['2']['video'] ) && !empty( $page['2']['video'] ) ? $page['2']['video'] : '') ?>'></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="video_sort_2">Сорт. Видео</label></div>
                                    <div class="input"><input type="text" name="video_sort_2" id="video_sort_2" size="5" value='<?=  (isset( $page['2']['video_sort'] ) && !empty( $page['2']['video_sort'] ) ? $page['2']['video_sort'] : '') ?>'></div>
                                </div>
								
                                <div class="clearfix input_wrapper">
                                    <input type="radio"  name="options_2" id="change_options_1" value='is_news' <?= ( (isset( $page['2']['options'] ) && !empty( $page['2']['options'] ) && $page['2']['options'] == '"is_news"=>"1"') ? 'checked="checked"' : '') ?>><label for="change_options_1">Новости</label>
                                    <input type="radio"  name="options_2" id="change_options_2" value='is_tips' <?= ( (isset( $page['2']['options'] ) && !empty( $page['2']['options'] ) && $page['2']['options'] == '"is_tips"=>"1"') ? 'checked="checked"' : '') ?>><label for="change_options_2">Советы</label>
                                </div>


                                <div class="clearfix input_wrapper">
                                    <?= '<input type="checkbox" id="page_status_2" name="status_2" class="status" value="1" '.( isset( $page['2']['status'] ) && !empty( $page['2']['status'] ) && $page['2']['status'] == 1 ? 'checked="checked"' : '').' />' ?>
                                    <label for="page_status_2"><span></span>Отображать страницу</label>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_title_2">Название страницы</label></div>
                                    <div class="input"><?= '<input id="page_title_2" type="text" name="title_2" value="'.(isset( $page['2']['title'] ) && !empty( $page['2']['title'] ) ? $page['2']['title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="products_id_2"">Рекомендуемые товары (артикулы)</label></div>
                                    <div class="input"><?= '<textarea id="products_id_2" type="text" name="products_id_2">'.(isset( $page['2']['products_id'] ) && !empty( $page['2']['products_id'] ) ? $page['2']['products_id'] : '').'</textarea>' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_alias_2">URL</label></div>
                                    <div class="input"><?= '<input id="page_alias_2" type="text"  name="alias_2" value="'.(isset( $page['2']['alias'] ) && !empty( $page['2']['alias'] ) ? $page['2']['alias'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="abstract_2">Аннотация</label></div>
                                    <div class="input"><?= '<textarea id="abstract_2" class="abstract_2" name="abstract_2">'.(isset( $page['2']['abstract_info'] ) && !empty( $page['2']['abstract_info'] ) ? $page['2']['abstract_info'] : '').'</textarea>' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_content_text_2">Content</label></div>
                                    <div class="input"><?= '<textarea id="page_content_text_2" name="page_content_text_2">'.(isset( $page['2']['content'] ) && !empty( $page['2']['content'] ) ? $page['2']['content'] : '').'</textarea>' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_title_2">Meta title</label></div>
                                    <div class="input"><?= '<input id="page_meta_title_2" type="text" name="meta_title_2" value="'.(isset( $page['2']['meta_title'] ) && !empty( $page['2']['meta_title'] ) ? $page['2']['meta_title'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_keywords_2">Meta keywords</label></div>
                                    <div class="input"><?= '<input id="page_meta_keywords_2" type="text" name="meta_keywords_2" value="'.(isset( $page['2']['meta_keywords'] ) && !empty( $page['2']['meta_keywords'] ) ? $page['2']['meta_keywords'] : '').'">' ?></div>
                                </div>

                                <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_2">Meta description</label></div>
                                    <div class="input"><?= '<textarea id="page_meta_description_2" name="meta_description_2">'.(isset( $page['2']['meta_description'] ) && !empty( $page['2']['meta_description'] ) ? $page['2']['meta_description'] : '').'</textarea>' ?></div>
                                </div>
                            </div>

                            <div class="clearfix input_wrapper">
                                    <div class="label"><label for="page_meta_description_2">Реомендуемые товары</label></div>
                                    <div class="clearfix input_wrapper" id="send_method_users_table">

                                        <div class="clearfix input_wrapper">
                                            <table id="users-list" class="table table-hover">
                                                <?php if(isset( $group ) && !empty( $group ) ):?>
                                                    <?php foreach($group as $data):?>
                                                        <tr>
                                                            <td id='name'><?= $data['meta_title'] ?></td>
                                                            <td><p class = 'btn btn-primary delete-row'>Убрать из списка</p>
                                                            <input type='hidden' value='<?= $data['group_id'] ?>' name='group_id[]'></td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                <?php endif; ?>
                                            </table>
                                            <div class="label"><label for="autocomplete_user_email">Введите артикул товара</label></div>
                                            <div class="input"> <input type="text" value="" name="autocomplete_user_email" id="autocomplete_user_email"  autocomplete="off"></div>
                                        </div>

                                        <table class="table table-hover">
                                            <tbody id="result">

                                            </tbody>
                                        </table>
                                    </div>
                            </div>

                            <div class="clearfix submit_wrapper">
                                <a href="<?= $this->url->get([ 'for' => 'news_index' ]) ?>" class="news_cancel float">Отмена</a>
                                <input type="submit" class="news_submit float" value="Сохранить">
                            </div>

                        </form>
                    </div>



                </div>

            </div>

        </div>
    </div>
</div>