<?

class Api extends CI_Model { 

	// gets current user
	function me() { 
		return $this->session->userdata("username");
	}
	
	function bots() { 
		$me = $this->me();
		return $me;
		$query = "SELECT * FROM bots WHERE owner_username = '$me'";
		$result = $this->db->query($query);
		$result = $result->result_array();
		if(count($result) == 0) { return "You have no bots."; } 
		
		return $result;
	}
	
	  public function redditpost() { 
    $url = $this->input->post('url');
    $components = $this->misc->getPostComponents($url);
    return json_encode($components); 
  }
}

	

}


