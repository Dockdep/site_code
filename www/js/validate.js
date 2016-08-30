$(document).ready(function()
{
    ///////////////////////////////////////////////////////////////////////

    $('#edit_user_info_ua').validate({
        rules: {
            order_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            order_phone: {
                required: true,
                minlength: 7,
                maxlength: 16
            },
            order_city: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            order_address: {
                required: false,
                minlength: 3,
                maxlength: 255
            }

        },
        messages: {
            order_name: {
                required: "Будь ласка, вкажіть Ваше прізвище",
                minlength: "Ваше прізвище має містити не меньше 3х символів",
                maxlength: "Ваше прізвище містить забагато символів"
            },
            order_phone: {
                required: "Будь ласка, вкажіть Ваш телефон",
                minlength: "Ваш телефон має містити не меньше 7-ми символів",
                maxlength: "Довжина телефону занадто велика"
            },
            order_city: {
                required: "Будь ласка, вкажіть Ваше місто",
                minlength: "Місто має містити не меньше 3х символів",
                maxlength: "Місто містить забагато символів"
            },
            /*order_address: {
                required: "Будь ласка, вкажіть Вашу адресу",
                minlength: "Адреса має містити не меньше 3х символів",
                maxlength: "Адреса містить забагато символів"
            }*/
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#order_add_ua').submit(function()
    {
        var email = $('#order_email').val().length;

        if( email )
        {
            $('#order_add_ua').validate({
                rules: {
                    order_email: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                        email: true
                    },
                    order_second_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_phone: {
                        required: true,
                        minlength: 7,
                        maxlength: 16
                    },
                    order_city: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_address: {
                        required: false,
                        minlength: 3,
                        maxlength: 255
                    }
                },
                messages: {
                    order_email: {
                        required: "Будь ласка, вкажіть Ваш email",
                        minlength: "Ваш email має містити не меньше 3х символів",
                        maxlength: "Ваш email містить забагато символів",
                        email: "Будь ласка, вкажіть валідний email"
                    },
                    order_second_name: {
                        required: "Будь ласка, вкажіть Ваше прізвище",
                        minlength: "Ваше прізвище має містити не меньше 3х символів",
                        maxlength: "Ваше прізвище містить забагато символів"
                    },
                    order_phone: {
                        required: "Будь ласка, вкажіть Ваш телефон",
                        minlength: "Ваш телефон має містити не меньше 7-ми символів",
                        maxlength: "Довжина телефону занадто велика"
                    },
                    order_city: {
                        required: "Будь ласка, вкажіть Ваше місто",
                        minlength: "Місто має містити не меньше 3х символів",
                        maxlength: "Місто містить забагато символів"
                    }
                    /*order_address: {
                        required: "Будь ласка, вкажіть Вашу адресу",
                        minlength: "Адреса має містити не меньше 3х символів",
                        maxlength: "Адреса містить забагато символів"
                    }*/
                }
            });
        }
        else
        {
            $('#order_add_ua').validate({
                rules: {
                    order_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_phone: {
                        required: true,
                        minlength: 7,
                        maxlength: 16
                    },
                    order_city: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_address: {
                        required: false,
                        minlength: 3,
                        maxlength: 255
                    }

                },
                messages: {
                    order_name: {
                        required: "Будь ласка, вкажіть Ваше прізвище",
                        minlength: "Ваше прізвище має містити не меньше 3х символів",
                        maxlength: "Ваше прізвище містить забагато символів"
                    },
                    order_phone: {
                        required: "Будь ласка, вкажіть Ваш телефон",
                        minlength: "Ваш телефон має містити не меньше 7-ми символів",
                        maxlength: "Довжина телефону занадто велика"
                    },
                    order_city: {
                        required: "Будь ласка, вкажіть Ваше місто",
                        minlength: "Місто має містити не меньше 3х символів",
                        maxlength: "Місто містить забагато символів"
                    },
                    /*order_address: {
                        required: "Будь ласка, вкажіть Вашу адресу",
                        minlength: "Адреса має містити не меньше 3х символів",
                        maxlength: "Адреса містить забагато символів"
                    }*/
                }
            });
        }

        if( $('#order_add_ua').valid() )
        {
            return true;
        }

        return false;
    });

    ///////////////////////////////////////////////////////////////////////

    $('#customer_login_ua').validate({
        rules: {
            email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            email: {
                required: "Будь ласка, введіть логін",
                minlength: "Логін має містити не меньше 3х символів",
                maxlength: "Довжина логіну перевищує максимальну",
                email: "Будь ласка, вкажіть валідний email"
            },
            passwd: {
                required: "Будь ласка, введіть пароль",
                minlength: "Пароль має містити не меньше 3х символів",
                maxlength: "Довжина паролю перевищує максимальну"
            }
        }
    });

    $('#customer_login_from_order_ua').validate({
        rules: {
            login_email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            login_passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            login_email: {
                required: "Будь ласка, введіть логін",
                minlength: "Логін має містити не меньше 3х символів",
                maxlength: "Довжина логіну перевищує максимальну",
                email: "Будь ласка, вкажіть валідний email"
            },
            login_passwd: {
                required: "Будь ласка, введіть пароль",
                minlength: "Пароль має містити не меньше 3х символів",
                maxlength: "Довжина паролю перевищує максимальну"
            }
        }
    });

    $('#finish_registration_ua').validate({
        rules: {
            passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            confirm_passwd: {
                required: true,
                equalTo: "#passwd"
            }
        },
        messages: {
            passwd: {
                required: "Будь ласка, введіть пароль",
                minlength: "Пароль має містити не меньше 3х символів",
                maxlength: "Довжина паролю перевищує максимальну"
            },
            confirm_passwd: {
                required: "Будь ласка, підтвердіть пароль",
                equalTo: "Будь ласка, введіть еквівалентний пароль"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#registration_ua').validate({
        rules: {
            registration_name: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            registration_email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            registration_passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            registration_confirm_passwd: {
                required: true,
                equalTo: "#registration_passwd"
            }
        },
        messages: {
            registration_name: {
                required: "Будь ласка, введіть Ваше ім'я",
                minlength: "Ім'я має містити не меньше 3х символів",
                maxlength: "Довжина імені перевищує максимальну"
            },
            registration_email: {
                required: "Будь ласка, введіть email",
                minlength: "email має містити не меньше 3х символів",
                maxlength: "Довжина email перевищує максимальну",
                email: "Будь ласка, вкажіть валідний email"
            },
            registration_passwd: {
                required: "Будь ласка, введіть пароль",
                minlength: "Пароль має містити не меньше 3х символів",
                maxlength: "Довжина паролю перевищує максимальну"
            },
            registration_confirm_passwd: {
                required: "Будь ласка, підтвердіть пароль",
                equalTo: "Будь ласка, введіть еквівалентний пароль"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#restore_passwd_ua').validate({
        rules: {
            email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            }
        },
        messages: {
            email: {
                required: "Будь ласка, введіть email",
                minlength: "email має містити не меньше 3х символів",
                maxlength: "Довжина email перевищує максимальну",
                email: "Будь ласка, вкажіть валідний email"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#callback_ua').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            email: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            comments: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            name: {
                required: "Будь ласка, введіть Ваше ім'я",
                minlength: "Ім'я має містити не меньше 3х символів",
                maxlength: "Довжина імені перевищує максимальну"
            },
            email: {
                required: "Будь ласка, введіть email або телефон",
                minlength: "Email/телефон має містити не меньше 3х символів",
                maxlength: "Довжина email/телефону перевищує максимальну"
            },
            comments: {
                required: "Будь ласка, напишіть комментарій",
                minlength: "Комментарій має містити не меньше 3х символів",
                maxlength: "Довжина комментарію перевищує максимальну"
            }
        }
    });

    //////////////////////////////RU/////////////////////////////////////////


    $('#edit_user_info_ru').validate({
        rules: {
            order_name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            order_phone: {
                required: true,
                minlength: 7,
                maxlength: 16
            },
            order_city: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            order_address: {
                required: false,
                minlength: 3,
                maxlength: 255
            }

        },
        messages: {
            order_name: {
                required: "Будь ласка, вкажіть Ваше прізвище",
                minlength: "Ваше прізвище має містити не меньше 3х символів",
                maxlength: "Ваше прізвище містить забагато символів"
            },
            order_phone: {
                required: "Будь ласка, вкажіть Ваш телефон",
                minlength: "Ваш телефон має містити не меньше 7-ми символів",
                maxlength: "Довжина телефону занадто велика"
            },
            order_city: {
                required: "Будь ласка, вкажіть Ваше місто",
                minlength: "Місто має містити не меньше 3х символів",
                maxlength: "Місто містить забагато символів"
            },
            /*order_address: {
             required: "Будь ласка, вкажіть Вашу адресу",
             minlength: "Адреса має містити не меньше 3х символів",
             maxlength: "Адреса містить забагато символів"
             }*/
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#order_add_ru').submit(function()
    {
        var email = $('#order_email').val().length;

        if( email )
        {
            $('#order_add_ru').validate({
                rules: {
                    order_email: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                        email: true
                    },
                    order_second_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_phone: {
                        required: true,
                        minlength: 7,
                        maxlength: 16
                    },
                    order_city: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_address: {
                        required: false,
                        minlength: 3,
                        maxlength: 255
                    }
                },
                messages: {
                    order_email: {
                        required: "Пожалуйста, укажите Ваш email",
                        minlength: "Ваш email должен содержать не менее 3х символов",
                        maxlength: "Ваш email содержит много символов",
                        email: "Пожалуйста, укажите валидный email"
                    },
                    order_second_name: {
                        required: "Пожалуйста, укажите Вашу фамилию",
                        minlength: "Ваша фамилия должна содержать не менее 3х символов",
                        maxlength: "Ваша фамилия содержит много символов"
                    },
                    order_phone: {
                        required: "Пожалуйста, укажите Ваш телефон",
                        minlength: "Ваш телефон должен содержать не менее 7-ми символов",
                        maxlength: "Длина телефона слишком велика"
                    },
                    order_city: {
                        required: "Пожалуйста, укажите Ваш город",
                        minlength: "Город должен содержать не менее 3х символов",
                        maxlength: "Город содержит много символов"
                    }
                    /*order_address: {
                     required: "Будь ласка, вкажіть Вашу адресу",
                     minlength: "Адреса має містити не меньше 3х символів",
                     maxlength: "Адреса містить забагато символів"
                     }*/
                }
            });
        }
        else
        {
            $('#order_add_ru').validate({
                rules: {
                    order_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_phone: {
                        required: true,
                        minlength: 7,
                        maxlength: 16
                    },
                    order_city: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    order_address: {
                        required: false,
                        minlength: 3,
                        maxlength: 255
                    }

                },
                messages: {
                    order_name: {
                        required: "Пожалуйста, укажите Вашу фамилию",
                        minlength: "Ваша фамилия должна содержать не менее 3х символов",
                        maxlength: "Ваша фамилия содержит много символов"
                    },
                    order_phone: {
                        required: "Пожалуйста, укажите Ваш телефон",
                        minlength: "Ваш телефон должен содержать не менее 7-ми символов",
                        maxlength: "Длина телефона слишком велика"
                    },
                    order_city: {
                        required: "Пожалуйста, укажите Ваш город",
                        minlength: "Город должен содержать не менее 3х символов",
                        maxlength: "Город содержит много символов"
                    },
                    /*order_address: {
                     required: "Будь ласка, вкажіть Вашу адресу",
                     minlength: "Адреса має містити не меньше 3х символів",
                     maxlength: "Адреса містить забагато символів"
                     }*/
                }
            });
        }

        if( $('#order_add_ru').valid() )
        {
            return true;
        }

        return false;
    });

    ///////////////////////////////////////////////////////////////////////

    $('#customer_login_ru').validate({
        rules: {
            email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            email: {
                required: "Пожалуйста, введите логин",
                minlength: "Логин должен содержать не менее 3х символов",
                maxlength: "Длина логина превышет максимальную",
                email: "Пожалуйста, укажите валидный email"
            },
            passwd: {
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать не менее 3х символов",
                maxlength: "Длина пароля превышет максимальную"
            }
        }
    });

    $('#customer_login_from_order_ru').validate({
        rules: {
            login_email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            login_passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            login_email: {
                required: "Пожалуйста, введите логин",
                minlength: "Логин должен содержать не менее 3х символов",
                maxlength: "Длина логина превышет максимальную",
                email: "Пожалуйста, укажите валидный email"
            },
            login_passwd:{
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать не менее 3х символов",
                maxlength: "Длина пароля превышет максимальную"
            }
        }
    });

    $('#finish_registration_ru').validate({
        rules: {
            passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            confirm_passwd: {
                required: true,
                equalTo: "#passwd"
            }
        },
        messages: {
            passwd: {
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать не менее 3х символов",
                maxlength: "Длина пароля превышет максимальную"
            },
            confirm_passwd:{
                required: "Пожалуйста, подтвердите",
                equalTo: "Пожалуйста, введите эквивалентный пароль"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#registration_ru').validate({
        rules: {
            registration_name: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            registration_email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            },
            registration_passwd: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            registration_confirm_passwd: {
                required: true,
                equalTo: "#registration_passwd"
            }
        },
        messages: {
            registration_name: {
                required: "Пожалуйста, введите имя",
                minlength: "Имя должно содержать не менее 3х символов",
                maxlength: "Длина имени превышать максимальную"
            },
            registration_email:{
                required: "Пожалуйста, введите email",
                minlength: "email должен содержать не менее 3х символов",
                maxlength: "Длина email превышаю максимальную",
                email: "Пожалуйста, укажите валидный email"
            },
            registration_passwd:{
                required: "Пожалуйста, введите пароль",
                minlength: "Пароль должен содержать не менее 3х символов",
                maxlength: "Длина пароля превышаю максимальную"
            },
            registration_confirm_passwd:{
                required: "Пожалуйста, подтвердите",
                equalTo: "Пожалуйста, введите эквивалентный пароль"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#restore_passwd_ru').validate({
        rules: {
            email: {
                required: true,
                minlength: 3,
                maxlength: 128,
                email: true
            }
        },
        messages: {
            email: {
                required: "Пожалуйста, введите email",
                minlength: "email должен содержать не менее 3х символов",
                maxlength: "Длина email превышет максимальную",
                email: "Пожалуйста, укажите валидный email"
            }
        }
    });

    ///////////////////////////////////////////////////////////////////////

    $('#callback_ru').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            email: {
                required: true,
                minlength: 3,
                maxlength: 128
            },
            comments: {
                required: true,
                minlength: 3,
                maxlength: 128
            }
        },
        messages: {
            name: {
                required: "Пожалуйста, введите имя",
                minlength: "Имя должно содержать не менее 3х символов",
                maxlength: "Длина имени превышает максимальную"
            },
            email: {
                required: "Пожалуйста, введите email или телефон",
                minlength: "Email / телефон должен содержать не менее 3х символов",
                maxlength: "Длина email / телефону превышет максимальную"
            },
            comments: {
                required: "Пожалуйста, напишите комментарии",
                minlength: "Комментарий должен содержать не менее 3х символов",
                maxlength: "Длина Комментарии превышаю максимальную"
            }
        }
    });
});