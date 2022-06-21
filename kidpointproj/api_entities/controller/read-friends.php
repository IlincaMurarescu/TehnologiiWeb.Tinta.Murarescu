<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/dbh.classes.php';
include_once '../model/Friend.php';

// Instantiate database object & creating connection

$database = new Dbh();  
$db = $database->connect();

// Instantiate a Friend object  + Extract form data

$friend = new Friend($db);


$json = $friend->getFriends();

if(!$json) {

  http_response_code(400);
  $errorJson =[];
  $errorJson['message'] = 'No friends found';
  echo json_encode($errorJson);

}

else {

  http_response_code(200);
  echo $json;

}

exit();