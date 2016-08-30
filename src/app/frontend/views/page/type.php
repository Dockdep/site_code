<?php $lang = explode( '/', $this->getDi()->get('request')->get('_url'));
if(!empty($lang)){
    if(array_pop($lang) == 'ru'){
        $lang_data= 'ru';
    } else {
        $lang_data = 'ua';
    }

}
function titlecmp($a, $b) {
    return strcasecmp($a['title'], $b['title']);
}
?>
<div id="content" class="clearfix">
    <div class="catalog">
        <?php $banner = $this->getDi()->get('models')->getBanner()->getBannerLike();?>
        <?php if(!empty($banner)){?>
            <div style = "background: url('<?= $this->storage->getBanerUrl($banner['image']) ?>') no-repeat center center; position: relative" class="catalog_slider">

                <div class="inner">
                    <div class="catalog_description logo<?= $catalog['id'] ?>">
                        <div class="catalog_description_image float">
                            <?= '<a href="'.$this->seoUrl->setUrl($catalog['alias']).'" title="'.$catalog['title'].'"><img src="/images/types_logo/'.$catalog['id'].'.jpg" alt="'.$catalog['title'].'" width="99" height="99" /></a>' ?>
                        </div>
                        <div class="catalog_description_content float">
                            <h2 class="catalog_description_title">
                                <?= '<a href="'.$this->seoUrl->setUrl($catalog['alias']).'" title="'.$catalog['title'].'">'.$catalog['title'].'</a>' ?>
                            </h2>
                            <p>
                                <?= $t->_("internet_store_seeds")?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else{?>
            <div class="catalog_slider">

                <div class="inner">
                    <div class="catalog_description logo<?= $catalog['id'] ?>">
                        <div class="catalog_description_image float">
                            <?= '<a href="'.$this->seoUrl->setUrl($catalog['alias']).'" title="'.$catalog['title'].'"><img src="/images/types_logo/'.$catalog['id'].'.jpg" alt="'.$catalog['title'].'" width="99" height="99" /></a>' ?>
                        </div>
                        <div class="catalog_description_content float">
                            <h2 class="catalog_description_title">
                                <?= '<a href="'.$this->seoUrl->setUrl($catalog['alias']).'" title="'.$catalog['title'].'">'.$catalog['title'].'</a>' ?>
                            </h2>
                            <p>
                                <?= $t->_("internet_store_seeds")?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
        <div class="breadcrumbs">
            <div class="inner">
                <?= $breadcrumbs ?>
            </div>
        </div>
        <?php if(stristr($this->getDi()->get('request')->get('_url'), 'nasinnja_kvitiv_1c0--tsibulinni_1c1') || stristr($this->getDi()->get('request')->get('_url'), 'semena_tsvetov_1c_20--lukovichnye_1c_21') ):?>
            <div class="sidebar_content_wrapper">
                <div class="inner clearfix">

                    <div id="sidebar" class="float">
                        <ul>
                            <?php

                            $data_subtypes_list = '';

                            $catalog4 = !empty( $catalog['sub']['sub'] ) ? $catalog['sub']['sub'] : $catalog['sub'];

                            foreach( $catalog4 as $s )
                            {
                                $data_subtypes_list .=
                                    '<li>'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.$s['title'].'</a>'.
                                    '</li>';
                            }

                            echo($data_subtypes_list);

                            ?>
                        </ul>
                    </div>
                    <div id="content_wrapper" class="float">

                        <?php

                        $data_subtypes = '';
                        $data_spring = '';
                        $data_fall = '';
                        $i = 0;


                        foreach( $catalog4 as $k => $s )
                        {

                            if (stristr($s['title'], '(весняна колекція)') || stristr($s['title'], '(весенняя колекция)')) {
                                $i++;
                                $data_spring .=
                                    '<li class="float '.( ($i)%4==0 ? 'last' : '' ).'">'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.
                                    ( (!empty( $s['cover']) )
                                        ?
                                        '<img src="'.$this->storage->getPhotoUrl( $s['cover'], 'subtype', '165x120' ).'" alt="" width="165" height="120" />'
                                        :
                                        '<img src="/images/no_foto.jpg" alt="" width="165" height="120" />' ).
                                    '</a>'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.$s['title'].'</a>'.
                                    '</li>';
                            } else {
                                $i++;
                                $data_fall .=
                                    '<li class="float '.( ($i)%4==0 ? 'last' : '' ).'">'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.
                                    ( (!empty( $s['cover']) )
                                        ?
                                        '<img src="'.$this->storage->getPhotoUrl( $s['cover'], 'subtype', '165x120' ).'" alt="" width="165" height="120" />'
                                        :
                                        '<img src="/images/no_foto.jpg" alt="" width="165" height="120" />' ).
                                    '</a>'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.$s['title'].'</a>'.
                                    '</li>';
                            }


                        }
                        ?>
                        <div class="float">
                            <h1 class="seo-h1"><?= $t->_("spring_flowers")?></h1>
                            <ul>
                                <?= $data_spring; ?>
                            </ul>
                        </div>
                        <div class="float">
                            <h1 class="seo-h1"> <?= $t->_("fall_flowers")?></h1>
                            <ul>
                                <?= $data_fall; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        <?php else :?>
            <div class="sidebar_content_wrapper">
                <div class="inner clearfix">
                    <h1 class="seo-h1"> <?= isset( $seo['h1'] ) && !empty( $seo['h1'] ) ?  $seo['h1'] : ''?></h1>
                    <div id="sidebar" class="float">
                        <ul>
                            <?php

                            $data_subtypes_list = '';

                            $catalog4 = !empty( $catalog['sub']['sub'] ) ? $catalog['sub']['sub'] : $catalog['sub'];
                            usort($catalog4, "titlecmp");

                            foreach( $catalog4 as $s )
                            {
                                $data_subtypes_list .=
                                    '<li>'.
                                    '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.$s['title'].'</a>'.
                                    '</li>';
                            }

                            echo($data_subtypes_list);

                            ?>
                        </ul>
                    </div>
                    <div id="content_wrapper" class="float">

                        <?php

                        $data_subtypes = '';
                        $data_spring = '';
                        $data_fall = '';
                        $i = 0;


                        foreach( $catalog4 as $k => $s )
                        {
                            $i++;
                            $data_subtypes .=
                                '<li class="float '.( ($i)%4==0 ? 'last' : '' ).'">'.
                                '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.
                                ( (!empty( $s['cover']) )
                                    ?
                                    '<img src="'.$this->storage->getPhotoUrl( $s['cover'], 'subtype', '165x120' ).'" alt="" width="165" height="120" />'
                                    :
                                    '<img src="/images/no_foto.jpg" alt="" width="165" height="120" />' ).
                                '</a>'.
                                '<a href="'.$this->seoUrl->setUrl($s['alias']).'" title="'.$s['title'].'">'.$s['title'].'</a>'.
                                '</li>';


                        }
                        ?>
                        <ul>
                            <?= $data_subtypes; ?>
                        </ul>

                    </div>
                </div>
            </div>
        <?php endif;?>

        <div class="content_accost">
            <div class="shadow_to_down"></div>
            <div class="inner">
                <div class="content_accost_title"></div>
                <div class="content_accost_content">
                    <p>
                        <?= isset( $seo['seo_text'] ) && !empty( $seo['seo_text'] ) ?  $seo['seo_text'] : ''?>
                    </p>
                </div>
            </div>
        </div>

        <div class="content_blog">
            <div class="inner">

                <div class="links clearfix">

                    <div class="float fb">
                        <div id="fb-root"></div>

                        <div class="fb-like" data-href="#" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </div>
                    <div class="float ok">
                        <div id="ok_shareWidget"></div>
                    </div>
                    <div class="float vk">
                        <script type="text/javascript"><!--
                            document.write(VK.Share.button(false,{type: "round", text: "Нравится"}));
                            -->
                        </script>
                    </div>

                    <div class="float share">
                        <p class="share_title float"><?= $t->_("share")?>:</p>

                        <div class="pluso float" data-background="#ebebeb" data-options="small,square,line,horizontal,nocounter,theme=04" data-services="facebook,google,livejournal,moimir,odnoklassniki,vkontakte,twitter"></div>
                    </div>
                </div>
            </div>

        </div><!-- content_blog -->
    </div><!-- catalog -->
</div>   