<?php
// Headers
session_start();  

header('Access-Control-Allow-Origin: *'); //serve any request that comes
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');
header('Acces-Control-Allow-Headers: Acces-Control-Allow-Headers, Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');



include_once '../config/dbh.classes.php';
include_once '../model/Friend.php';

// Instantiate database object & creating connection

$database = new Dbh(); 
$db = $database->connect();

// Instantiate a user object 

$friend = new Friend($db);

// Extracting form data

$friend->user_name=$_POST['user_name'];
$friend->role=$_POST['select-role'];


//Add new child

$result=$friend->addFriend();

switch($result){


case "Execution error":
  http_response_code(400);
  $errorJson =[];
  $errorJson['message'] = 'Could not add friend.';
  echo json_encode($errorJson);
  break;



 
    
  case "AddFriend ok":
  http_response_code(200);
  // echo json_encode(
  //   array('message'=> 'The user account has been created!')
  // );
  exit();
  break;

  case "Badusername":
    http_response_code(200);
    exit();
    break;
      
}