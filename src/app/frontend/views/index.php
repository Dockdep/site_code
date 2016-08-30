<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?= !empty( $meta_title ) ? $meta_title : \config::get( 'global#title' ) ?></title>
    <?= !empty( $meta_link_next ) ? $meta_link_next : '' ?>
    <?= !empty( $meta_link_prev ) ? $meta_link_prev : '' ?>
    <meta name="keywords" content="<?= !empty( $meta_keywords ) ? $meta_keywords : \config::get( 'global#title' ) ?>">
    <meta name="description" content="<?= !empty( $meta_description ) ? $meta_description : \config::get( 'global#title' ) ?>">
    <?php $this->assets->outputCss() ?>
    <?php
    if (!empty($lang)):
    if ($lang[count($lang)-1] == 'ru'): ?>
        <link rel="alternate" hreflang="uk" href="<?= isset($change_lang_url['1']) && !empty($change_lang_url['1']) ? $change_lang_url['1'] : '/' ?>"/>
        <?php else: ?>
        <link rel="alternate" hreflang="ru" href="<?= isset($change_lang_url['2']) && !empty($change_lang_url['2']) ? $change_lang_url['2'] : '/ru' ?>"/>
    <?php endif ?>
    <?php endif; ?>

    <?= ( isset( $no_robots ) && !empty( $no_robots ) ? isset($utm) &&  $utm == 0 ? '<meta name="robots" content="noindex, follow"/>' : '' : '' ) ?>

    <?= $this->partial('partial/header', ['lang' => $lang]) ?>

    <?php if(!empty($css)): ?>
        <?= $this->partial('partial/cssAsset', ['css' => $css]) ?>
    <?php endif; ?>
</head>

<?php
$lang_id        = $this->seoUrl->getLangId();
$in_cart        = $this->session->get('in_cart', []);

$pages          = $this->models->getPages()->getPages( $lang_id );

$main_menu     = $this->models->getNavigation()->getActiveData($lang_id );

$params         = $this->dispatcher->getParams();

$page_title = isset( $page_title ) && !empty( $page_title ) ? $page_title : '';

?>

<body class="skin-blue sidebar-mini fixed sidebar-collapse clearfix">

<?= $this->partial('partial/popupCart') ?>
<?php if($this->session->get('special_users_id') != null): ?>
    <?php $this->partial('partial/dealer', ['customer'=> $customer]) ?>
