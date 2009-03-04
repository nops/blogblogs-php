<?php
/**
 *	BlogBlogs-php LIB - Easy PHP library for access BlogBlogs API
 *	Copyright (C) 2009  Arthur Vinicius ( nops ) <arthurnops@gmail.com>
 *	
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	any later version.
 *	
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *	
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * 
 * BlogBlogs API class
 * Arthur Vinicius <arthurnops@gmail.com>
 * First release Mar 04 2009
 * Newest release Mar 04 2009
 *
 */
 
class BlogBlogs {
	/* Username format string */
	private $username;
	
	/* API-Key format string - You can view your API Key here: http://blogblogs.com.br/developers/key */
	private $apikey;
	
	/* Contains the last HTTP status code returned */
	private $http_status;
	
	/* Contains the last API call */
	private $last_api_call;
	
	/* Class Constructor */
	function BlogBlogs($username, $apikey) {
		$this->username = sprintf("%s", $username);
		$this->apikey = sprintf("%s", $apikey);
	}
	
	function getFavorites()
	{
		$api_call = sprintf("http://api.blogblogs.com.br/api/rest/favorites");
		return $this->APICall($api_call, true);
	}
	
	/* Call the url of API */
	private function APICall($api_url, $http_post = false) {
		$curl_handle = curl_init();
		$api_url .= sprintf("?key=%s&username=%s", $this->apikey, $this->username);
		curl_setopt($curl_handle, CURLOPT_URL, $api_url);
    	if ($http_post) {
    		curl_setopt($curl_handle, CURLOPT_POST, true);
    	}
    	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    	$return_data = curl_exec($curl_handle);
    	$this->http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
    	$this->last_api_call = $api_url;
    	curl_close($curl_handle);
    	return $return_data;
	}
	
	/* Return HTTP Status of last call */
	function lastStatusCode() {
		return $this->http_status;
	}
	
	/* Return last API call */
	function lastAPICall() {
		return $this->last_api_call;
	}
}
?>