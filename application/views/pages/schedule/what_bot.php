<h1>What bot are you going to use?</h1>
<? foreach($users as $user) { 
	echo '<a href="'.base_url().'schedule/step1/'.$user['username'].'">'.$user['username'].'</a><br />';
}