<?php endif; ?>
<div id="wrapper" class="clearfix">
    <div id="header" class="clearfix">
        <div style="display: none" itemscope itemtype="http://schema.org/LocalBusiness">
            <meta itemprop="name" content="Semena.in.ua - інтернет-магазин. ТМ «Професійне насіння»">
            <meta itemprop="logo" content="http://semena.in.ua/images/logo.png">
            <span style="display: none">
            <link itemprop="url" href="http://semena.in.ua/ru">
            <a itemprop="sameAs" href="https://www.facebook.com/Professionalseeds">FB</a>
            </span>
            <meta itemprop="telephone" content="+38 (044) 451 48 59 ">
            <meta itemprop="telephone" content="+38 (044) 581 67 15">
            <meta itemprop="telephone" content="+38 (067) 464 48 59">
            <meta itemprop="telephone" content="+38 (050) 464 48 59">
            <span itemprop="email">info@hs.kiev.ua</span>
            <div style="display: none" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                <span itemprop="streetAddress">вул. Садова 95</span>
                <span itemprop="addressLocality">м. Київ</span>
                <span itemprop="postalCode">02002 а/с 115</span>
            </div>
        </div>
        <div style="display: none" itemscope itemtype="http://schema.org/WebSite">
            <meta itemprop="url" content="http://semena.in.ua/ru"/>
            <form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
                <meta itemprop="target" content="http://semena.in.ua/search?search={search}"/>
                <input itemprop="query-input" type="text" name="search" required/>
                <input type="submit"/>
            </form>
        </div>
        <div class="inner">
            <div class="clearfix">
                <div class="float columns3 first_column">
                    <div class="switch_lang clearfix">
                        <div class="float"><?php if($lang_id==1):?>Українською<?php else: ?><a href="<?= isset($change_lang_url['1']) && !empty($change_lang_url['1']) ? $change_lang_url['1'] : '/' ?>" title="" <?php if($lang_id==1):?>class="active"<?php endif; ?>>Українською</a><?php endif; ?></div>
                        <div class="float"><?php if($lang_id==2):?>По-русски<?php else: ?><a href="<?= isset($change_lang_url['2']) && !empty($change_lang_url['2']) ? $change_lang_url['2'] : '/ru' ?>" title="" <?php if($lang_id==2):?>class="active"<?php endif; ?>>По-русски</a><?php endif; ?></div>
                    </div>
                    <div class="contact_phones">
                        <span class="small_digits">(044)</span><span> 581-67-15</span>
                        <span class="small_digits">(044)</span><span> 451-48-59</span>
                    </div>
                    <div class="contact_mob_phones">
                        <span class="small_digits">(050)</span><span> 464-48-59</span>
                        <span class="small_digits">(067)</span><span> 464-48-59</span>
                    </div>
                    <div class="contact_mob_phones">
                        <span class="small_digits">(093)</span><span> 026-86-64</span>
                    					
                    <div style="float:right;font-size:12px;margin-right:65px;" class="contact_callback_phones">
                        <a href="<?= $this->seoUrl->setUrl('/callback') ?>" class="callback" title="<?= $t->_("Feedback")?>" id="ajax_simple" data-options="width: 940, height: 400" target="<?= $this->seoUrl->setUrl( $this->url->get([ 'for' => 'callback' ])) ?>" data-type="ajax"><?= $t->_("Feedback")?></a>
                    </div>
					</div>
                </div>
                <div class="float columns3 second_column">
                    <div class="logo">
                        <a href="<?= $this->seoUrl->setUrl('/') ?>" title=""><img alt="Інтернет-магазин насіння" title="Магазин насіння Semena.in.ua" src="/images/logo.png" width="314" height="76" /></a>
                    </div>
                </div>
                
                

                
                <div class="float columns3 third_column last">
                    <div class="clearfix">
                        <div class="float basket_number float_right last"><a href="<?= $this->seoUrl->setUrl('/basket') ?>" title="<?= $t->_("cart")?>"><?= !empty( $in_cart ) ? count( $in_cart ) : '0' ?></a></div>

                        <div class="float basket float_right"><a href="<?= $this->seoUrl->setUrl('/basket') ?>" title="<?= $t->_("cart")?>" class="<?= (!empty( $static_page_alias ) && $static_page_alias == '/basket' ? ' active' : '') ?>"><?= $t->_("your_cart")?></a></div>
                        <?php echo '<div class="float menu_cabinet float_right">
                            <a href="'.$this->seoUrl->setUrl('/cabinet').'" title="'.(!empty( $customer['name'] ) ? $customer['name'] : $t->_("personal_account")).'" class="'.(!empty( $static_page_alias ) && $static_page_alias == '/cabinet' ? ' active' : '').'">'.(!empty( $customer['name'] ) ? $customer['name'] : $t->_("personal_account")).'</a>
                        </div>';

                       if(!$this->getDi()->get('request')->get('_url') || $this->getDi()->get('request')->get('_url')=="/ru" ){?>
                           <div class="file_download_link_">
                               <a href="http://storage.semena.in.ua/temp/catalog.pdf"><?= $t->_("file_download_link")?></a>
                           </div>
                       <?php }?>

                        <div class="float faq float_right">
                            <a href="<?= $this->seoUrl->setUrl('/faq') ?>">FAQ</a>
                        </div>

                    </div>

                    <div class="clearfix compare_wrapper">
                        <?= !empty( $compare ) ? '<div class="compare"><a href="#" title="'.$t->_("comparison_list").'">'.$t->_("comparison_list").' '.$count.'</a></div>' : '' ?>

                        <?php

                        if( !empty( $compare_ ) )
                        {
                            $data_compare =
                                '<div class="compare_list">'.
                                    '<div class="compare"><a href="#" title="'.$t->_("comparison_list").'">'.$t->_("comparison_list").' '.$count.'</a></div>'.
                                        '<ul>';
                            foreach( $compare_ as $comp )
                            {
                                foreach( $comp as $k => $c )
                                {
                                    $data_compare .= '<li class="clearfix"><a href="'.$this->seoUrl->setUrl($c['url']).'" title="" class="float">'.$c['title'].' '.$c['count'].'</a><a href="'.$this->seoUrl->setUrl($c['url_del']).'" title="" class="float"><img src="/images/compare_del.jpg" alt="" height="8" width="8" /></a></li>';
                                }
                            }

                            $data_compare .= '</ul></div>';

                            echo( $data_compare );
                        }

                        ?>

                    </div>
                    <div class="site_search">
                        <form action="<?= $this->url->get([ 'for' => 'search_items' ]) ?>" method="get">
                            <div class="search_result_wrapper">
                                <input type="text" name="search" id="search_item" value="<?= isset($search) && !empty($search) ? $search : '' ?>" />
                                <label><img src="/images/search.png" alt="search" width="16" height="17" /></label>
                                <div class="search_result_display" id="search_result_display">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="header_nav" class="clearfix">

               <ul class="nav_menu_main">
                   <?php foreach($main_menu as $menu_item):?>
                        <li class="<?= ( array_search(trim($menu_item['url'], '/'), $this->seoUrl->getLink(true)) || $menu_item['url']==$this->seoUrl->getLink()  ? ' active' : '' ) ?> header_nav_<?=$menu_item['weight']?>"><a href="<?=$menu_item['url']?>" title="<?=$menu_item['name']?>"><?=($menu_item['name']=='Головна' || $menu_item['name']=='Главная')?'<img src="/images/ico_home.png" />':$menu_item['name'];?></a></li>
                   <?php endforeach ?>
               </ul>
            </div>
        </div>
    </div>

    <?php
    echo $this->getContent();
    ?>

