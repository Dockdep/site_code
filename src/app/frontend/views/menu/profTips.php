<div id="content" class="clearfix">
<div class="news">
<div class="breadcrumbs">
    <div class="inner">
        <div class="order_menu_shadow"></div>
        <ul class="clearfix">
            <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a  itemprop="url" href="<?=$this->seoUrl->setUrl('/') ?>" title="<?= $t->_("main_page") ?>"><span itemprop="title"><?= $t->_("main_page") ?></span></a></li>
            <li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
            <li  itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="" class="float"><a itemprop="url" href="<?=$this->seoUrl->setUrl('/prof_tips') ?>" title="<?= $t->_("prof_tips") ?>" class="breadcrumbs_last"><span itemprop="title"><?= $t->_("prof_tips") ?></span></a></li>
        </ul>
    </div>
</div>

<div class="news_wrapper clearfix">
    <div class="inner clearfix">
	<?php $params = $this->dispatcher->getParams();?>
	<ul class="prof_rubrics">
		<li><a href="<?=$this->seoUrl->setUrl('/prof_tips');?>" <?php if(empty($params['rub']))echo'class="active"';?> ><?=$t->_("all");?></a></li>
		<?php foreach($rubrics as $r):?>
            <?php if(in_array($r['id'], config::get( 'dealer_rubric' ))) continue; ?>
		<li><a href="<?=$this->seoUrl->setUrl('/prof_tips/rub/'.$r['id']); ?>" <?php echo (!empty($params['rub']) && ($params['rub']==$r['id'])?'class="active"':'');?>><?php echo $r['name']; ?></a></li>
		<?php endforeach;?>
	</ul><div class="clearfix"></div>	
	

        <?php

        $data_tips = '';
        foreach( $tips as $k => $n )
        {

            $data_tips .=
                '<div class="one_news float'.( ($k+1)%2==0 ? ' last' : '' ).'">'.
                    '<div class="one_news_img float">'.
                        ( !empty( $n['cover'] )
                        ?
                            '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'">'.
                                '<img src="'.$n['image'].'" alt="" width="180" height="120" />'.
                                (!empty( $n['video']) ? '<img class="video_play" src="/images/video_play.png" />' : '').
                            '</a>'
                        :
                            '').
                    '</div>'.
                    '<div class="one_news_content float'.( empty( $n['cover'] ) ? ' full_width' : '').'">'.
                        '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'">'.
                            '<h2 style="text-overflow:ellipsis;white-space:nowrap;overflow: hidden;">'.$n['title'].'</h2>'.
                        '</a>'.
                        '<p>'.$this->common->shortenString( $n['abstract_info'], 230 ).'</p>'.
						'<p>'.date("d-m-Y", strtotime($n['publish_date'])).'</p>'.
                        '<a href="'.$this->seoUrl->setUrl($n['link']).'" title="'.$n['title'].'" class="news_more">Докладніше</a>'.
                    '</div>'.
                '</div>';
        }

        echo( $data_tips );

        ?>
<div class="clearfix"></div>
    </div>
    <?= $this->partial('partial/share');?>

<div class="clearfix"></div>
<br /><br /><br /><br />
<?php

if( $total > \config::get( 'limits/news') )
{
    echo('<div class="inner"><div class="paginate">');
    echo $paginate;
    echo('</div></div>');
}

?>
</div>





</div>
</div>