<?

class User extends CI_Model { 

	
	// gets current user
	function me() { 
		$ses = $this->session->all_userdata();
		$user = $ses['username'];
		return $user;
	}
	
	function moderates($username) { 
		$this->load->model("oauth");
		$mods = $this->oauth->moderates($username);
		return $mods;
	}
	
	
	
	
	// circumvents "are you over 18?" for reddit -- takes front page, returns html to parse for the moderators 
	function getSub($sub) { 
	
		$ch = curl_init();

		$data = array('user' => "influx07", 'passwd' => "hellothere", 'api_type' => 'json');
		$uid = "/tmp/".uniqid();
		$fh = fopen($uid, 'w'); 

		curl_setopt($ch, CURLOPT_URL, 'http://www.reddit.com/api/login');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $uid);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $uid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$post = curl_exec($ch);
		$js = json_decode($post,true);
		$js["json"]["data"];
		$modhash = $js["json"]["data"]['modhash'];
		$params = array('over18'=>'yes', 'uh' => $modhash);
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL, "http://www.reddit.com/r/$sub/over18");
		curl_setopt($ch1, CURLOPT_POST, 1);
		curl_setopt($ch1, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $uid);
		curl_setopt($ch1, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11'); 
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
		$post = curl_exec($ch1);
		curl_close ($ch1);
		curl_close ($ch);
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL, "http://www.reddit.com/r/$sub");
		curl_setopt($ch1, CURLOPT_COOKIEFILE, $uid);
		curl_setopt($ch1, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch1, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.64 Safari/537.11'); 
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER, TRUE);
		$post = curl_exec($ch1);
		curl_close ($ch1);
		return $post;
	}
	
	// get all the usernames for a specific sub
	function checkSubModerator($sub, $username, $debug = FALSE) { 
		$page = $this->getSub($sub);
		$str = substr($page, strpos($page, '<h1>MODERATORS</h1>'));
		$str = explode('</ul>', $str,2);
		$str = $str[0];
		$each = explode('<li>', $str);
		unset($each[0]);
		$admins = array();
		foreach($each as $admin) { 
			$admins[] = strtolower($this->misc->get_string_between($admin, 'http://www.reddit.com/user/', '"'));
		}
		$checkUsername = strtolower($username);
		$search = array_search($checkUsername, $admins);
		if($debug === TRUE) { 
			$array = array(
				'username' => $checkUsername,
				'admins' => $admins,
				'result' => $search,
				'sub' => $sub,
			
			);
			return $array;
		}
		return true;
		
	}
	
	function myBots() { 
		$user = $this->session->userdata('username');
		
		$result = $this->db->query("SELECT * FROM bots WHERE owner_username = '$user'");
		$result = $result->result_array();
		return $result;
	
	}
	

	

}


