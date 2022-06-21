<?php

session_start();
header('Access-Control-Allow-Origin: *'); //serve any request that comes
// header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');


include_once '../config/dbh.classes.php';
include_once '../model/Location.php';

// AICI SE VA FOLOSI METODA "PUT" CAND SE TRIMITE REQUEST INCOACE

$database = new Dbh(); 
$db = $database->connect();


  // Instantiate a location object 

  $location = new Location($db);

  // Extracting form data

  // -----incerc alta varianta----
// $location->title=$_POST['address_name'];
// $location->lat=$_POST['address_latitue'];
// $location->lng=$_POST['address_longitude'];
  // -----incerc alta varianta----

 
  $content=trim(file_get_contents("php://input"));
  $locationInfo=json_decode($content, true);

$location->title=$locationInfo['address_name'];
$location->lat=$locationInfo['address_latitude'];
$location->lng=$locationInfo['address_longitude'];



// console.log("informatiile sunt "+$location->title+$location->lat+ $location->lng);

$check=$location->add();

switch($check){

  case "Add location ok":
    http_response_code(200);
    echo 'Your new location has been added!';
    // exit();
break;

    case "Execution error":
      http_response_code(400);
    echo 'Something went wrong! Please try again';
    // exit();

break;

}
