<?php
if(!session_id()){
    session_start();
}

//Include Twitter client library 
include_once 'src/twitteroauth.php';

/*
 * Configuration and setup Twitter API
 */
$consumerKey = 'vj1IqmVqjWIr1oJxbyvnxHWv5';
$consumerSecret = '0Ls7WAjaqqICaATriM78TXetPsONBrVIPtqV9I0fqOpohCD1tx';
$redirectURL = 'http://ttcvaibhav.tk/index.php';

?>