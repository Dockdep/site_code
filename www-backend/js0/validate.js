$(document).ready(function()
{



    function checkStatus(data, form){
        var status = data.prop("checked");

        if( status )
        {
            $(form).validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        remote: {
                            url: "/check_ajax_data",
                            type: "get",
                            data: {
                                name: function() {
                                    return $( "#name" ).val();
                                },
                                id: function() {
                                    var new_id = $( "#id" ).val();
                                    if(new_id){
                                        return new_id;
                                    } else {
                                        return 0;
                                    }
                                }
                            }
                            }
                    },
                    page_meta_title_1:{
                        required: true
                    },
                    template_name: {
                        required: true,
                        maxlength: 255
                    },
                    template_title: {
                        required: true,
                        maxlength: 255
                    },
                    utm_source: {
                        required: true,
                        maxlength: 255
                    },
                    utm_medium: {
                        required: true,
                        maxlength: 255
                    },
                    utm_content: {
                        required: false,
                        maxlength: 255
                    },
                    utm_campaign: {
                        required: true,
                        maxlength: 255
                    }
                },
                messages: {
                    name: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов",
                        remote: "Это название уже занятно"
                    },
                    template_name: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов"
                    },
                    template_title: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов"
                    },
                    utm_source: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов"
                    },
                    utm_medium: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов"
                    },
                    utm_content: {
                        maxlength: "Поле содержит слишком много символов"
                    },
                    utm_campaign: {
                        required: "Это обязательное поле.",
                        maxlength: "Поле содержит слишком много символов"
                    }
                }
            });
        } else {

            var setting = $(form).validate().settings;
            delete setting.rules.utm_source;
            delete setting.messages.utm_source;

            delete setting.rules.utm_medium;
            delete setting.messages.utm_medium;

            delete setting.rules.utm_term;
            delete setting.messages.utm_term;

            delete setting.rules.utm_content;
            delete setting.messages.utm_content;

            delete setting.rules.utm_campaign;
            delete setting.messages.utm_campaign;


        }
    }

    var form = $('#email_event_add_edit');
    var data = $('#utm_status');

    checkStatus(data, form);

    data.change(function(){
        checkStatus(data, form);
    });

    form.submit(function(){
        return $(this).valid();
    });



    ///////////////////////////////////////////////////////////////////////

});