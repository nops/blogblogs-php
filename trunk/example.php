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

	/* INCLUDE THE CLASS */
	require_once("blogblogs.php");

 	/* USES EXAMPLE */
 
	$foo = new BlogBlogs("your-username","your-api-key");
	
	$xml_return = $foo->getFavorites();
	
	$xml_return = $foo->getUser("username");

?>