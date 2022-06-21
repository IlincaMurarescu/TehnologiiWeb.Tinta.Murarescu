<?php
// Headers

header('Access-Control-Allow-Origin: *'); //serve any request that comes
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: DELETE');
header('Acces-Control-Allow-Headers: Acces-Control-Allow-Headers, Content-Type, Acces-Control-Allow-Methods, Authorization, X-Requested-With');



include_once '../config/dbh.classes.php';
include_once '../model/User.php';

// Instantiate database object & creating connection

$database = new Dbh(); 
$db = $database->connect();

// Instantiate a user object 

$user = new User($db);

// Get raw user data

// $data = json_decode(file_get_contents("php://input"));

// $user->user_name=$data->user_name;
// $user->user_password=$data->user_password;
// $user->user_email=$data->user_email;

// Extracting form data
// $user->user_name=$_SESSION['user'];
// echo $_SESSION['user'];


//Update user

$su_result=$user->deleteUser();

switch($su_result){


  case "Execution error":
    http_response_code(400);
    $errorJson =[];
    $errorJson['message'] = 'Could not update user.';
    echo json_encode($errorJson);
    break;
  
  
  
   
      
    case "Delete ok":
    http_response_code(200);
    // echo json_encode(
    //   array('message'=> 'The user account has been created!')
    // );
    exit();
    break;
}



