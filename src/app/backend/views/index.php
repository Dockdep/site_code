<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="ru" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?= !empty( $meta_title ) ? $meta_title : \config::get( 'global#title' ) ?></title>
    <meta name="keywords" content="<?= !empty( $meta_keywords ) ? $meta_keywords : \config::get( 'global#title' ) ?>">
    <meta name="description" content="<?= !empty( $meta_description ) ? $meta_description : \config::get( 'global#title' ) ?>">

    <link rel="stylesheet" href="/css/main.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/exeptions.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/jquery-ui/jquery-ui.min.css" />

    <link rel="stylesheet" type="text/css" href="/js0/uploader/uploadify.css" />



    <script src="/js0/jquery.js"></script>
    <script src="/js0/jquery-ui.js" type="text/javascript"></script>


    <script type="text/javascript" src="/js0/uploader/jquery.uploadify.js"></script>

    <script type="text/javascript" src="/js0/redactor.js"></script>
    <script type="text/javascript" src="/js0/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js0/ckeditor/config.js"></script>
    <script type="text/javascript" src="/js0/ckeditor/build-config.js"></script>

    <script type="text/javascript" src="/js0/main.js"></script>
    <script type="text/javascript" src="/js0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js0/validate.js"></script>

    <script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="/js/jquery.fileupload.js"></script>



</head>

<body>
<?php $this->status    = $this->models->getOrders()->countStatus();?>
<div id="wrapper" class="clearfix">

    <div id="header" class="clearfix header_gradient">
        <div class="inner clearfix">
            <div class="logo float">
                <a href="/" title="admin">
                    <img src="/images/logo.png" alt="logo_admin" width="159" height="54" />
                </a>
            </div>
            <div class="header_nav float">
                <div class="clearfix">
                    <div class="float header_nav_point header_gradient">
                        <a href="#" title="Каталог" class="header_nav_catalog">Каталог</a>
                    </div>
                    <div class="float header_nav_point header_gradient">
                        <a href="#" title="Заказы" class="header_nav_orders">Заказы</a>
                        <a href="#" title="Заказы" class="header_nav_orders_number header_nav_number"><?=$this->status[0]['total']?></a>
                    </div>
                    <div class="float header_nav_point header_gradient">
                        <a href="#" title="Заявки" class="header_nav_proposal">Заявки</a>
                        <a href="#" title="Заявки" class="header_nav_proposal_number header_nav_number header_nav_number_more_10">0</a>
                    </div>
                    <div class="float header_nav_point header_gradient">
                        <a href="#" title="Статистика" class="header_nav_statistic">Статистика</a>
                    </div>
                </div>
            </div>
            <div class="logout float_right">
                <p class="clearfix"><span class="float">Вы зашли как&nbsp</span><a class="float" href="#" title="Администратор">Администратор</a></p>
                <p class="clearfix"><a href="/logout" title="Выйти" class="float_right logout_link">Выйти</a></p>
            </div>
        </div>
    </div>


    <div id="content" class="clearfix">

        <?php

        echo $this->getContent();

        ?>
    </div>

</div>

<div id="footer">
    <div class="inner clearfix">
        <div class="float">
            <a href="#">Техническая поддержка</a>
        </div>

        <div class="float_right">
            <span class="float">&copy;Разработка студии&nbsp;</span>
            <a href="http://artweb.com.ua/" class="float">ArtWeb</a>
            <span class="float">, <?= date('Y') ?></span>
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

</body>
</html>
