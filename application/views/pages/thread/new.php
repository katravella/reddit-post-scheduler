<div class="row-fluid">
			<div class="span9">
				<form class="form-horizontal" action="<?= base_url() ?>thread/save/">
					<fieldset>
						<p class="f_legend">New Thread</p>
						<div class="control-group">
							<label class="control-label">Title</label>
							<div class="controls">
								<input type="text" id="title" name="title" class="span11">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Content</label>
							<div class="controls">
								<textarea cols="30" rows="5"  id="contents" name="contents"></textarea>
								<span class="help-block" id="existingThreadNotice" style="float:right; padding-right:45px;"><a href="#existingModal" style="color:#ccc;" data-toggle="modal">Have an existing thread you want to use?</a></span>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<pre id="contents-preview" class="span11"></pre>
								<span id="processingTime" title="processing time" style="display:none;"></span>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<form class="form-inline">
									<select id="subreddit" name="subreddit" class="span3"></select>
									<input type="text" placeholder="Subreddit" class="span6">
									<button class="btn" type="submit">Schedule</button>
								</form>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="span3">
				<div class="well form-inline">
					<p class="f_legend">Variables</p>
					<dl class="dl">
                    <dt>{Lorem}</dt>
                    <dd>A description list</dd>
                    <dt>{dolor}</dt>
                    <dd>Vestibulum id ligula </dd>
                    <dt>{porta}</dt>
                    <dd>Etiam porta sem malesuada</dd>
                </dl>
				</div>
			</div>
		</div>
		

<script type="text/javascript"> 
  var baseUrl = "<?= base_url()?>";
  var threadId = "<?= $threadid ?>";
</script>
<script type="text/javascript" src="<?=base_url();?>static/js/schedule.js"></script>
<script type="text/javascript" src="http://stage.redditaide.com/static/js/snuownd.js"></script>
<script type="text/javascript" src="http://stage.redditaide.com/static/js/showdown-gui.js"></script>		
<script>
$(function() {
			$('#contents').autosize();
		});

</script>
<div class="modal hide in" data-backdrop="static" data-toggle="modal" id="existingModal">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h3>Existing Thread</h3>
	</div>
	<div class="modal-body">
		<input type="text" placeholder="http://www.reddit.com/r/funny/..." value="http://www.reddit.com/r/nba/comments/16k74j/im_a_basketball_scout_for_colleges_and_nba_teams/" name="existURL" id="existURL" class="span5" />
	</div>
	<div class="modal-footer">
		<a class="btn btn-primary" id="existingThread" data-dismiss="modal">Get Thread</a>
		<a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
	</div>
</div>
