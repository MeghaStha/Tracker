$(document).ready(function() {

    $(document).mousemove(function(e) {
        TweenLite.to($('body'),
            .5, {
                css: {
                    backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px"
                }
            });
    });

    $("#username").keyup(function(e) {
        var username = $(this).val();
        $.post('./php/checkUsername.php', {
            'username': username
        }, function(data) {
            $("#user-result").html(data);
        });
    });


    $('#defaultForm').on('init.field.bv', function(e, data) {

        var $parent = data.element.parents('.form-group'),
            $icon = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]'),
            options = data.bv.getOptions(), // Entire options
            validators = data.bv.getOptions(data.field).validators; // The field validators

        if (validators.notEmpty && options.feedbackIcons && options.feedbackIcons.required) {
            $icon.addClass(options.feedbackIcons.required).show();
        }
    })


    .bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty.'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: 'The username must be more than 4 and less than 30 characters long. No spaces in between.'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    },
                    different: {
                        field: 'password,confirmPassword',
                        message: 'The username and password cannot be the same as each other'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            phone: {
                validators: {
                    regexp: {
                        regexp: /^[0-9]d{10}$/,
                        message: 'The phone number consist of numbers'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    }
                }
            }
        }
    })

    .on('status.field.bv', function(e, data) {
        // Remove the required icon when the field updates its status
        var $parent = data.element.parents('.form-group'),
            //$icon      = $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]'),
            options = data.bv.getOptions(), // Entire options
            validators = data.bv.getOptions(data.field).validators; // The field validators

        if (validators.notEmpty && options.feedbackIcons && options.feedbackIcons.required) {
            $icon.removeClass(options.feedbackIcons.required).addClass('glyphicon');
        }

        $(".form-group #register").click(function(event) {

            $.ajax({
                type: "POST",
                url: "./php/upload.processor.php",
                data: {
                    username: $("#username").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    password: $("#password").val()
                },
                //dataType:"json",
                success: function() {
                    $("#defaultForm").replaceWith(function() {
                        return $('<p>Successfully Registered</p><button class="btn btn-default btn-lg">Go To Profile Page</button>').click(function(e) {
                            location.href = "./index.php";
                        });
                    });
                    //"Successfully Registered");
                    //window.location.href = './index.php';
                },
                error: function() {}
            });
        });

    });

});