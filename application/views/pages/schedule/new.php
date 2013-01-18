<h1>What subredddit is this for?</h1>
<? foreach($mods as $mod) { 
	echo '<a href="'.base_url().'schedule/step2/'.$mod['name'].'">'.$mod['title'] . " ( " . $mod['url'] . " ) </a><br />";
}
