
<? for($i=0;$i<count($result);$i++) { ?>
<p>
<h5><?=$result[$i]['nickname'];?></h5>
	<ul>
		<li>Sub: <?=$result[$i]['sub'];?></li>
		<li>View: <a href="<?=base_url()?>dashboard/view_thread/<?=$result[$i]['id'];?>">View</a></li>
	</ul>
</p>
<? } ?>