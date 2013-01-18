<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Oauth extends CI_Controller {



	public function __construct() { 

	    parent::__construct();



		$this->load->model("user");

		
		
		require("application/libraries/Client.php");
		require("application/libraries/GrantType/IGrantType.php");
		require("application/libraries/GrantType/RefreshToken.php");
		require("application/libraries/GrantType/AuthorizationCode.php");

	

	}	

	public function whoami() { 
		return $this->session->userdata('username');
	}

	public function link_user() { 
		if (isset($_GET["error"]))
		{
			echo("<pre>OAuth Error: " . $_GET["error"]."\n");
			echo('<a href="index.php">Retry</a></pre>');
			die;
		}
		$me = $this->whoami();
		
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url().'dashboard/link_user';
		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

		if (!isset($_GET["code"]))
		{
			$authUrl = $client->getAuthenticationUrl($authorizeUrl, $redirectUrl, array("scope" => "identity,mysubreddits,submit,edit", "state" => $state, 'duration'=>'permanent'));
			header("Location: ".$authUrl);
			die("Redirect");
		}
		else
		{
				$me = $this->whoami();
			
			$params = array("code" => $_GET["code"], "redirect_uri" => $redirectUrl);
			$code = $_GET['code'];
			
			$response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);
			
			$accessTokenResult = $response["result"];
			$oauth = array('code' => $code, 'token' => $accessTokenResult['access_token']);
			$client->setAccessToken($accessTokenResult["access_token"]);
			$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
			

			$response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
			$name = $response['result']['name'];
			$data = array(
					'username' => $name,
					'access_token' => $accessTokenResult['access_token'],
					'refresh_token' => $accessTokenResult['refresh_token'],
					'code' => $code,
					'owner_username' => $me,
					'last_updated' => date("Y-m-d") . " " . date("H:i:s")
				);
				

			$exists = $this->db->query("SELECT id, username FROM bots WHERE username = '$name' AND owner_username = '$me'");
			$exists = $exists->result_array();
			if(count($exists) == 0) { 
				$this->db->insert("bots", $data);
			} else { 
				$this->db->where('id', $exists[0]['id']);
				$this->db->update("bots", $data);
			}
		redirect("dashboard", 'refresh');
		}
	
	}
	
	public function refreshToken($username) { 
		$whoami = $this->whoami();
//$whoami = "jbrody13";
		$query = "SELECT * FROM bots WHERE username = '$username' AND owner_username = '$whoami'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		if(count($checkU) == 0) { 
			return "Invalid user";
		}
		$checkU = $checkU[0];
		$code = $checkU['code'];
		$accessToken = $checkU['access_token'];
		$refreshToken = $checkU['refresh_token'];
		if (isset($_GET["error"]))
		{
			echo("<pre>OAuth Error: " . $_GET["error"]."\n");
			echo('<a href="index.php">Retry</a></pre>');
			die;
		}

		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url()."dashboard/link_user";


		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

			$params = array("code" => $code, "redirect_uri" => $redirectUrl, 'refresh_token' => $refreshToken);
			
			$response = $client->getAccessToken($accessTokenUrl, "refresh_token", $params); //these are grant types
			$accessTokenResult = $response["result"];
			$oauth = array('code' => $code, 'token' => $accessTokenResult['access_token']);
			$client->setAccessToken($accessTokenResult["access_token"]);
			$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
			

			$response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
			$name = $response['result']['name'];
			$data = array(
					'username' => $name,
					'access_token' => $accessTokenResult['access_token'],
					'refresh_token' => $accessTokenResult['refresh_token'],
					'code' => $code,
					'owner_username' => $whoami
				);
			$exists = $this->db->query("SELECT id, username FROM bots WHERE username = '$name'");
			$exists = $exists->result_array();
			if(count($exists) == 0) { 
				$this->db->insert("bots", $data);
			} else { 
				$this->db->where('id', $exists[0]['id']);
				$this->db->update("bots", $data);
			}
			if(isset($accessTokenResult['refresh_token'])) { return true; } else { return false; } 
	}
		
		
	// to do - moderates_cache	
	function moderates($username, $cache = TRUE) { 
		$whoami = $this->whoami();
		$this->refreshToken($username);
		$query = "SELECT * FROM bots WHERE username = '$username' AND owner_username = '$whoami'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		if(count($checkU) == 0) { 
			return "Invalid user";
		}
		$checkU = $checkU[0];
		if($cache === TRUE) { 
			return json_decode($checkU['moderates_cache'], TRUE);
		}
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url()."dashboard/link_user";
		
		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
		$code = $checkU['code'];
		$accessToken = $checkU['access_token'];
	
		$params = array("code" => $code, "redirect_uri" => $redirectUrl);

		$client->setAccessToken($accessToken);
		$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
		
		$mods = $client->fetch("https://oauth.reddit.com/reddits/mine/moderator.json");
		if(isset($mods['result']['error']) == 401) { die("401 error"); } 
		$mods = $mods['result']['data']['children'];
		$remod = array();
			for($i=0;$i<count($mods);$i++) { 
				$remod[$i]['title'] = $mods[$i]['data']['title'];
				$remod[$i]['url'] = $mods[$i]['data']['url'];
				$remod[$i]['name'] = substr($mods[$i]['data']['url'], 3, -1);
			}
			$insert = array(
				'moderates_cache' => json_encode($remod),
				'last_updated' => date("Y-m-d") . " " . date("H:i:s")
			);
			$this->db->where('id', $checkU['id']);
			$this->db->update("bots", $insert);
			
		return $remod;	
	}
	
	
	public function postThread($array = array()) { 
		$username = $array['reddit_username'];
		$this->refreshToken($username);
		$post = array(
			'kind' => 'self',
			'sr' => $array['sub'],
			'text' => $array['content'],
			'title' => "Testing title 123",
		);
		$query = "SELECT * FROM bots WHERE username = '$username'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		if(count($checkU) == 0) { 
			return "Invalid user";
		}
		$checkU = $checkU[0];
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url()."hello/login";
		
		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
		$code = $checkU['code'];
		$accessToken = $checkU['token'];
	
		$params = array("code" => $code, "redirect_uri" => $redirectUrl);
		$post['code'] = $code;
		$post['redirect_uri'] = $redirectUrl;
		
		$client->setAccessToken($accessToken);
		$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
		
		$mods = $client->fetch("https://oauth.reddit.com/api/submit",$post,'POST');
		return $mods;
	}
	
	public function bug_reply_new($array) { 
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$username = "redditaide";
		$query = "SELECT * FROM bots WHERE username = '$username'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		if(count($checkU) == 0) { 
			return "Invalid user";
		}
		$checkU = $checkU[0];
		$code = $checkU['code'];
		$accessToken = $checkU['access_token'];
		$redirectUrl = base_url().'dashboard/link_user';

		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);

		$params = array("code" => $code, "redirect_uri" => $redirectUrl);
		$response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);
		$accessTokenResult = $response["result"];
		$client->setAccessToken($accessToken);
		$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
		$response = $client->fetch("https://oauth.reddit.com/api/v1/me.json");
		echo('<strong>Response for fetch me.json:</strong><pre>');
		print_r($response);
		echo('</pre>');
	}
	
	public function bug_reply($array) { 
		$username = "redditbandaide";
		$whoami = $this->whoami();
		$this->refreshToken($username);
		$query = "SELECT * FROM bots WHERE username = '$username'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		if(count($checkU) == 0) { 
			return "Invalid user";
		}
		$checkU = $checkU[0];
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url()."dashboard/link_user";
		
		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
		$code = $checkU['code'];
		$accessToken = $checkU['access_token'];
	
		$params = array("code" => $code, "redirect_uri" => $redirectUrl);

		$client->setAccessToken($accessToken);
		$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
		
		$thing_id = "t3_".$array['thing_id'];
		$bid = $array['bug_id'];
		$markdown = "Hello there! \n \n Thanks for seeing this issue! I have filed your bug report with the humans. They will investigate and reply accordingly. \n \n 	Bug ID: $bid";
		$thing_id = "t3_16l89n";
		$post = array(
			'thing_id' => $thing_id,
			'text' => $markdown
		);
		$reply = $client->fetch("https://oauth.reddit.com/api/comment",$post,'POST');
		if(empty($reply['result']['jquery'])) { return $reply; }
		
		$reply_id = $reply['result']['jquery'][18][3][0][0]['data']['id'];
		$bug_id = $array['bug_id'];
		$resp = $markdown;
		$insert_bug_log = $this->db->insert("bug_log", array('bug_id'=>$bug_id, 'bot_response'=>$markdown, 'bot_response_thing_id'=>$reply_id));
		$idtoupdate = $this->db->insert_id();
		$updatearray = array('bug_log_id' => $idtoupdate);
		$this->db->where("id", $array['row_id']);
		$this->db->update("bugs", $updatearray);
		return $insert_bug_log;
	}
	public function bug_reply_oldest($array) { 
		$username = "Influx07";
	//	$this->refreshToken($username);
		$thing_id = "t3_".$array['thing_id'];
		$bid = $array['bug_id'];
		$markdown = "Hello there! \n \n Thanks for seeing this issue! I have filed your bug report with the humans. They will investigate and reply accordingly. \n \n 	Bug ID: $bid";
		$markdown = "suck";
		$post = array(
			'thing_id' => $thing_id,
			'text' => $markdown
		);
		$query = "SELECT * FROM bots WHERE username = '$username'";
		$result = $this->db->query($query);
		$checkU = $result->result_array();
		$checkU = $checkU[0];
		$authorizeUrl = 'https://ssl.reddit.com/api/v1/authorize';
		$accessTokenUrl = 'https://ssl.reddit.com/api/v1/access_token';
		$clientId = APIKEY;
		$clientSecret = APISECRET;
		$state = uniqid();
		$redirectUrl = base_url().'dashboard/link_user';
		
		$client = new OAuth2\Client($clientId, $clientSecret, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
		$code = $checkU['code'];
		$accessToken = $checkU['access_token'];
		$params = array("code" => $code, "redirect_uri" => $redirectUrl);
	//	$response = $client->getAccessToken($accessTokenUrl, "authorization_code", $params);
			
		$accessTokenResult = $response["result"];
		$post = array('code' => $code, 'token' => $accessToken);
		$client->setAccessToken($accessToken);
		$client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_BEARER);
			
		$post['code'] = $code;
		$post['redirect_uri'] = $redirectUrl;
		
		
		$reply = $client->fetch("https://oauth.reddit.com/api/comment",$post,'POST');
		if(empty($reply['result']['jquery'])) { return $reply; }
		return $reply;
		
		$reply_id = $reply['result']['jquery'][18][3][0][0]['data']['id'];
		$bug_id = $array['bug_id'];
		$resp = $markdown;
		$insert_bug_log = $this->db->insert("bug_log", array('bug_id'=>$bug_id, 'bot_response'=>$markdown, 'bot_response_thing_id'=>$reply_id));
		$idtoupdate = $this->db->insert_id();
		$updatearray = array('bug_log_id' => $idtoupdate);
		$this->db->where("id", $array['row_id']);
		$this->db->update("bugs", $updatearray);
		return $insert_bug_log;
	
	}

		
}
	
	
