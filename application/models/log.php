<?

class Log extends CI_Model { 

	function login($username, $password) { 
	
	}
	
	function logout($username, $password) { 
	
	}
	
	// gets current user
	function me() { 
		$ses = $this->session->all_userdata();
		$user = $ses['username'];
		return $user;
	}
	
	
	
	function get_last($limit) { 
		$user = $this->session->userdata('username');
		$result = $this->db->query("SELECT * FROM bot_log WHERE owner_username = '$user' ORDER BY timestamp LIMIT $limit");
		$result = $result->result_array();
		return $result;
	
	}
	

	

}


