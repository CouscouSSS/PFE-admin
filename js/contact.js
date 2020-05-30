$(document).ready(function(){
    
    (function($) {
        "use strict";

    
    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                subject: {
                    required: true,
                    minlength: 4
                },
                number: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: {
                name: {
                    required: "<span style=\" color:red; font-weight:500;\"> *come on, you have a name, don't you? </span>",
                    minlength: "<span style=\" color:red; font-weight:500;\"> *your name must consist of at least 2 characters </span>"
                },
                subject: {
                    required: "<span style=\" color:red; font-weight:500;\"> *come on, you have a subject, don't you? </span> ",
                    minlength: "<span style=\" color:red; font-weight:500;\"> *your subject must consist of at least 4 characters </span>"
                },
                email: {
                    required: "<span style=\" color:red; font-weight:500;\"> *no email, no message </span>"
                },
                message: {
                    required: "<span style=\" color:red; font-weight:500;\"> *um...yea, you have to write something to send this form. </span>",
                    minlength: "<span style=\" color:red; font-weight:500;\"> *thats all? really? </span>"
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url:"contact_process.php",
                    success: function() {
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn()
                            $('.modal').modal('hide');
		                	$('#success').modal('show');
                        })
                    },
                    error: function() {
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $('#error').fadeIn()
                            $('.modal').modal('hide');
		                	$('#error').modal('show');
                        })
                    }
                })
            }
        })
    })
        
 })(jQuery)
})