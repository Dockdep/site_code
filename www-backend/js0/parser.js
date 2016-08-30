jQuery(document).ready( function(){
    $('#pars-start-button').on('click', function(){
        var parseData = ['Whois','Pr','PageValues','YaBar','Dmoz','IY','IG','Alexa','Semrush','Validator','Majestic','Solomono','CheckDangerous'];
        for(var i=0; i<parseData.length; i++ ) {
            var ajax;
            $.ajax({
                type: "POST",
                url: "/pars_parser",
                data: "name="+parseData[i]+"&site=http://www.bigmir.net/",
                dataType: "text",
                async: false,
                success: function (data){data;}
            });

        }
    });
});
