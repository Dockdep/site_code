
<div id="content" class="clearfix">
<div class="order">
<div class="breadcrumbs">
	<div class="inner">
		<div class="order_menu_shadow"></div>
		<ul class="clearfix">
			<li class="float"><a href="<?= $this->seoUrl->setUrl('/')?>" title="<?= $t->_("main_page") ?>"><?= $t->_("main_page") ?></a></li>
			<li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
			<li class="float"><a href="<?= $this->seoUrl->setUrl('/basket"')?> title="<?= $t->_("cart")?>" class="breadcrumbs_last"><?= $t->_("cart")?></a></li>
			<li class="float more"><img src="/images/breadcrumbs_arrow.png" alt="" height="7" width="7" /></li>
			<li class="float"><a href="<?= $this->seoUrl->setUrl('/basket/completed')?>" title="Completed" class="breadcrumbs_last">Completed</a></li>
		</ul>
	</div>
</div>

<script>
dataLayer = [{
    'transactionId': '<?=$data['oid'];?>',
    'transactionAffiliation': 'OnlineShop',
    'transactionTotal': '<?=$data['amount'];?>',
    'transactionProducts': [
	<?php foreach($data['items'] as $items){?>
	{
        'sku': '<?=$items['id'];?>',
        'name': '<?=$items['title'];?>',
        'category': '<?=$items['catalog_title'];?>',
        'price': '<?=$items['total_price'];?>',
        'quantity': '<?=$items['count'];?>'
    },
	<?php }?>
	]
}];
</script>

<script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=S0cNPbH9hz0ooaeeVZVWWjy6YvaesF3Qq*yhAVkLDSxTVbSnzhSp0uwOBYyIVxiwlb5VSYBVSPNmyNhESU9bWm0EiVAngXP3O46wwGBE4maD*XmrpdDJ8gG3*xatYLOAgAQx2zF/acgHuhgYuTWpphKaW8OZywD7gX89iYlKkQ0-';</script>


<div class="inner">
<?php
	$message = $this->flash->getMessages();
	if( !empty( $message ) )
	{
		if( isset($message['error']) && !empty($message['error'])  )
		{
			echo('<div class="errorMessage">'.$message['error']['0'].'</div>');
		}
		else
		{
			echo('<div class="successMessage">'.$message['success']['0'].'</div>');
		}
	}
	?>
</div>

<div class="order_wrapper">
	<div class="inner">
		<div class="order_form">
			<div class="order_title"><h1><?= $t->_("cart")?></h1></div>
			<p><?= $completed; ?></p>
		<?php if (!empty($liqpay)): ?>
			<div class="liqpay-form">
				<?php print $liqpay; ?>
			</div>
<?= $t->_("completed_thanks")?>
		<?php endif; ?>
		</div>
	</div>
</div>

<?= $this->partial('partial/share'); ?>

</div>
</div>
