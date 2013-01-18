<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function __construct() { 
	    parent::__construct();

		$this->load->model("user");
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	
	}
	
	public function link_user() { 
			$this->load->model("oauth");
			$this->oauth->link_user();
	}
	

	public function users($action = "list") { 
		if($action == "list" || $action == "") { 
			$myUsers = $this->user->myBots();
			$data['users'] = $myUsers;
			$data['page'] = "dashboard/users/my_users";
			
			$this->load->view("template", $data);
		} 
		if($action == "new") { 
			$this->load->model("oauth");
			$this->oauth->link_user();
		}
	}
	
	public function index()
	{
		$this->load->model("user");
		$this->load->model("log");
		$data['logs'] = $this->log->get_last(5);
		$data['user_bots'] = $this->user->myBots();
		$data['page'] = "dashboard/home";
		
		$this->load->view("template", $data);
	}
	
	public function view() { 
		$this->load->model("thread");
		$result = $this->thread->getThreads();
		$data['result'] = $result;
		$data['page'] = "dashboard/view/all";
		$this->load->view("template", $data);
	}
	
	public function view_thread($id) { 
		$this->load->model("thread");
		$result = $this->thread->getThread($id);
		$data['result'] = $result;
		$data['page'] = "dashboard/view/single";
		$this->load->view("template", $data);
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */