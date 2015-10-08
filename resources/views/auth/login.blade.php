@extends('app')

@section('head')
	<link href="/css/login.css" rel="stylesheet">
@stop

@section('content')
	<div class="text-center" style="padding:50px 0">
		<div class="logo">login</div>
		<!-- Main Form -->
		<div class="login-form-1">
			<form id="login-form" class="text-left" method="POST" action="/auth/login">
			{!! csrf_field() !!}
				<div class="login-form-main-message"></div>
				<div class="main-login-form">
					<div class="login-group">
						<div class="form-group">
							<label for="lg_username" class="sr-only">Email adress</label>
							<input type="email" class="form-control" id="lg_username" name="email" value="{{ old('email') }}" placeholder="email address" required>
						</div>
						<div class="form-group">
							<label for="lg_password" class="sr-only">Password</label>
							<input type="password" class="form-control" id="lg_password" name="password" placeholder="password" required>
						</div>
						<div class="form-group login-group-checkbox">
							<input type="checkbox" id="lg_remember" name="remember">
							<label for="lg_remember">remember</label>
						</div>
					</div>
					<button type="submit" class="login-button"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
				<div class="etc-login-form">
					<p>forgot your password? <a href="#">click here</a></p>
					<p>new user? <a href="#">create new account</a></p>
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

	    // Login Form
	    //----------------------------------------------
	    // Validation
	    $("#login-form").validate({
	        rules: {
	            username: "required",
	            username: "required",
	        },
	        errorClass: "form-invalid"
	    });

	    // Form Submission
	    $("#login-form").submit(function() {
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
                    beforeSend: function() {
                        $("#validation-errors").hide().empty();
                    },
                    success: function(data) {
                        form_success($form);
                        setTimeout(function() {
                        	window.location = data.redirectPath;
                        }, 10);
                    },
                    error: function(xhr, textStatus, thrownError) {
                    	form_failed($form);
                    	if (xhr.status != 401) {
                    		$form.find('.login-form-main-message').html("There seems to be an error on our end and we're working on it. Please try again later.");
	                        console.log("xhr:\t", xhr);
	                        console.log("textStatus: \t", textStatus);
	                        console.log("thrownError: \t", thrownError);
	                    }
                    }
				});
	        }
	    }

	})(jQuery);
</script>

@stop