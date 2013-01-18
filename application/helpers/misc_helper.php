<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function getPostComponenets($url) { 

		$page = $this->curl->simple_get($url.'.json');
		$page = json_decode($page, TRUE);
		$data = $page[0]['data']['children'][0]['data'];

		$return = array(
			"subreddit" => $data['subreddit'],
			"title" => $data['title'],
			"selftext" => $data['selftext'],
			"url" => $data['url'],
			"type" => $data['is_self'] ? 'self' : 'link'
			);

		return $return;
	}


	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);   
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}

	function redditResponse($response) { 
		if (!is_array($response) || !isset($response['jquery'])) {
            return false;
        }
		return true;
	}

