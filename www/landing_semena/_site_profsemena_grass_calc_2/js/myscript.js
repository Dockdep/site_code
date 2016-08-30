$(document).ready(function(){
    $( "input:radio" ).click(function() {
        var u1 = $("#ul1");
        var r1 = $('#radio1');
        var r2 = $('#radio2');
        var r3 = $('#radio3');
        var r4 = $('#radio4');
        var r5 = $('#radio5');
        var r6 = $('#radio6');
        var r7 = $('#radio7');
        var r8 = $('#radio8');
        var d1 = $("#display-1");
        var d2 = $("#display-2");
        var d3 = $("#display-3");
        var d4 = $("#display-4");
        var d5 = $("#display-5");
        var d6 = $("#display-6");
        var d7 = $("#display-7");

        if($(r1).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    console.log(u1.html());
                }
            }
        }
        if($(r1).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d1).clone().appendTo(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    console.log('112');
                }
            }
        }
        if($(r1).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r8).is(":checked")) {
                    $(u1).empty(u1);
                    $(d1).clone().appendTo(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d1).clone().appendTo(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r8).is(":checked")) {
                    $(u1).empty(u1);
                    $(d1).clone().appendTo(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }

        }
        if($(r3).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r3).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r3).is(":checked")) {
            if($(r4).is(":checked")) {
                if($(r8).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r1).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r1).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    $(d6).clone().appendTo(u1);
                    $(d7).clone().appendTo(u1);
                }
            }
        }
        if($(r1).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r8).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    $(d6).clone().appendTo(u1);
                    $(d7).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    $(d6).clone().appendTo(u1);
                    $(d7).clone().appendTo(u1);
                }
            }
        }
        if($(r2).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r8).is(":checked")) {
                        $(u1).empty();
                        $(d2).clone().appendTo(u1);
                        $(d3).clone().appendTo(u1);
                        $(d4).clone().appendTo(u1);
                        $(d5).clone().appendTo(u1);
                        $(d6).clone().appendTo(u1);
                        $(d7).clone().appendTo(u1);
                }
            }
        }
        if($(r3).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r6).is(":checked")) {
                    $(u1).empty(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                }
            }
        }
        if($(r3).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r7).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    $(d6).clone().appendTo(u1);
                }
            }
        }
        if($(r3).is(":checked")) {
            if($(r5).is(":checked")) {
                if($(r8).is(":checked")) {
                    $(u1).empty(u1);
                    $(d2).clone().appendTo(u1);
                    $(d3).clone().appendTo(u1);
                    $(d4).clone().appendTo(u1);
                    $(d5).clone().appendTo(u1);
                    $(d6).clone().appendTo(u1);
                    $(d7).clone().appendTo(u1);
                }
            }
        }

    });
});




