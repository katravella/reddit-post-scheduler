<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sched extends CI_Controller {

	public function new_thread()
	{
		/*
			form action = <?=base_url()?>thread/new 
				 method = post
				 
			
			to get list of bots for the specific user, 
				$this->load->model("user");
				$data['users'] = $this->user->myUsers();
			
			will be in the variable $user as an array in the view
			
			to get the list of moderated subreddits for the specific user,
				$this->load->model("oauth");
				$data['moderates'] = $this->oauth->moderates($bot);
				
			will be in the variable $moderates as an array in the view

			to get markdown for a specific pre-existing self-post,
				$this->load->model("thread");
				$data['markdown'] = $this->thread->doMarkdown($url);
				
			will be in the variable $markdown as a string in the view
			
		*/ 
		
		
		
		
		
		
		
		
		
		
	}
	
	
	public function thread($bot)
	{
		$this->load->model("oauth");
		$data['page'] = "schedule/step1";
		
		$data['moderates'] = $this->oauth->moderates($user);
		
		$this->load->view("template", $data);
	}
	
	public function thread($bot, $sub)
	{
		$data['page'] = "schedule/step2";
		$data['sub'] = $sub;
		$this->load->view("template", $data);
	}
	
	public function step3($sub, $type) { 
		if($type == "existing") { 
			$data['page'] = "schedule/existing";
		} else { 
			$data['page'] = "schedule/new_thread";
		}
		$data['sub'] = $sub;
		$this->load->view("template", $data);
	}

	public function step4($sub) { 
		$this->load->model("thread");
		$url = $_POST['url'];
		$check = parse_url($url);
		if($check['host'] != "www.reddit.com" && $check['host'] != "reddit.com") { 
			var_dump($check);
			die("Not a reddit!");
		}
		$data['page'] = "schedule/thread";
		$data['url'] = $url;
		$data['sub'] = $sub;
		$markdown = $this->thread->doMarkdown($url);
		if($markdown == FALSE) { die("Not a reddit markdown!"); } 
		$data['markdown'] = $markdown;
		$this->load->view("template", $data);
	}
	
	public function step5() { 
		$this->load->model("user");
		$url = $_POST['url'];
		$markdown = $_POST['markdownToPost'];
		$sub = $_POST['sub'];
		
		$data['url'] = $url;
		$data['sub'] = $sub;
		$data['markdown'] = $markdown;

		$data['page'] = "schedule/step5";
		$this->load->view("template", $data);
	}
	
	public function step6() { 
		$this->load->model("user");
		
		$url = $_POST['url'];
		$markdown = $_POST['markdown'];
		$sub = $_POST['sub'];
		$botAccount = $_POST['botAccount'];
		$data['url'] = $url;
		$data['sub'] = $sub;
		$data['markdown'] = $markdown;
		$data['botAccount'] = $botAccount;
		$data['page'] = "schedule/step6";
		$this->load->view("template", $data);
	}
	
	
	public function step7() { 
		$this->load->model("user");
		
		$url = $_POST['url'];
		$markdown = $_POST['markdown'];
		$sub = $_POST['sub'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$minute = $_POST['minute'];
		if($minute != '0' && $minute != '15' && $minute != '30' && $minute != '45') { 
			echo $minute. " ";
			die("not a valid minute.");
		}
		$hour = $_POST['hour'];
		if($hour > 24 || $hour < 0) { 
			echo $hour; die(" is not an hour."); 
		}
		
		
		
		$days = $_POST['days'];
		$d = array();
		if(is_array($days)) { foreach($days as $day) { 
			$d[] = array(
				'days' => $day,
				'hour' => $hour,
				'minute' => $minute
				);
			}
		} else {
			$d[0] = array(
			'minute' => $minute,
			'hour' => $hour,
			'days' => $days
			);
		}
		$data['minute'] = $minute;
		$data['hour'] = $hour;
		$data['days'] = $days;
		$data['url'] = $url;
		$data['sub'] = $sub;
		$data['markdown'] = $markdown;
		$data['username'] = $username;
		$data['password'] = $password;
		
		$raw = $this->session->userdata('raw');
		$reddit_username = $raw['result']['name'];
		
		
		$posters = array(
			'username' => $username,
			'password' => $password,
			'reddit_username' => $reddit_username
		);
		
		
		$true = $this->user->checkSubModerator($sub, $reddit_username);
		$data['true'] = $true;
		$data['results'] = false;
		if($true) { 
			$r1 = $this->db->insert("posters", $posters);
			$poster_id = $this->db->insert_id();
			$r2 = $this->db->insert("schedule", $d[0]);
			$master_id = $this->db->insert_id();
			
			$updatemaster = array(
               'child_of' => $master_id
            );

			$this->db->where('id', $master_id);
			$this->db->update('schedule', $updatemaster); 


			if(count($d)>1) { 
				for($i=1;$i<count($d);$i++) { 
					$d[$i]['child_of'] = $master_id;
					$r2 = $this->db->insert("schedule", $d[$i]);
				}
			}
		
			$threads = array(
				'content' => $markdown,
				'sub' => $sub,
				'url' => $url,
				'reddit_username' => $reddit_username,
				'poster_id' => $poster_id,
				'schedule_id' => $master_id
				
			);
			$r3 = $this->db->insert("threads", $threads);
			redirect("dashboard/view/all", 'refresh');
			$data['results'] = array($posters, $d,  $threads);
		
		}

		
		$data['page'] = "schedule/review";
		$this->load->view("template", $data);
	}
	
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */