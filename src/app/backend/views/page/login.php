<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?= !empty( $meta_title ) ? $meta_title : \config::get( 'global#title' ) ?></title>
    <meta name="keywords" content="<?= !empty( $meta_keywords ) ? $meta_keywords : \config::get( 'global#title' ) ?>">
    <meta name="description" content="<?= !empty( $meta_description ) ? $meta_description : \config::get( 'global#title' ) ?>">

    <link rel="stylesheet" href="/css/main.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/jquery-ui/jquery-ui.min.css" />



    <script src="/js0/jquery.js"></script>
    <script src="/js0/jquery-ui.js" type="text/javascript"></script>

    <script type="text/javascript" src="/js0/main.js"></script>
    <script type="text/javascript" src="/js0/jquery.validate.min.js"></script>



</head>

<body>
<div id="header_login">
    <a href="/login" title="admin">
        <img src="/images/logo.png" alt="logo_admin" width="159" height="54" />
    </a>
</div>



<div id="content_login" class="clearfix">
<div class="inner">
    <?= $this->flash->output(); ?>

    <div class="content_wrapper">
        <form class="form-signin" role="form" method="post" id="admin_login">
            <input type="email" class="input" placeholder="Email" autofocus="" name="email" id="login">
            <input type="password" class="input" placeholder="Пароль" name="passwd" id="passwd">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        </form>
    </div>

</div>
</div>

<div id="footer_admin">
    <div>
        <span class="float">&copy;Разработка студии&nbsp;</span>
        <a href="http://artweb.com.ua/" class="float">ArtWeb</a>
        <span class="float">, <?= date('Y') ?></span>
    </div>
</div>

</body>
</html>