<h2 class="content-header">
    <?= $t->_(isset(explode('/', $this->router->getRewriteUri())[2])? explode('/', $this->router->getRewriteUri())[2] : 'main') ?>
</h2>
<section style="overflow: visible" class="content">
    <div class="main_block">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control custom_width" id="reservation">
                <a href="#" class="green_but orders_data_request"  data-toggle="modal" data-target="#myModal" ><?= $t->_('reconciliation') ?></a>
            </div>
            <!-- /.input group -->
        </div>

        <div class="fin_content">

            <div class="line l_one">
                <div class="fin_cell c_one"><span style="display:none;"><?= $t->_('order_number') ?></span></div>
                <div class="fin_cell c_two"><span><?= $t->_('invoice') ?></span></div>
                <div class="fin_cell c_two"><span><?= $t->_('actually_paid') ?></span></div>
                <div class="fin_cell c_two"><span>Статус</span></div>
                <div class="fin_cell c_two"><span>Дата</span></div>
            </div>

            <div class="order_lines">
                <?php if(isset($payment) && !empty($payment)): ?>
                <?php foreach($payment as $item): ?>
                <div class="order_line">
                    <div class="fin_cell c_one">
                        <span style="display:none;">
                            <a href="#"><?= $t->_('orders') ?> №12345</a>
                        </span>
                    </div>
                    <div class="fin_cell c_two money">
                        <?php if($item['amount'] > 0): ?>
                        <span class="count" data-count="<?= $item['amount'] ?>"><?= $item['amount'] ?></span> грн.
                        <?php endif; ?>
                    </div>
                    <div class="fin_cell c_two money">
                        <?php if($item['amount'] < 0): ?>
                        <span class="pay" data-pay="<?= -$item['amount'] ?>"><?= -$item['amount'] ?></span> грн.
                        <?php endif; ?>
                    </div>
                    <div style="color: #333" class="fin_cell c_two money">
                        <?= $t->_($item['type']) ?>
                    </div>
                    <div style="color: #333" class="date fin_cell c_two money" data-date="<?= date('d.m.Y', strtotime($item['date'])) ?>">
                        <?= date('d.m.Y', strtotime($item['date'])) ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="lines_final">
                <div class="line final_one">
                    <div style="box-sizing:border-box;height: 39px;width: 171px;max-width: 171px" class="fin_cell c_one"><span><?= $t->_('sum') ?></span></div>
                    <div class="fin_cell c_two money"><span id="sum"><?= $sum_order ?></span> грн.</div>
                    <div class="fin_cell c_two money"><span id="paid"><?= $sum_paid ?></span> грн.</div>
                </div>
                <div class="line final_two">
                    <div class="fin_cell c_one"><span>Сальдо</span></div>
                    <div class="fin_cell balance"><span id="result"><?= $sum_paid - $sum_order ?></span> грн.</div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="/plugins/daterangepicker/moment.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    moment.locale('ru', {
        months : 'январь_февраль_март_апрель_май_июнь_июль_август_сентябрь_октябрь_ноябрь_декабрь'.split('_'),
        monthsShort :'янв._февр._мар._апр._мая_июня_июля_авг._сент._окт._нояб._дек.'.split('_'),
        weekdays : 'воскресенье_понедельник_вторник_среда_четверг_пятница_суббота'.split('_'),
        weekdaysShort : 'вс_пн_вт_ср_чт_пт_сб'.split('_'),
        weekdaysMin : 'вс_пн_вт_ср_чт_пт_сб'.split('_'),
        longDateFormat : {
            LT : 'HH:mm',
            LTS : 'HH:mm:ss',
            L : 'DD.MM.YYYY',
            LL : 'D MMMM YYYY г.',
            LLL : 'D MMMM YYYY г., HH:mm',
            LLLL : 'dddd, D MMMM YYYY г., HH:mm'
        },
        calendar : {
            sameDay: '[Сегодня в] LT',
            nextDay: '[Завтра в] LT',
            lastDay: '[Вчера в] LT',
            nextWeek: function (now) {
                if (now.week() !== this.week()) {
                    switch (this.day()) {
                        case 0:
                            return '[В следующее] dddd [в] LT';
                        case 1:
                        case 2:
                        case 4:
                            return '[В следующий] dddd [в] LT';
                        case 3:
                        case 5:
                        case 6:
                            return '[В следующую] dddd [в] LT';
                    }
                } else {
                    if (this.day() === 2) {
                        return '[Во] dddd [в] LT';
                    } else {
                        return '[В] dddd [в] LT';
                    }
                }
            },
            relativeTime : {
                future : 'через %s',
                past : '%s назад',
                s : 'несколько секунд',
                h : 'час',
                d : 'день',
                M : 'месяц',
                y : 'год'
            },
            ordinalParse: /\d{1,2}-(й|го|я)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'M':
                    case 'd':
                    case 'DDD':
                        return number + '-й';
                    case 'D':
                        return number + '-го';
                    case 'w':
                    case 'W':
                        return number + '-я';
                    default:
                        return number;
                }
            },
            meridiemParse: /ночи|утра|дня|вечера/i,
            isPM : function (input) {
                return /^(дня|вечера)$/.test(input);
            },
        // in case the meridiem units are not separated around 12, then implement
        // this function (look at locale/id.js for an example)
        // meridiemHour : function (hour, meridiem) {
        //     return /* 0-23 hour, given meridiem token and hour 1-12 */
        // },
        },
        meridiem : function (hour, minute, isLower) {
            if (hour < 4) {
                return 'ночи';
            } else if (hour < 12) {
                return 'утра';
            } else if (hour < 17) {
                return 'дня';
            } else {
                return 'вечера';
            }
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 7  // The week that contains Jan 1st is the first week of the year.
        }
    });
    moment.locale('ru');
    //Date range picker


    var full_saldo = <?= $sum_paid - $sum_order ?>;




    var result = [];
    $(".order_lines").find(".order_line").each(function(){
        result[result.length] = this;
    });


    var min_date = $(result[0]).find(".date").data('date');

    var conf = {startDate:moment(min_date, "DD.MM.YYYY"), format: 'DD.MM.YYYY',locale:
    {
        applyLabel: "<?= $t->_('apply')?>",
        cancelLabel: "<?= $t->_('cancel')?>",
        fromLabel: "<?= $t->_('from_month') ?>",
        toLabel: "По",
        weekLabel: 'Н'
    }};
    $('#reservation').daterangepicker(conf);
    $('#DateReservation').daterangepicker(conf);

    $("body").on("click",".applyBtn",function(){
        $(".line.final_two.added").remove();

        var start = $("input[name=daterangepicker_start]").val();
        var end = $("input[name=daterangepicker_end]").val();
        var count = result.length;
        var sum = 0;
        var paid = 0;
        for(var i=0; i<count; i++){
            var date_val = $(result[i]).find(".date").data('date');
            if(moment(date_val, 'DD.MM.YYYY' ) >= moment(start, 'DD.MM.YYYY' ) && moment(date_val, 'DD.MM.YYYY' ) <= moment(end, 'DD.MM.YYYY' ) ) {
                $(result[i]).css("display","block");
                sum += $(result[i]).find(".count").data("count") ? +$(result[i]).find(".count").data("count") : 0;

                paid += $(result[i]).find(".pay").data("pay") ? +$(result[i]).find(".pay").data("pay") : 0;

            } else {
                $(result[i]).css("display","none");
            }
        }
        $("#paid").html(paid.toFixed(1));
        $("#sum").html(sum.toFixed(1));
        $("#result").html((sum-paid).toFixed(1));
        $(".line.final_two .fin_cell.c_one span").html('Сальдо <?= $t->_('saldo_period') ?>');
        $(".fin_content .lines_final").append('<div class="line final_two added"><div class="fin_cell c_one"><span>Сальдо</span></div><div class="fin_cell balance"><span id="result">'+full_saldo+'</span> грн.</div></div>');
    });
    $('#DateReservation');

    $('.orders_data_request').click(function(){
        var date_value = $('#reservation').val();
        $("#DateReservation").val(date_value);
    })

</script>