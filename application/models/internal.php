<?

class Internal extends CI_Model { 

	// gets current user
	function me() { 
		return $this->session->userdata("username");
	}
	
	function logged_in_users_bots() { 
		$me = $this->me();
		$query = "SELECT * FROM bots WHERE owner_username = '$me'";
		$result = $this->db->query($query);
		$result = $result->result_array();
		if(count($result) == 0) { return "You have no bots."; } 
		
		return $result;
	}
	
	

}


