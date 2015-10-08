@extends('app')

@section('head')
	<link href="/css/login.css" rel="stylesheet">
@stop


@section('content')
	<div class="text-center" style="padding:50px 0">
		<div class="logo">register</div>
		<!-- Main Form -->
		<div class="login-form-1">
			<form id="register-form" class="text-left" method="POST" action="/auth/register">
			    {!! csrf_field() !!}
				<div class="login-form-main-message"></div>
				<div class="main-login-form">
					<div class="login-group">
						<div class="form-group">
							<label for="reg_username" class="sr-only">Name</label>
							<input type="text" class="form-control" id="reg_username" name="name" placeholder="name" value="{{ old('name') }}">
						</div>
						<div class="form-group">
							<label for="reg_email" class="sr-only">Email</label>
							<input type="text" class="form-control" id="reg_email" name="email" value="{{ old('email') }}" placeholder="email">
						</div>
						<div class="form-group">
							<label for="reg_password" class="sr-only">Password</label>
							<input type="password" class="form-control" id="reg_password" name="password" placeholder="password">
						</div>
						<div class="form-group">
							<label for="reg_password_confirm" class="sr-only">Password Confirm</label>
							<input type="password" class="form-control" id="reg_password_confirm" name="password_confirmation" placeholder="confirm password">
						</div>
						
						<div class="form-group login-group-checkbox">
							<input type="checkbox" class="" id="reg_agree" name="reg_agree">
							<label for="reg_agree">i agree with <a href="#" onclick="alert('Hmm...\nNo terms yet, just go with the flow')">terms</a></label>
						</div>
					</div>
					<button type="submit" class="login-button"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
				<div class="etc-login-form">
					<p>already have an account? <a href="#">login here</a></p>
				</div>
			</form>
		</div>
		<!-- end:Main Form -->
	</div>
@stop

@section('footer')

	<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

	<script type="text/javascript">
		(function($) {
		    "use strict";

		    // Options for Message
		    //----------------------------------------------
		    var options = {
		        'btn-loading': '<i class="glyphicon glyphicon-refresh"></i>',
		        'btn-success': '<i class="glyphicon glyphicon-ok"></i>',
		        'btn-error': '<i class="glyphicon glyphicon-remove"></i>',
		        'msg-success': 'All Good! Redirecting...',
		        'msg-error': 'Wrong login credentials!',
		        'useAJAX': true,
		    };

		    // Register Form
		    //----------------------------------------------
		    // Validation
		    $("#register-form").validate({
		        rules: {
		            name: "required",
		            password: {
		                required: true,
		                minlength: 5
		            },
		            password_confirmation: {
		                required: true,
		                minlength: 5,
		                equalTo: "#register-form [name=password]"
		            },
		            email: {
		                required: true,
		                email: true
		            },
		            reg_agree: "required",
		        },
		        errorClass: "form-invalid",
		        errorPlacement: function(label, element) {
		            if (element.attr("type") === "checkbox" || element.attr("type") === "radio") {
		                element.parent().append(label); // this would append the label after all your checkboxes/labels (so the error-label will be the last element in <div class="controls"> )
		            } else {
		                label.insertAfter(element); // standard behaviour
		            }
		        }
		    });

		    // Form Submission
		    $("#register-form").submit(function() {
		        remove_loading($(this));

		        if (options['useAJAX'] == true) {
		            // If you don't want to use AJAX, remove this
		            submit_form($(this));

		            // Cancel the normal submission.
		            // If you don't want to use AJAX, remove this
		            return false;
		        }
		    });

		    // Loading
		    //----------------------------------------------
		    function remove_loading($form) {
		        $form.find('[type=submit]').removeClass('error success');
		        $form.find('.login-form-main-message').removeClass('show error success').html('');
		    }

		    function form_loading($form) {
		        $form.find('[type=submit]').addClass('clicked').html(options['btn-loading']);
		    }

		    function form_success($form) {
		        $form.find('[type=submit]').addClass('success').html(options['btn-success']);
		        $form.find('.login-form-main-message').addClass('show success').html(options['msg-success']);
		    }

		    function form_failed($form) {
		        $form.find('[type=submit]').addClass('error').html(options['btn-error']);
		        $form.find('.login-form-main-message').addClass('show error').html(options['msg-error']);
		    }

		    function submit_form($form) {
		        if ($form.valid()) {
		            form_loading($form);

		            $.ajax({
		                type: 'post',
		                cache: false,
		                dataType: 'json',
		                data: $form.serialize(),
		                success: function(data) {
		                	console.log("AJAX success:");
		                	console.log(data);
		                	if (data.success) {
		                		form_success($form);
			                    setTimeout(function() {
			                        window.location = data.redirectPath;
			                    }, 10);
		                	} else {
		                		form_failed($form);
		                		var errors = JSON.parse(data.errors);
		                		$form.find('.login-form-main-message').html('');
		                		$.each(errors, function(index, value) {
		                			$form.find('.login-form-main-message').append('&nbsp;' + value);
		                		});
		                	};
		                    
		                },
		                error: function(xhr, textStatus, thrownError) {
		                	console.log("AJAX error:");
		                	console.log('xhr:', xhr);
		                	console.log('textStatus:', textStatus);
		                	console.log('thrownError:', thrownError);
		                    form_failed($form);
	                        $form.find('.login-form-main-message').html("There seems to be an error on our end and we're working on it. Please try again later.");
		                }
		            });
		        }
		    }

		})(jQuery);
	</script>
@stop

