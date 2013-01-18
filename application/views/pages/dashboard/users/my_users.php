<ul>
<? foreach($users as $user) { ?>
<li><?=$user['username'];?></li>
<? } ?> 
<li><a href="<?=base_url();?>dashboard/users/new">Add new user</a></li>
</ul>