</div>
<div id="footer">
    <div class="up inner">
        <a href="#"><img src="/images/up.png" alt="Вгору" width="36" height="36" /></a>
    </div>

    <div class="copyright">
        <div class="inner clearfix">
            <p class="float"><?= $t->_("tm")?></p>
            <p class="float float_right copyright_logo_margin">
                <a href="http://artweb.ua/" title=""><img src="/images/art_web_logo.png" alt="" width="58" height="17" /></a>
            </p>
            <p class="float float_right">
                <a href="#" title=""><?= $t->_("website_design")?></a>
            </p>
        </div>
    </div>
</div>

<?php
    if( !IS_PRODUCTION )
{

    echo('<div id="profiler">');

    $info = $this->profiler->getInfoStatistics();

    echo
    (
        '<div id="profiler-general">'.
        '<span'.( $info['exec']>=50 ? ' class="warning"' : '' ).'>time total:&nbsp;'.$info['exec'].'&nbsp;ms</span> | '.
        '<span class="'.( $info['db']['time']>=20 ? 'warning ' : '' ).'profiler-sql-show">db time&nbsp;('.$info['db']['count'].'):&nbsp;'.$info['db']['time'].'&nbsp;ms</span> | '.
        '<span'.( $info['memory']>=800 ? ' class="warning"' : '' ).'>memory:&nbsp;'.$info['memory'].'&nbsp;KB</span>'.
        '</div>'
    );

    $info = $this->profiler->getAllStatistics();

    if( !empty($info) && isset($info['sql']) && !empty($info['sql']) )
    {

        $html   = '<div id="profiler-sql">';
        $c      = 1;

        foreach( $info['sql'] as $d )
        {
            $html .=
                '<div class="profiler-sql-item clearfix">'.
                '<div class="num">'.$c.'</div>'.
                '<div class="query">'.trim($d['sql']).'</div>'.
                '<div class="time '.( round( $d['time'] * 1000, 0 )>=5 ? 'warning' : '' ).'">'.round( $d['time'] * 1000, 3 ).'&nbsp;ms</div>'.
                '</div>';

            $c++;
        }

        $html .= '</div>';

        echo( $html );

        echo('</div>');
    }
}
?>

<?= $this->partial('partial/footer', ['lang', $lang]); ?>

<?php if(!empty($js)): ?>
    <?= $this->partial('partial/jsAsset', ['css' => $js]) ?>
<?php endif; ?>
<!--float block-->
<?php if(!$this->session->has('id')):
    $modal = $this->getDi()->get('models')->getModal()->getModalLike();
    ?>
<!--<div class="subscription-wr-all">-->
<!--    <div class="subscription-wr">-->
<!--        <div class="subscription-text">-->
<!--            <p>-->
<!--                --><?//= isset($modal['text']) ? $modal['text'] : 'Залиште свій email і отримайте приємний бонус разом з Вашою посилкою.' ?>
<!--            </p>-->
<!--        </div>-->
<!--        <div class="subscription-sale-wr">-->
<!--            <div class="subscription-sale-blocks">-->
<!--                <div class="sub-sale-blocks-img">-->
<!--                    <img src="/images/ico-sale-1.jpg"/>-->
<!--                </div>-->
<!--                <div class="sub-sale-blocks-text">-->
<!--                    <p>Акции</p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="subscription-sale-blocks">-->
<!--                <div class="sub-sale-blocks-img">-->
<!--                    <img src="/images/ico-sale-2.jpg"/>-->
<!--                </div>-->
<!--                <div class="sub-sale-blocks-text">-->
<!--                    <p>Новинки</p>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="subscription-sale-blocks">-->
<!--                <div class="sub-sale-blocks-img">-->
<!--                    <img src="/images/ico-sale-3.jpg"/>-->
<!--                </div>-->
<!--                <div class="sub-sale-blocks-text">-->
<!--                    <p>Советы специалиста</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="sub-sale-forma-wr">-->
<!--            <form method="POST" id="jform">-->
<!--                <div class="sub-sale-forma-blocks-l">-->
<!--                    <div class="sub-sale-forma-blocks-name-first">Имя</div>-->
<!--                    <input type="text" name="fullname" id="fullname"/>-->
<!--                </div>-->
<!--                <div class="sub-sale-forma-blocks-c"></div>-->
<!--                <div class="sub-sale-forma-blocks-r">-->
<!--                    <div class="sub-sale-forma-blocks-name">Электроная почта</div>-->
<!--                    <input type="text" name="email" id="email"/>-->
<!--                </div>-->
<!--                <div class="sub-submit">-->
<!--                    <input type="submit" id="send" value="ПОДПИСАТЬСЯ"/>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--        <div class="sub-text-footer">-->
<!--            <p>5000 человек уже подписаны на нашу рассылку</p>-->
<!--        </div>-->
<!--        <div class="sub-closed"><img src="/images/sub_closed.png" alt=""/></div>-->
<!--    </div>-->
<!--</div>-->
<?php endif; ?>
<!--end float block-->
</body>
</html>
