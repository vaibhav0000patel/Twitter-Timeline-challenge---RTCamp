<?php
if(!session_id()){
    session_start();
}

//Include Twitter client library 
include_once 'src/twitteroauth.php';

/*
 * Configuration and setup Twitter API
 */
$consumerKey = 'nduWGL8Um028VE2jDOF1vLHuP';
$consumerSecret = 'mzDHYWNpUO2zbxOVYIFQKHvENmd8ovYinjiobalMmBFI1tWlod';
$redirectURL = 'http://www.ttcvaibhav.ml/index.php';

?>