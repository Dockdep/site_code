<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title><?= !empty( $meta_title ) ? $meta_title : \config::get( 'global#title' ) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">-->

    <?= $this->partial('partial/header', ['lang' => $lang]) ?>

</head>
<body class="skin-blue sidebar-mini fixed">

<?= $this->partial('partial/popupCart') ?>
<div class="wrapper">

    <?php $this->partial('partial/dealer', ['customer'=> $customer]) ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?= $this->getContent(); ?>
    </div><!-- /.content-wrapper -->

</div><!-- ./wrapper -->



<?= $this->partial('partial/footer', ['lang' => $lang]) ?>

</body>
</html>