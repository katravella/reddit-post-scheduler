<form action="<?=base_url()?>schedule/step7" method="post">
<input type="hidden" name="url" value="<?=$url;?>">
<input type="hidden" name="markdown" value="<?=$markdown;?>">
<input type="hidden" name="sub" value="<?=$sub;?>">
<input type="hidden" name="username" value="<?=$username;?>">
<input type="hidden" name="password" value="<?=$password;?>">
<p>
<label for="minutes">Minutes</label>
<select name="minute">
<option value="*">* Any</option>
<? for($minute=0;$minute<=45;$minute+=15) { ?>
<option value="<?=$minute;?>"><?=$minute;?></option>
<? } ?>
</select>
</p>
<p>
<label for="hour">Hour</label>
<select name="hour">
<option value="*">* Any</option>
<? for($minute=0;$minute<24;$minute+=1) { ?>
<option value="<?=$minute;?>"><?=$minute;?></option>
<? } ?>
</select>
</p>
<p>
<label for="Days">Days</label><br />
<input name="days[]" type="checkbox" value="*">* Every day<br />
<? $x=0; for($i=5;$i<=11;$i++) { ?>
<? $l = date('l', strtotime("+$i days", 0));
$x += 1;
?>

<input name="days[]" type="checkbox" value="<?=$x;?>"><?=$l;?><br />
<? } ?>
</p>


<input type="submit">
</form>