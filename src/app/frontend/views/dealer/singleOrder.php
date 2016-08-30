<div>
<?= $this->partial('partial/singleOrder', ['order' => $order, 'order_id' => $order_id]) ?>
</div>

    <script>
    $('.print_but').click(function(e) {
        e.preventDefault();
        $('.wrapper').hide();
        $('.green_but').hide();
        $('img').hide();

        var clone = $('.content').clone();
        var $sizes = clone.find('.group_sizes');
        $sizes.removeClass('group_sizes').removeClass('active').css('text-align', 'center');
        clone.find('a').css('text-decoration', 'none');
        clone.find('td, .cell, .tovar_bl, .price span').css('padding', '0');
        clone.find('td, .cell, .tovar_bl, .price span').css('height', 'initial');
        clone.find('td, .cell, .tovar_bl, .price span').css('font-size', '10px');
        clone.find('.tovar_block').css({'width': 'initial', 'height': 'initial'});

        var bodyClasses = $(document.body).attr('class');
        $(document.body).removeClass();
        $(document.body).append(clone);

        print();

        clone.remove();
        $(document.body).addClass(bodyClasses);
        $('.green_but').show();
        $('img').show();
        $('.wrapper').show();

    });
</script>
