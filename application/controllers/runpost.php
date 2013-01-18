<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Runpost extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	
	$day = date("N");
	$hour = date("H");
	$min = date("i");
	
	$final = array();
	
	$topost = "SELECT * FROM schedule WHERE days = '5' AND hour = '20'";
	$topost = $this->db->query($topost);
	$topost = $topost->result_array();
	for($i=0;$i<count($topost);$i++) { 
		$final[$i]['min'] = $topost[$i]['minute'];
		$final[$i]['hour'] = $topost[$i]['hour'];
		$final[$i]['master_id'] = $topost[$i]['child_of'];
		
		$threadsq = "SELECT * FROM threads WHERE schedule_id = '".$final[$i]['master_id']."'";
		$threads = $this->db->query($threadsq);
		$threads = $threads->result_array();
		for($t=0;$t<count($threads);$t++) { 
			$final[$i]['sub'] = $threads[$t]['sub'];
			$final[$i]['content'] = $threads[$t]['content'];
			$final[$i]['reddit_username'] = $threads[$t]['reddit_username'];
			$final[$i]['thread_id'] = $threads[$t]['id'];
			
			//$redditq = "SELECT * FROM reddit WHERE username = '".$final[$i]['reddit_username']."'";
			//$reddit = $this->db->query($redditq);
			
			}	
		}		
		
	$new = array();
	$new = $final;
	$count = count($new);
	$minRange = range($min, $min+15);
	for($i=0;$i<$count;$i+=1) { 
		if($new[$i]['hour'] != $hour) { 
			unset($new[$i]);
		} 
		if(!in_array($new[$i]['min'], $minRange)) {
			unset($new[$i]);
		}		
		
		
		
		
	}
	$new = array_values($new);
	for($i=0;$i<count($new);$i++) { 
	$ex = $this->postMe($new[$i]);
	if(isset($ex['result']['jquery'][10][3][0])) { 
		$url = "http://".substr($ex['result']['jquery'][10][3][0], 14);
	} else { 
		$url = "";
	}
	$insert = array(
		'thread_id' => $new[$i]['thread_id'],
		'url' => $url,
		'raw' => json_encode($ex)
	);
	$this->db->insert("bot_log", $insert);
	
	}

	}
	
	
	
	
	
	
	
	
	
	public function postMe($array = array()) { 
		$this->load->model("oauth");
		return $this->oauth->postThread($array);
	
	
	
	
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */