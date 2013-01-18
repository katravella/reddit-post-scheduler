<h1><?= $title ?></h1>


<div class="row-fluid">
  <div class="span9">
    <form class="form-horizontal" id="savethread" action="<?= base_url() ?>thread/save/" method="post">
      <fieldset>
        <p class="f_legend">New Thread</p>
        <div class="control-group">
          <label class="control-label">title</label>
          <div class="controls">
            <input type="text" id="title" name="title" class="span11">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label">text</label>
          <div class="controls">
            <span class="help-block control-floatright" id="existingThreadNotice"><a href="#existingModal" style="color:#ccc;" data-toggle="modal">Have an existing thread you want to use?</a></span>
            <textarea class="span6" rows="5" id="contents" name="content"></textarea>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <pre id="contents-preview" class="span11" style=""></pre>
            <span id="processingTime" title="processing time" style="display:none;">0 ms</span>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label">choose a subreddit</label>
          <div class="controls">
            
              <select id="subreddit" name="subreddit" class="span3"></select>
              <button id="subreddit-refresh" class="btn">reload</button>

              <button id="dosave" class="btn btn-primary control-floatright" type="submit">Schedule thread</button>
            
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


<!-- Modal -->
<div id="existingModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Load existing reddit thread</h3>
  </div>
  <div class="modal-body">
    <label for="source">Enter the URL for an existing reddit thread:</label>
    <input type="text" id="source" placeholder="http://reddit.com/r/subreddit/1a2gj39">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button id="fetchsource" class="btn btn-primary">Load thread</button>
  </div>
</div>
