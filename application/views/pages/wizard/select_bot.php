<? for($i=0;$i<count($users);$i++) { 
	$div = array();
	$ops = "";
	$divu = $users[$i]['username'];
	$ops .= '<option value="'.$divu.'">'.$divu.'</option>';
	$div[$divu] = "";
	$div[$divu] .= '<select id="'.$users[$i]['username'].'" name="sub" class="hidemeplz">';
		for($n=0;$n<count($users[$i]['mods']);$n++) { 
			$div[$divu] .= '<option value="'.$users[$i]['mods'][$n]['name'].'">'.$users[$i]['mods'][$n]['name'].'</option>';
		}
	}
?>
<select id="user">
<?=$ops;?>
</select>
<? var_dump($div); ?>
<? foreach($div as $d) { ?>
	<?=$d;?>
<? } ?>
