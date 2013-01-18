<!DOCTYPE html>
<html lang="en" class="login_page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?=SITENAME;?></title>
    
        <!-- Bootstrap framework -->
            <link rel="stylesheet" href="static/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" href="static/bootstrap/css/bootstrap-responsive.min.css" />
        <!-- theme color-->
            <link rel="stylesheet" href="static/css/blue.css" />
        <!-- tooltip -->    
			<link rel="stylesheet" href="static/lib/qtip2/jquery.qtip.min.css" />
        <!-- main styles -->
            <link rel="stylesheet" href="static/css/style.css" />
        <!-- Favicon -->
            <link rel="shortcut icon" href="static/favicon.ico" />
        <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
        <!--[if lte IE 8]>
            <script src="static/js/ie/html5.js"></script>
			<script src="static/js/ie/respond.min.js"></script>
        <![endif]-->
		
    </head>
    <body>

		<div class="login_box">
			<form action="<?=base_url()?>hello/login" method="post" id="login_form">
				<div class="top_b">Sign in to <?=SITENAME;?></div>    
				<div class="cnt_b">
					Some blah blah.
				</div>
				<div class="btm_b clearfix">
					<button class="btn btn-inverse pull-right" type="submit">Sign In using Reddit</button>
				</div>  
			</form>
			
		</div>
		
        <script src="static/js/jquery.min.js"></script>
        <script src="static/js/jquery.actual.min.js"></script>
        <script src="static/lib/validation/jquery.validate.min.js"></script>
		<script src="static/bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                
				//* boxes animation
				form_wrapper = $('.login_box');
				function boxHeight() {
					form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);	
				};
				form_wrapper.css({ marginTop : ( - ( form_wrapper.height() / 2) - 24) });
                $('.linkform a,.link_reg a').on('click',function(e){
					var target	= $(this).attr('href'),
						target_height = $(target).actual('height');
					$(form_wrapper).css({
						'height'		: form_wrapper.height()
					});	
					$(form_wrapper.find('form:visible')).fadeOut(400,function(){
						form_wrapper.stop().animate({
                            height	 : target_height,
							marginTop: ( - (target_height/2) - 24)
                        },500,function(){
                            $(target).fadeIn(400);
                            $('.links_btm .linkform').toggle();
							$(form_wrapper).css({
								'height'		: ''
							});	
                        });
					});
					e.preventDefault();
				});
				
				//* validation
				$('#login_form').validate({
					onkeyup: false,
					errorClass: 'error',
					validClass: 'valid',
					rules: {
						username: { required: true, minlength: 3 },
						password: { required: true, minlength: 3 }
					},
					highlight: function(element) {
						$(element).closest('div').addClass("f_error");
						setTimeout(function() {
							boxHeight()
						}, 200)
					},
					unhighlight: function(element) {
						$(element).closest('div').removeClass("f_error");
						setTimeout(function() {
							boxHeight()
						}, 200)
					},
					errorPlacement: function(error, element) {
						$(element).closest('div').append(error);
					}
				});
            });
        </script>
    </body>
</html>
