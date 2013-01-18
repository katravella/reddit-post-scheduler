<?

class Bugman extends CI_Controller { 

	public function check() { 
		$this->load->model("bugbot");
		$hello = $this->bugbot->scan();
		
		$hello = json_decode($hello, TRUE);
		$hello = $hello['data']['children'];
		for($i=0;$i<count($hello);$i++) { 
			if(substr($hello[$i]['data']['title'],0,5) == "[bug]") { 
				$process = $this->bugbot->process($hello[$i]['data']);
				if(is_array($process) && count($process) == 4) { 
					$this->load->model("oauth");
					$ref = $this->oauth->refreshToken("redditbandaide");
					$ret = $this->oauth->bug_reply($process);
				}
			}
		}
	}
	
	
}

