
			<!-- smart resize event -->
			<script src="static/js/jquery.debouncedresize.min.js"></script>
			<!-- hidden elements width/height -->
			<script src="static/js/jquery.actual.min.js"></script>
			<!-- js cookie plugin -->
			<script src="static/js/jquery_cookie.min.js"></script>
			<!-- main bootstrap js -->
			<script src="static/bootstrap/js/bootstrap.min.js"></script>
			<!-- tooltips -->
			<script src="static/lib/qtip2/jquery.qtip.min.js"></script>
			<!-- fix for ios orientation change -->
			<script src="static/js/ios-orientationchange-fix.js"></script>
			<!-- scrollbar -->
			<script src="static/lib/antiscroll/antiscroll.js"></script>
			<script src="static/lib/antiscroll/jquery-mousewheel.js"></script>
			<!-- mobile nav -->
			<script src="static/js/selectNav.js"></script>
			<!-- common functions -->
			<script src="static/js/gebo_common.js"></script>
	
			<script>
				$(document).ready(function() {
					//* show all elements & remove preloader
					setTimeout('$("html").removeClass("js")',1000);
				});
				function okClicked () {
					window.location = "<?=base_url();?>dashboard/users/new";
					closeDialog ();
				};

			</script>
		
		</div>
	</body>
</html>






<!-- Start modals --> 

<!-- 
	Purpose: To warn user they're about to be redirected to Reddit.com to add their bot
	Used: In navigation (/application/views/includes/header_view_p2.php)
-->
<div class="modal hide in" data-backdrop="static" data-toggle="modal" id="modalAddBot">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h3>Redirect Alert - Add Bot</h3>
	</div>
	<div class="modal-body">
		You are about to be redirected to reddit.com to authorize your bot account with Redditaide. You will return to this page when you finish the authorization. This authorization allows your bot to post as the specified user without having to store your password.
	</div>
	<div class="modal-footer">
		<a class="btn btn-primary" onclick="okClicked ();">Continue</a>
		<a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
	</div>
</div>
