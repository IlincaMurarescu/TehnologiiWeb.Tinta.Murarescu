<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/dbh.classes.php';
include_once '../model/Location.php';

// Instantiate database object & creating connection

$database = new Dbh();  
$db = $database->connect();

// Instantiate a user object  + Extract form data

$location = new Location($db);

// if(isset($_SESSION['user'])) {
//   // echo "lol";
// }
$json = $location->getLocations();

if(!$json) {

  http_response_code(400);
  $errorJson =[];
  $errorJson['message'] = 'No locations found';
  echo json_encode($errorJson);

}

else {

  http_response_code(200);
  echo $json;

}

exit();