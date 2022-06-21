<?php
// session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/dbh.classes.php';
include_once '../model/User.php';

// Instantiate database object & creating connection

$database = new Dbh();  
$db = $database->connect();

// Instantiate a user object  + Extract form data

$user = new User($db);

// if(isset($_SESSION['user'])) {
//   // echo "lol";
// }
$json = $user->getInfo();

if(!$json) {

  http_response_code(400);
  $errorJson =[];
  $errorJson['message'] = 'No info found';
  echo json_encode($errorJson);

}

else {

  http_response_code(200);
  echo $json;

}

exit();