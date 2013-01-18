<?

class Bugbot extends CI_Model { 

	function indb($id) { 
		$query = "SELECT thread_id FROM bugs WHERE thread_id = '$id'";
		$result = $this->db->query($query);
		$result = $result->result_array();
		if(count($result) > 0) { 
			return true;
		} 
		return false;
	}
	
	function add_bug($array) { 
		//$thread = substr($thread, 0, -1).".json";
		//$json = $this->curl->simple_get($thread);
		//$json = json_decode($json, TRUE);
		//$json = $json[0]['data']['children'][0]['data'];
		$bug_id = uniqid();
		$insert = array (
			'selftext' => $array['selftext'],
			'thread_id' => $array['id'],
			'author' => $array['author'],
			'created' => $array['created'],
			'bug_id' => $bug_id
		);
		
		$result = $this->db->insert("bugs", $insert);
		$row_id = $this->db->insert_id();
		return array('bug_id'=>$bug_id,'id'=>$row_id);
		
	}

	function scan() { 
		$json = "http://www.reddit.com/r/Redditaide.json";
		$json = $this->curl->simple_get($json);
		return $json;
	}
	
	function process($array) { 
		$return = array();
		$thread_id = $array['id'];
		$indb = $this->indb($thread_id);
		if($indb) { return "Already submitted"; }
		$return['indb'] = $indb;
		$add = $this->add_bug($array);
		$return['bug_id'] = $add['bug_id'];
		$return['row_id'] = $add['id'];
	//		$respond = $this->respond($thread_id);
	//	$return['respond'] = $respond;
		$return['thing_id'] = $array['id'];
		return $return;
	}
	
	function respond($thing_id) { 
		$this->load->model("oauth");
		return $this->oauth->bug_reply($thing_id);
	}	
		

}
