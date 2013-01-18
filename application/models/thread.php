<?php 

class Thread extends CI_Model { 

	function whoami() { 
		return $this->session->userdata('username');
	}

	// returns all threads for a specific user
	function getThreads() { 
		$user = $this->whoami();
		$query = "SELECT * FROM threads WHERE owner_username = '$user'";
		$result = $this->db->query($query);
		$result = $result->result_array();
		return $result;
	}
	
	// returns thread for a user
	function getThread($id) { 
		$user = $this->whoami();
//		$query = "SELECT * FROM threads INNER JOIN posters ON threads.poster_id = posters.id INNER JOIN schedule ON threads.schedule_id = schedule.child_of WHERE threads.reddit_username =  '$user' AND threads.id = '$id'";
		//$query = "SELECT * FROM schedule INNER JOIN threads ON threads.schedule_id = schedule.child_of INNER JOIN posters ON posters.id = threads.poster_id  WHERE threads.id = $id AND threads.owner_username = '$user'";
		$query = "SELECT * FROM threads WHERE owner_username = '$user' AND id = '$id'";
		$result = $this->db->query($query);
		$result = $result->result_array();
		return $result;
	}

	// save thread
	function saveThread($id = null, $properties) {
		$user = $this->whoami();
		$properties['owner_username'] = $user;

		if (isset($properties['id'])) {
			return $this->db->update("threads", $properties);
		} else {
			return $this->db->insert("threads", $properties);
		}
	}
	
	
	function doMarkdown($url) { 
		$page = $this->curl->simple_get($url.'.json');
		$page = json_decode($page, TRUE);
		$page = $page[0]['data']['children'][0]['data']['selftext'];
		if(empty($page)) { return false; }
		return $page;
	}
	
	
	
	
}	
	
	?>