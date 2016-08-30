$(document).ready(function(){
        $('#firstChar').keypress(function(e) {
        if (!(e.which==8 ||(e.which>47 && e.which<58))) return false;

    });

    /*******************/
    function getRemote() {
        return $.ajax({
            type: "GET",
            url: '/gazonnye_travy_1c_20/semena_gazonnykh_trav_1c_21/ru?calc=1',
            async: false
        }).responseText;
    }
    var priceList = JSON.parse(getRemote());
    console.log(priceList);
    console.log(priceList.p_list_88[1]);
    var pr_list_1_1 = priceList.p_list_88[1];
    var pr_list_1_2 = priceList.p_list_88[2];
    var pr_list_2_1 = priceList.p_list_89[1];
    var pr_list_2_2 = priceList.p_list_89[2];
    var pr_list_2_3 = priceList.p_list_89[3];
    var pr_list_3_1 = priceList.p_list_90[1];
    var pr_list_3_2 = priceList.p_list_90[2];
    var pr_list_3_3 = priceList.p_list_90[3];
    var pr_list_4_1 = priceList.p_list_87[1];
    var pr_list_4_2 = priceList.p_list_87[2];
    var pr_list_4_3 = priceList.p_list_87[3];
    var pr_list_5_1 = priceList.p_list_91[1];
    var pr_list_5_2 = priceList.p_list_91[2];
    var pr_list_5_3 = priceList.p_list_91[3];
    var pr_list_6_1 = priceList.p_list_52[1];
    var pr_list_6_2 = priceList.p_list_52[2];
    var pr_list_6_3 = priceList.p_list_52[3];
    var pr_list_7_1 = priceList.p_list_92[1];
    var pr_list_7_2 = priceList.p_list_92[2];
    var pr_list_7_3 = priceList.p_list_92[3];
    var pr_list_7_4 = priceList.p_list_92[4];

    /*******************/

        function countBill(object){
        var value = $(object).val();
        var price1_1 = $("#price-first-one span");
        var price1_2 =$("#price-first-two span");
        var price2_1 =$("#price-second-one span");
        var price2_2 =$("#price-second-two span");
        var price2_3 =$("#price-second-three span");
        var price3_1 =$("#price-three-one span");
        var price3_2 =$("#price-three-two span");
        var price3_3 =$("#price-three-three span");
        var price4_1 =$("#price-four-one span");
        var price4_2 =$("#price-four-two span");
        var price4_3 =$("#price-four-three span");
        var price5_1 =$("#price-five-one span");
        var price5_2 =$("#price-five-two span");
        var price5_3 =$("#price-five-three span");
        var price6_1 =$("#price-six-one span");
        var price6_2 =$("#price-six-two span");
        var price6_3 =$("#price-six-three span");
        var price7_1 =$("#price-seven-one span");
        var price7_2 =$("#price-seven-two span");
        var price7_3 =$("#price-seven-three span");
        var price7_4 =$("#price-seven-four span");
        var r_volume1 = $('.form-recomended-wrap-pic-text #price-val-1');
        var r_volume2 = $('.form-recomended-wrap-pic-text #price-val-2');
        var r_volume3 = $('.form-recomended-wrap-pic-text #price-val-3');
        var r_volume4 = $('.form-recomended-wrap-pic-text #price-val-4');
        var r_volume5 = $('.form-recomended-wrap-pic-text #price-val-5');
        var r_volume6 = $('.form-recomended-wrap-pic-text #price-val-6');
        var r_volume7 = $('.form-recomended-wrap-pic-text #price-val-7');
        var r_quantity1 = $('.form-recomended-wrap-pic-text-2 #price-qua-1');
        var r_quantity2 = $('.form-recomended-wrap-pic-text-2 #price-qua-2');
        var r_quantity3 = $('.form-recomended-wrap-pic-text-2 #price-qua-3');
        var r_quantity4 = $('.form-recomended-wrap-pic-text-2 #price-qua-4');
        var r_quantity5 = $('.form-recomended-wrap-pic-text-2 #price-qua-5');
        var r_quantity6 = $('.form-recomended-wrap-pic-text-2 #price-qua-6');
        var r_quantity7 = $('.form-recomended-wrap-pic-text-2 #price-qua-7');
        var v1 = 2.5;
        var v2 = 25;
        var v3 = 500;
        /*-----------semena-1------------*/
        var pe1_1 = (Math.ceil(value * 1 / v1) * pr_list_1_1).toFixed(2);
        var pe1_2 = (Math.ceil(value * 1 / v3) * pr_list_1_2).toFixed(2);
        if (+pe1_1 < +pe1_2) {
            r_volume1.html('50 г');
            r_quantity1.html('x ' + (pe1_1/pr_list_1_1).toFixed(0) + ' шт');
            $("#price-first-one").css({display:"block"});
            $("#price-first-two").css({display:"none"});
            price1_1.html(pe1_1);
            $('.pr-vol-1').attr('href', '/basket/add/?productID=88&productCount=' + (pe1_1/pr_list_1_1).toFixed(0));
        } else {
            r_volume1.html('10 кг');
            r_quantity1.html('x ' + Math.ceil(pe1_2/pr_list_1_2) + ' шт');
            $("#price-first-one").css({display:"none"});
            $("#price-first-two").css({display:"block"});
            price1_2.html(pe1_2);
            $('.pr-vol-1').attr('href', '/basket/add/?productID=100&productCount=' + (pe1_2/pr_list_1_2).toFixed(0));
        }
        /*-----------semena-2------------*/
        var pe2_1 = (Math.ceil(value * 1 / v1) * pr_list_2_1).toFixed(2);
        var pe2_2 = (Math.ceil(value * 1 / v2) * pr_list_2_2).toFixed(2);
        var pe2_3 = (Math.ceil(value * 1 / v3) * pr_list_2_3).toFixed(2);
        if (+pe2_3 < +pe2_2 && +pe2_3 < +pe2_1) {
            r_volume2.html('20 кг');
            r_quantity2.html('x ' + (pe2_3/pr_list_2_3).toFixed(0) + ' шт');
            price2_3.html(pe2_3);
            $("#price-second-three").css({display:"block"});
            $("#price-second-two").css({display:"none"});
            $("#price-second-one").css({display:"none"});
            $('.pr-vol-2').attr('href', '/basket/add/?productID=94&productCount=' + (pe2_3/pr_list_2_3).toFixed(0));
        } else if (+pe2_2 < +pe2_1 && +pe2_2 < +pe2_3) {
            r_volume2.html('1кг');
            r_quantity2.html('x ' + (pe2_2/pr_list_2_2).toFixed(0) + ' шт');
            price2_2.html(pe2_2);
            $("#price-second-two").css({display:"block"});
            $("#price-second-three").css({display:"none"});
            $("#price-second-one").css({display:"none"});
            $('.pr-vol-2').attr('href', '/basket/add/?productID=99&productCount=' + (pe2_2/pr_list_2_2).toFixed(0));
        } else if (+pe2_1 < +pe2_2 && +pe2_1 < +pe2_3) {
            r_volume2.html('100 г');
            r_quantity2.html('x ' + (pe2_1/pr_list_2_1).toFixed(0) + ' шт');
            price2_1.html(pe2_1);
            $("#price-second-one").css({display:"block"});
            $("#price-second-three").css({display:"none"});
            $("#price-second-two").css({display:"none"});
            $('.pr-vol-2').attr('href', '/basket/add/?productID=89&productCount=' + (pe2_1/pr_list_2_1).toFixed(0));
        }
        /*-----------semena-3------------*/
        var pe3_1 = (Math.ceil(value * 1 / v1) * pr_list_3_1).toFixed(2);
        var pe3_2 = (Math.ceil(value * 1 / v2) * pr_list_3_2).toFixed(2);
        var pe3_3 = (Math.ceil(value * 1 / v3) * pr_list_3_3).toFixed(2);
        if (+pe3_3 < +pe3_2 && +pe3_3 < +pe3_1) {
            r_volume3.html('20 кг');
            r_quantity3.html('x ' + (pe3_3/pr_list_3_3).toFixed(0) + ' шт');
            price3_3.html(pe3_3);
            $("#price-three-three").css({display:"block"});
            $("#price-three-one").css({display:"none"});
            $("#price-three-two").css({display:"none"});
            $('.pr-vol-3').attr('href', '/basket/add/?productID=95&productCount=' + (pe3_3/pr_list_3_3).toFixed(0));
        } else if (+pe3_2 < +pe3_1 && +pe3_2 < +pe3_3) {
            r_volume3.html('1кг');
            r_quantity3.html('x ' + (pe3_2/pr_list_3_2).toFixed(0) + ' шт');
            price3_2.html(pe3_2);
            $("#price-three-two").css({display:"block"});
            $("#price-three-one").css({display:"none"});
            $("#price-three-three").css({display:"none"});
            $('.pr-vol-3').attr('href', '/basket/add/?productID=97&productCount=' + (pe3_2/pr_list_3_2).toFixed(0));
        } else if (+pe3_1 < +pe3_2 && +pe3_1 < +pe3_3) {
            r_volume3.html('100 г');
            r_quantity3.html('x ' + (pe3_1/pr_list_3_1).toFixed(0) + ' шт');
            price3_1.html(pe3_1);
            $("#price-three-one").css({display:"block"});
            $("#price-three-two").css({display:"none"});
            $("#price-three-three").css({display:"none"});
            $('.pr-vol-3').attr('href', '/basket/add/?productID=90&productCount=' + (pe3_1/pr_list_3_1).toFixed(0));
        }
        /*-----------semena-4------------*/
        var pe4_1 = (Math.ceil(value * 1 / v1) * pr_list_4_1).toFixed(2);
        var pe4_2 = (Math.ceil(value * 1 / v2) * pr_list_4_2).toFixed(2);
        var pe4_3 = (Math.ceil(value * 1 / v3) * pr_list_4_3).toFixed(2);
        if (+pe4_3 < +pe4_2 && +pe4_3 < +pe4_1) {
            r_volume4.html('20 кг');
            r_quantity4.html('x ' + (pe4_3/pr_list_4_3).toFixed(0) + ' шт');
            price4_3.html(pe4_3);
            $("#price-four-one").css({display:"none"});
            $("#price-four-two").css({display:"none"});
            $("#price-four-three").css({display:"block"});
            $('.pr-vol-4').attr('href', '/basket/add/?productID=85&productCount=' + (pe4_3/pr_list_4_3).toFixed(0));
        } else if (+pe4_2 < +pe4_1 && +pe4_2 < +pe4_3) {
            r_volume4.html('1кг');
            r_quantity4.html('x ' + (pe4_2/pr_list_4_2).toFixed(0) + ' шт');
            price4_2.html(pe4_2);
            $("#price-four-one").css({display:"none"});
            $("#price-four-two").css({display:"block"});
            $("#price-four-three").css({display:"none"});
            $('.pr-vol-4').attr('href', '/basket/add/?productID=84&productCount=' + (pe4_2/pr_list_4_2).toFixed(0));
        } else if (+pe4_1 < +pe4_2 && +pe4_1 < +pe4_3) {
            r_volume4.html('100 г');
            r_quantity4.html('x ' + (pe4_1/pr_list_4_1).toFixed(0) + ' шт');
            price4_1.html(pe4_1);
            $("#price-four-one").css({display:"block"});
            $("#price-four-two").css({display:"none"});
            $("#price-four-three").css({display:"none"});
            $('.pr-vol-4').attr('href', '/basket/add/?productID=87&productCount=' + (pe4_1/pr_list_4_1).toFixed(0));

        }
        /*-----------semena-5------------*/
        var pe5_1 = (Math.ceil(value * 1 / v1) * pr_list_5_1).toFixed(2);
        var pe5_2 = (Math.ceil(value * 1 / v2) * pr_list_5_2).toFixed(2);
        var pe5_3 = (Math.ceil(value * 1 / v3) * pr_list_5_3).toFixed(2);
        if (+pe5_3 < +pe5_2 && +pe5_3 < +pe5_1) {
            r_volume5.html('20 кг');
            r_quantity5.html('x ' + (pe5_3/pr_list_5_3).toFixed(0) + ' шт');
            price5_3.html(pe5_3);
            $("#price-five-one").css({display:"none"});
            $("#price-five-two").css({display:"none"});
            $("#price-five-three").css({display:"block"});
            $('.pr-vol-5').attr('href', '/basket/add/?productID=96&productCount=' + (pe5_3/pr_list_5_3).toFixed(0));
        } else if (+pe5_2 < +pe5_1 && +pe5_2 < +pe5_3) {
            r_volume5.html('1кг');
            r_quantity5.html('x ' + (pe5_2/pr_list_5_2).toFixed(0) + ' шт');
            price5_2.html(pe5_2);
            $("#price-five-one").css({display:"none"});
            $("#price-five-two").css({display:"block"});
            $("#price-five-three").css({display:"none"});
            $('.pr-vol-5').attr('href', '/basket/add/?productID=98&productCount=' + (pe5_2/pr_list_5_2).toFixed(0));
        } else if (+pe5_1 < +pe5_2 && +pe5_1 < +pe5_3) {
            r_volume5.html('100 г');
            r_quantity5.html('x ' + (pe5_1/pr_list_5_1).toFixed(0) + ' шт');
            price5_1.html(pe5_1);
            $("#price-five-one").css({display:"block"});
            $("#price-five-two").css({display:"none"});
            $("#price-five-three").css({display:"none"});
            $('.pr-vol-5').attr('href', '/basket/add/?productID=91&productCount=' + (pe5_1/pr_list_5_1).toFixed(0));
        }
        /*-----------semena-6------------*/
        var pe6_1 = (Math.ceil(value * 1 / v1) * pr_list_6_1).toFixed(2);
        var pe6_2 = (Math.ceil(value * 1 / v2) * pr_list_6_2).toFixed(2);
        var pe6_3 = (Math.ceil(value * 1 / v3) * pr_list_6_3).toFixed(2);
        if (+pe6_3 < +pe6_2 && +pe6_3 < +pe6_1) {
            r_volume6.html('20 кг');
            r_quantity6.html('x ' + (pe6_1/pr_list_6_3).toFixed(0) + ' шт');
            price6_3.html(pe6_3);
            $("#price-six-one").css({display:"none"});
            $("#price-six-two").css({display:"none"});
            $("#price-six-three").css({display:"block"});
            $('.pr-vol-6').attr('href', '/basket/add/?productID=54&productCount=' + (pe6_3/pr_list_6_3).toFixed(0));
        } else if (+pe6_2 < +pe6_1 && +pe6_2 < +pe6_3) {
            r_volume6.html('1кг');
            r_quantity6.html('x ' + (pe6_2/pr_list_6_2).toFixed(0) + ' шт');
            price6_2.html(pe6_2);
            $("#price-six-one").css({display:"none"});
            $("#price-six-two").css({display:"block"});
            $("#price-six-three").css({display:"none"});
            $('.pr-vol-6').attr('href', '/basket/add/?productID=53&productCount=' + (pe6_2/pr_list_6_2).toFixed(0));
        } else if (+pe6_1 < +pe6_2 && +pe6_1 < +pe6_3) {
            r_volume6.html('100 г');
            r_quantity6.html('x ' + (pe6_1/pr_list_6_1).toFixed(0) + ' шт');
            price6_1.html(pe6_1);
            $("#price-six-one").css({display:"block"});
            $("#price-six-two").css({display:"none"});
            $("#price-six-three").css({display:"none"});
            $('.pr-vol-6').attr('href', '/basket/add/?productID=52&productCount=' + (pe6_1/pr_list_6_1).toFixed(0));
        }
        /*-----------semena-7------------*/
        var pe7_1 = (Math.ceil(value * 1 / v1) * pr_list_7_1).toFixed(2);
        var pe7_2 = (Math.ceil(value * 1 / v3) * pr_list_7_2).toFixed(2);
        var pe7_3 = (Math.ceil(value * 1 / 5000) * pr_list_7_3).toFixed(2);
        var pe7_4 = (Math.ceil(value * 1 / 10000) * pr_list_7_4).toFixed(2);
            console.log('---st---');
            console.log('1--' + pe7_1);
            console.log('2--' + pe7_2);
            console.log('3--' + pe7_3);
            console.log('4--' + pe7_4);
            console.log('---end---');
        if (+pe7_4 < +pe7_3 && +pe7_4 < +pe7_2 && +pe7_4 < +pe7_1) {
            r_volume7.html('20 кг');
            r_quantity7.html('x ' + (pe7_4/pr_list_7_4).toFixed(0) + ' шт');
            price7_4.html(pe7_4);
            $("#price-seven-two").css({display:"none"});
            $("#price-seven-one").css({display:"none"});
            $("#price-seven-three").css({display:"none"});
            $("#price-seven-four").css({display:"block"});
            $('.pr-vol-7').attr('href', '/basket/add/?productID=86&productCount=' + (pe7_4/pr_list_7_4).toFixed(0));
        } else if (+pe7_3 < +pe7_4 && +pe7_3 < +pe7_2 && +pe7_3 < +pe7_1) {
            r_volume7.html('10 кг');
            r_quantity7.html('x ' + (pe7_3/pr_list_7_3).toFixed(0) + ' шт');
            price7_3.html(pe7_3);
            $("#price-seven-two").css({display:"none"});
            $("#price-seven-one").css({display:"none"});
            $("#price-seven-three").css({display:"block"});
            $("#price-seven-four").css({display:"none"});
            $('.pr-vol-7').attr('href', '/basket/add/?productID=2790&productCount=' + (pe7_3/pr_list_7_3).toFixed(0));
        } else if (+pe7_2 < +pe7_4 && +pe7_2 < +pe7_3 && +pe7_2 < +pe7_1) {
            r_volume7.html('1кг');
            r_quantity7.html('x ' + (pe7_2/pr_list_7_2).toFixed(0) + ' шт');
            price7_2.html(pe7_2);
            $("#price-seven-two").css({display:"block"});
            $("#price-seven-one").css({display:"none"});
            $("#price-seven-three").css({display:"none"});
            $("#price-seven-four").css({display:"none"});
            $('.pr-vol-7').attr('href', '/basket/add/?productID=2789&productCount=' + (pe7_2/pr_list_7_2).toFixed(0));
        } else if (+pe7_1 < +pe7_4 && +pe7_1 < +pe7_3 && +pe7_1 < +pe7_2){
            r_volume7.html('50 г');
            r_quantity7.html('x ' + (pe7_1/pr_list_7_1).toFixed(0) + ' шт');
            price7_1.html(pe7_1);
            $("#price-seven-one").css({display:"block"});
            $("#price-seven-two").css({display:"none"});
            $("#price-seven-three").css({display:"none"});
            $("#price-seven-four").css({display:"none"});
            $('.pr-vol-7').attr('href', '/basket/add/?productID=92&productCount=' + (pe7_1/pr_list_7_1).toFixed(0));
        }
        /*-----------end-semena------------*/

    }
    $("#firstChar").keyup(function () {
        countBill(this);
    }).keyup();
    /*-----------track------------*/
    function setCalck(r) {
        if (r != null) {
            $("#firstChar").val(r);
            countBill("#firstChar")
        }
    }
    $('#track').trackbar({
        onMove : function() {
            setCalck(this.leftValue);
        },
        dual : false, // two intervals
        width : 217, // px
        leftLimit : 1, // unit of value
        leftValue : 1, // unit of value
        rightLimit : 10000, // unit of value
        rightValue : 1, // unit of value
        hehe : ":-)"
    });
    /*-----------end-track------------*/
    function buttonNextPrice() {
        var ab = $('#ul1').children('li').eq(0).attr('id');
        var ab1 = $('#display-1').attr('id');
        var ab2 = $('#display-2').attr('id');
        var ab3 = $('#display-3').attr('id');
        var ab4 = $('#display-4').attr('id');
        var ab5 = $('#display-5').attr('id');
        var ab6 = $('#display-6').attr('id');
        var ab7 = $('#display-7').attr('id');
        //console.log(ab + ' ' + ab4);
        if (ab == ab1) {
            $('#price-val-2, #price-val-3, #price-val-4, #price-val-5, #price-val-6, #price-val-7').css({display: "none"});
            $('#price-qua-2, #price-qua-3, #price-qua-4, #price-qua-5, #price-qua-6, #price-qua-7').css({display: "none"});
            $('#price-f2, #price-f3, #price-f4, #price-f5, #price-f6, #price-f7').css({display: "none"});
            $('.pr-vol-2, .pr-vol-3, .pr-vol-4, .pr-vol-5, .pr-vol-6, .pr-vol-7').css({display: "none"});
            $('#price-val-1, #price-qua-1, #price-f1, .pr-vol-1').css({display: "block"});
            console.log('price1')

        } else if ((ab == ab2)) {
            $('#price-val-2, #price-qua-2, #price-f2, .pr-vol-2').css({display: "block"});
            $('#price-val-1, #price-val-4, #price-val-3, #price-val-5, #price-val-6, #price-val-7').css({display: "none"});
            $('#price-qua-1, #price-qua-4, #price-qua-3, #price-qua-5, #price-qua-6, #price-qua-7').css({display: "none"});
            $('#price-f1, #price-f3, #price-f4, #price-f5, #price-f6, #price-f7').css({display: "none"});
            $('.pr-vol-1, .pr-vol-3, .pr-vol-4, .pr-vol-5, .pr-vol-6, .pr-vol-7').css({display: "none"});
            console.log('price2')

        }else if ((ab == ab3)) {
            $('#price-val-3, #price-qua-3, #price-f3, .pr-vol-3').css({display: "block"});
            $('#price-val-1, #price-val-2, #price-val-4, #price-val-5, #price-val-6, #price-val-7').css({display: "none"});
            $('#price-qua-1, #price-qua-2, #price-qua-4, #price-qua-5, #price-qua-6, #price-qua-7').css({display: "none"});
            $('#price-f1, #price-f2, #price-f4, #price-f5, #price-f6, #price-f7').css({display: "none"});
            $('.pr-vol-1, .pr-vol-2, .pr-vol-4, .pr-vol-5, .pr-vol-6, .pr-vol-7').css({display: "none"});
            console.log('price3')
        }
        else if ((ab == ab4)) {
            $('#price-val-4, #price-qua-4, #price-f4, .pr-vol-4').css({display: "block"});
            $('#price-val-1, #price-val-2, #price-val-3, #price-val-5, #price-val-6, #price-val-7').css({display: "none"});
            $('#price-qua-1, #price-qua-2, #price-qua-3, #price-qua-5, #price-qua-6, #price-qua-7').css({display: "none"});
            $('#price-f1, #price-f2, #price-f3, #price-f5, #price-f6, #price-f7').css({display: "none"});
            $('.pr-vol-1, .pr-vol-2, .pr-vol-3, .pr-vol-5, .pr-vol-6, .pr-vol-7').css({display: "none"});
            console.log('price4')

        }else if ((ab == ab5)) {
            $('#price-val-5, #price-qua-5, #price-f5, .pr-vol-5').css({display: "block"});
            $('#price-val-1, #price-val-2, #price-val-3, #price-val-4, #price-val-6, #price-val-7').css({display: "none"});
            $('#price-qua-1, #price-qua-2, #price-qua-3, #price-qua-4, #price-qua-6, #price-qua-7').css({display: "none"});
            $('#price-f1, #price-f2, #price-f3, #price-f4, #price-f6, #price-f7').css({display: "none"});
            $('.pr-vol-1, .pr-vol-2, .pr-vol-3, .pr-vol-4, .pr-vol-6, .pr-vol-7').css({display: "none"});
            console.log('price5')
        }
        else if ((ab == ab6)) {
            $('#price-val-6, #price-qua-6, #price-f6, .pr-vol-6').css({display: "block"});
            $('#price-val-1, #price-val-2, #price-val-3, #price-val-5, #price-val-4, #price-val-7').css({display: "none"});
            $('#price-qua-1, #price-qua-2, #price-qua-3, #price-qua-5, #price-qua-4, #price-qua-7').css({display: "none"});
            $('#price-f1, #price-f2, #price-f3, #price-f4, #price-f5, #price-f7').css({display: "none"});
            $('.pr-vol-1, .pr-vol-2, .pr-vol-3, .pr-vol-4, .pr-vol-5, .pr-vol-7').css({display: "none"});
            console.log('price6')
        }
        else if ((ab == ab7)) {
            $('#price-val-7, #price-qua-7, #price-f7, .pr-vol-7').css({display: "block"});
            $('#price-val-1, #price-val-2, #price-val-3, #price-val-5, #price-val-4, #price-val-6').css({display: "none"});
            $('#price-qua-1, #price-qua-2, #price-qua-3, #price-qua-5, #price-qua-4, #price-qua-6').css({display: "none"});
            $('#price-f1, #price-f2, #price-f3, #price-f4, #price-f5, #price-f6').css({display: "none"});
            $('.pr-vol-1, .pr-vol-2, .pr-vol-3, .pr-vol-4, .pr-vol-5, .pr-vol-6').css({display: "none"});
            console.log('price7')
        }
    }
   // $('.form-arrows-right-wr').click(function (e) {
       // e.preventDefault();
        //buttonNextPrice();
   // });

  //  $('.form-arrows-left-wr').click(function (e) {
     //   e.preventDefault();
        //buttonNextPrice();

   // });
    $( "input:radio" ).click(function() {
        buttonNextPrice();

    });

});




