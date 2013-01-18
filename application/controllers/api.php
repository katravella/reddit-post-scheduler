<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

  public function __construct() { 
      parent::__construct();

    $this->load->model("user");
    if (!$this->ion_auth->logged_in())
    {
      redirect('auth/login');
    }
    
  } 
  
  /**
   * Lists users bots from the database
   *
   * @param bool int    'internal' if set to true, will assume the call is made within the controller
   * @return  json string of the current logged in users bots
   */
  public function users_bots($int = FALSE) { 
    $this->load->model("internal");
    if($int===TRUE) { 
      return $this->internal->logged_in_users_bots();
    } 
    echo json_encode($this->internal->logged_in_users_bots());
    
  }
  
  
  /**
   * List the moderated subreddits of $bot
   *
   * @param bool $cache   if true, returns the bots table moderates_cache value, otherwise fetches from reddit's oauth
   * @param bool $int   if true, will assume the call is made within the controller
   */
  public function moderates($bot, $cache = TRUE, $int = FALSE) { 
    //if(is_null($cache)) { $cache = TRUE; }
    $this->load->model("oauth");
    $result = $this->oauth->moderates($bot, $cache);
  
    if($int===TRUE) { 
      return json_encode($result);
    }
    echo json_encode($result);
  }

  /**
   * List the moderated subreddits of all bots for the logged in user
   *
   * @param bool $cache   if true, returns the bots table moderates_cache value, otherwise fetches from reddit's oauth
   * @return string $array returns json encoded array of all bots and all moderated subreddits for each bot
   */ 
  public function all_bots_moderate($cache = TRUE) { 
    $array = array();
    $bots = $this->users_bots(TRUE);

    if(!is_array($bots)) { 
        echo json_encode(array('error' => 'no bots'));
        return;
    }

    for($i=0;$i<count($bots);$i++) {
      $bot = $bots[$i];
      $username = $bot['username'];
      $moderates = $this->moderates($username, $cache, true);
	  $moderates = json_decode($moderates, TRUE);

      $array[$i] = array( 
        'username' => $username,
        'moderates' => $moderates
        );
    }
    echo json_encode($array);
  }

  public function loadthread($id) {
     $fakethread = array(
        "id" => $id,

      );

     return json_encode($fakethread);
  }


    public function save($id = null) {
      $this->load->model("thread");
      $this->load->library('form_validation');
      $this->load->helper('form_helper');
      $config = array(
        array(
          'field'   => 'title', 
          'label'   => 'Title', 
          'rules'   => 'required'
          ),
        array(
          'field'   => 'contents', 
          'label'   => 'Text', 
          'rules'   => 'required'
          ),
        array(
          'field'   => 'subreddit', 
          'label'   => 'Subreddit', 
          'rules'   => 'required'
          ),
        array(
          'field'   => 'bot_username', 
          'label'   => 'Bot Username', 
          'rules'   => 'optional'
          )
        );
/*
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == FALSE)
      {
        $errors = array();

        $items = $config;
        foreach ($items as $item) {
          $error = $this->form->form_error($item['field']);
          if ($error) {
            $errors[$item['field']] = $error;
          }
        }

        return json_encode(array(
            "error" => $errors
            ));
      }
      else
      {
*/
        $values = array(
          "title" => $this->input->post("title"),
          "content" => $this->input->post("content"),
          "subreddit" => $this->input->post("subreddit"),
          "bot_username" => $this->input->post("bot_username")
          );
        $id = $this->input->post("id");
        if ($id !== FALSE) {
          $values["id"] = $id;
        }

          
        $success = $this->thread->saveThread($id, $values);
        $data = array(
          "success" => $success
          );

        if ($success) {
          $data["id"] = $this->db->insert_id();
        }

        echo json_encode($data);

//      }      
  }

  /**
  * Load metadata and markdown for an existing reddit post
  * @return string json object
  */
  public function redditpost() { 
    $url = $this->input->post('url');
    $components = $this->misc->getPostComponents($url);
    return json_encode($components); 
  }
}
