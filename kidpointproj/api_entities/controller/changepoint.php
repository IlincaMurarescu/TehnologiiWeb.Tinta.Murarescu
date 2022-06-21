<?php

session_start();
header('Access-Control-Allow-Origin: *'); //serve any request that comes
// header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: PUT');


include_once '../config/dbh.classes.php';
include_once '../model/Child.php';


$database = new Dbh(); 
$db = $database->connect();


  // Instantiate a child object 

  $child = new Child($db);




 
  $content=trim(file_get_contents("php://input"));
  $locationInfo=json_decode($content, true);

  $locationId=$locationInfo['refpoint_id'];
$child->child_id=$_SESSION['child_id'];





$info=$child->changeRefPoint($locationId);



  switch($info){
    case "Error":
  http_response_code(400);
 
  echo ("Could not change reference point.");
break;

case "Changed":
  http_response_code(200);
  echo "New reference point was chosen.";
break;
case "Unset":
  http_response_code(200);
  echo "No reference point is set for this child now.";
break;
  }
