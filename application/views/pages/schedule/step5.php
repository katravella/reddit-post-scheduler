<h3>So you're posting a thread for <?=$sub;?></h3>
<h5>We need a reddit account to post with!</h5>
<? if(isset($error)) { echo "something went wrong. <br />"; } ?>
<form action="<?=base_url()?>schedule/step6" method="post">
<input type="hidden" name="url" value="<?=$url;?>">
<input type="hidden" name="markdown" value="<?=$markdown;?>">
<input type="hidden" name="sub" value="<?=$sub;?>">
<p>
<ul>
<li><input type="text" name="username" placeholder="username" /></li>
<li><input type="text" name="password" placeholder="password" /></li>
</ul>
<input type="submit">
</form>