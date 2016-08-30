<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K68D7N"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K68D7N');</script>
<!-- End Google Tag Manager -->

<!-- Admin LTE -->
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 3.3.2 JS -->
<script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!-- Sparkline -->
<script src="/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>


<!-- AdminLTE App -->
<script src="/dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/dist/js/pages/dashboard.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<?php if(!empty($lang)) {
    if ($lang[count($lang)-1] == 'ru') { ?>
        <script src="/dist/js/demo_ru.js" type="text/javascript"></script>
    <?php } else { ?>
        <script src="/dist/js/demo.js" type="text/javascript"></script>
    <?php }
} ?>

<script type="text/javascript" src="/js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    $('.order_phone').mask('38(999) 999-9999');
</script>

<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>

<script>
    var $fileupload = $('.fileupload');

    $fileupload.fileupload({
        url: '/dealer/upload/',
        dataType: 'json',
        done: function (e, data) {
            console.log(data);
            var host = window.location.host.toString();
            var newUrl = 'http://storage.' + host + data.result;
            $('.img-circle').attr('src', newUrl);
        },
        error: function(e) {
            console.error(e.responseText);
        }
    });

    $('#toggle_cabinet').click(function(){
        $.ajax({
            url: '/ajax/toggle_cabinet/',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                window.location.reload();
            },
            error: function(e) {
                console.error(e.data);
            }
        });
    });

    $('.dropdown-toggle').dropdown();


    $('.dropdown-link').on('click', function() {
        var goods = $(this).text();
        var hidden = $(this).next();
        $('#dropdown-value').text(goods);
        $('#dropdown-id').val(hidden.val());
    });

</script>
<script src="/dist/js/cart.js"></script>
