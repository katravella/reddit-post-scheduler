<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thread extends CI_Controller {

	public function __construct() { 
	    parent::__construct();

		$this->load->model("user");
	if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	
	}

	public function refresh() { 
		$t = $this->user->refreshToken();
	var_dump($t);
	}
	
	public function make_new() { 
		$data['page'] = "thread/new";
		$this->load->view("template", $data);
	}
	
	public function new_thread($bot = "", $sub = "", $schedule = "", $threadType = "") { 
		$data['current'] = array(
			'bot' => $bot,
			'sub' => $sub,
			'threadType' => $threadType,
			'schedule' => $schedule
		);
		if(isset($_POST)) {
			$minute = $this->input->post("minute");
			$hour = $this->input->post("hour");
			$days = $this->input->post("days");
			$dstr = "";
			if(is_array($days)) { 
			foreach($days as $day) { 
				$dstr .= $d.',';
			}
			} else { 
				$dstr = $days;
			}
			$dstr = substr($dstr,0,-1);
			$schedule = $minute . ":" . $hour . ":" . $dstr;
			$data['page'] = "schedule/step2";
			$this->load->view("template", $data);
		}
		
		if(empty($bot)) { 
			$this->load->model("user");
			$data['users'] = $this->user->myUsers();
			$data['page'] = "schedule/what_bot";
			$this->load->view("template", $data);
		} elseif(empty($sub)) { 
			$this->load->model("user");
			$data['page'] = "schedule/step1";
			$data['moderates'] = $this->user->moderates($bot);
			$this->load->view("template", $data);
		} elseif(empty($schedule)) {
			$data['page'] = "schedule/step6";
			$this->load->view("template", $data);
		} elseif(empty($threadType)) {
		
		}
	
	
	
	
	
	}
	
	public function newthread() { 
		$bot = $this->input->post('bot');
		$sub = $this->input->post('sub');
		$markdown = $this->input->post('markdown');
	
		$insert = array(
			'bot' => $bot,
			'sub' => $sub,
			'content' => $markdown
		);
		
		var_dump($insert);
		
	
	}
	
	public function save($id) {
	    $data = $_POST;
	    echo '<html><body><pre>' . var_export($data) . '</pre></body></html>';
	  }


	  public function saveThread($values) {
		return $this->db->insert("threads", $values);
	  }

		
	

	public function create() {
	    $data['threadid'] = '';
	    $data['title'] = "Create New Thread";
	    $data['page'] = 'schedule/editthread.php';
	    $data['footer'] = 'schedule/editthread-footer.php';
	    $this->load->view("template", $data);
	}

	public function edit($id) {
		if (!$id) {
			die("no post id");
		}

		$data['threadid'] = $id;
		$data['title'] = "Edit Existing Thread";
		$data['page'] = 'schedule/editthread.php';
		$data['footer'] = 'schedule/editthread-footer.php';
		$this->load->view("template", $data);
	}

	public function log() {
		$data['page'] = 'schedule/log.php';
		$this->load->view("template", $data);
	}



}