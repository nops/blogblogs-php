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
	
	/* Set this to not return a call with errors */
	public $return_error = true;
	
	/**
	 *  Class Constructor 
	 * 
	 * @author Arthur <nops>
	 * @since Mar 04 2009
	 * 
	 * @access public
	 * @param username string
	 * @param api_key string
	 * @return NULL
	 **/
	function BlogBlogs( $username , $apikey ) {
		$this->username = sprintf( "%s" , $username );
		$this->apikey 	= sprintf( "%s" , $apikey );
	}
	
	/**
	 *  Function to return XML of yours favorites 
	 * 
	 * @access public
	 * @param none
	 * @return xml
	 **/
	function getFavorites()
	{
		$api_call = sprintf( "http://api.blogblogs.com.br/api/rest/favorites" );
		
		return $this->APICall( $api_call , true );
	}
	
	/**
	 *  Function to return XML of yours bookmarks
	 * 
	 * @access public
	 * @param none
	 * @return xml 
	 **/
	function getBookmarks()
	{
		$api_call = sprintf( "http://api.blogblogs.com.br/api/rest/bookmarks" );
		
		return $this->APICall( $api_call , true );
	}
	
	/**
	 *  Function to return XML of users
	 * 
	 * @access public
	 * @param username string
	 * @return xml
	 **/
	function getUser( $user = NULL )
	{
		if( $user == NULL )
			$user = $this->username;
			
		$api_call = sprintf( "http://api.blogblogs.com.br/api/rest/userinfo?username=%s" , $user );
		
		return $this->APICall( $api_call , true, false );
	}
	
	/**
	 *  Function to return XML of blogs
	 * 
	 * @access public
	 * @param blog_url string
	 * @return xml
	 **/
	function getBlog( $blog = NULL )
	{
		if( $blog == NULL )
			return "Invalid Blog URL";
			
		$api_call = sprintf( "http://api.blogblogs.com.br/api/rest/bloginfo?url=%s" , $blog );
		
		return $this->APICall( $api_call , true, false );
	}
	
	/**
	 *  Function to get all blogs from a user
	 * 
	 * @access public
	 * @param username string
	 * @return Array
	 **/
	function getUserBlogs( $user = NULL )
	{
		$is_true = $this->return_error;
		$return = false;
		$array = array();
		
		if( $user == NULL )
			$user = $this->username;
			
		$api_call = sprintf( "http://api.blogblogs.com.br/api/rest/userinfo?username=%s" , $user );
		
		$this->return_error = false;
		$xml = $this->APICall( $api_call , true , false );
		
		if($xml) {
			
			try {
				$xml = @new SimpleXMLElement( $xml );
			} catch (Exception $e) { 
				return false;
			} 
			
			foreach ( $xml->document->item as $item ) {
				foreach ( $item->weblog[0] as $param )
					$dados[ $param->getName() ] = (string)$param;
				array_push( $array , $dados );
			}
			
			$return = $array;
		}
		
		$this->return_error = $is_true;
		return $return;
	}
	
	/**
	 *  Call the url of API 
	 * 
	 * @access private
	 * @param api_url string
	 * @param http_post boolean
	 * @param is_private boolean
	 * @return mixed
	 **/
	private function APICall( $api_url , $http_post = false, $is_private = true ) {
		$curl_handle = curl_init();
		
		if( $is_private )
			$api_url .= sprintf( "?key=%s&username=%s" , $this->apikey , $this->username );
		else
			$api_url .= sprintf( "&key=%s" , $this->apikey );
			
		if ( $http_post )
    		curl_setopt( $curl_handle , CURLOPT_POST , true );
			
		curl_setopt( $curl_handle , CURLOPT_URL , $api_url );    		
    	curl_setopt( $curl_handle , CURLOPT_RETURNTRANSFER , TRUE );
    	$return_data = curl_exec( $curl_handle );
    	
    	$this->http_status = curl_getinfo( $curl_handle , CURLINFO_HTTP_CODE );
    	$this->last_api_call = $api_url;
    	
    	curl_close( $curl_handle );
    	
    	if( ! $this->return_error ) {
    		$xml = new SimpleXMLElement( $return_data );
    		if( $xml->document->error == "" )
    			return $return_data;
    		else 
    			return false;
    		
    	} else {
    		return $return_data;
    	}
	}
	
	/**
	 *  Return HTTP Status of last call 
	 * 
	 * @access public
	 * @return string
	 **/
	function lastStatusCode() {
		return $this->http_status;
	}
	
	/**
	 *  Return last API call 
	 * 
	 * @access public
	 * @return string
	 **/
	function lastAPICall() {
		return $this->last_api_call;
	}

}
?>