<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/css/main.css" type="text/css" media="all">
    <link rel="stylesheet" href="/css/dealers.css" type="text/css" media="all">
    <script type="text/javascript" src="/js/jquery.js"></script>
</head>
<body>
<a href="#" class="print_but"><img src="/images/print.png" border="0"></a>
<div id="for_print" style="display: none;">
    <?= $this->partial('partial/singleOrder', ['order' => $order, 'order_id' => $order_id]) ?>
</div>
<script>
    $('.print_but').click(function(e) {
        e.preventDefault();
        $('.green_but').hide();
        $('.print_but').hide();
        $('.order-header').hide();
        $('a').css('text-decoration', 'none');
        var $sizes = $('.group_sizes');
        $sizes.removeClass('group_sizes').removeClass('active').css('text-align', 'center');
        $('td, .cell, .tovar_bl, .price span').css('padding', '0');
        $('td, .cell, .tovar_bl, .price span').css('height', 'initial');
        $('td, .cell, .tovar_bl, .price span').css('font-size', '10px');
        $('.tovar_block').css({'width': 'initial', 'height': 'initial'});
        $('.group_sizes_content').removeClass('.group_sizes_content');
        $('#for_print img').hide();
        $('#for_print').show();

        print();

        $('#for_print').hide();
        $('.print_but').show();
    });
</script>
</body>
</html>