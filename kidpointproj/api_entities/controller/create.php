<?php
// Headers
session_start();
header('Access-Control-Allow-Origin: *'); //serve any request that comes
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');
header('Acces-Control-Allow-Headers: Acces-Control-Allow-Headers, Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');



include_once '../config/dbh.classes.php';
include_once '../model/Child.php';

// Instantiate database object & creating connection

$database = new Dbh(); 
$db = $database->connect();

// Instantiate a user object 

$child = new Child($db);

// Extracting form data

$child->first_name=$_POST['first_name'];
$child->last_name=$_POST['last_name'];
$child->code=$_POST['code'];


//Add new child

$result=$child->addChild();

switch($result){


case "Execution error":
  http_response_code(400);
  $errorJson =[];
  $errorJson['message'] = 'Could not add child.';
  echo json_encode($errorJson);
  break;



 
    
  case "AddChild ok":
  http_response_code(200);
  // echo json_encode(
  //   array('message'=> 'The user account has been created!')
  // );
  exit();
  break;
      
      
      
        

      

}