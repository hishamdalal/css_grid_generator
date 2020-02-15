<?php
//session_start();
if(!defined('ADMIN')){  
	header("Status: 404 Not Found");
	header("Location: index.php"); 
	die(); 
}

define('USER', 'admin');
define('PASS', 'admin');