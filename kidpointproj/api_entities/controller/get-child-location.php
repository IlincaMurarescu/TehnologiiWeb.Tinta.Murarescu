<?php

session_start();
header('Access-Control-Allow-Origin: *'); //serve any request that comes
// header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');


include_once '../config/dbh.classes.php';
include_once '../model/Child.php';


$database = new Dbh(); 
$db = $database->connect();


  // Instantiate a child object 

  $child = new Child($db);




 
  $content=trim(file_get_contents("php://input"));
  $childInfo=json_decode($content, true);

$child->child_id=$childInfo['child_id'];





$info=$child->getLocation();

if($info==false){

  http_response_code(400);
 
  echo ("Could not show location");



}
else{

  http_response_code(200);
  echo $info;
}
exit();












// -----------------------------1


// <?php

// session_start();
// header('Access-Control-Allow-Origin: *'); //serve any request that comes
// // header('Content-Type: application/json');
// header('Acces-Control-Allow-Methods: POST');


// include_once '../config/dbh.classes.php';
// include_once '../model/Child.php';


// $database = new Dbh(); 
// $db = $database->connect();


//   // Instantiate a child object 

//   $child = new Child($db);




 
//   $content=trim(file_get_contents("php://input"));
//   $childInfo=json_decode($content, true);

// $child->child_id=$childInfo['child_id'];





// $json=$child->getLocation();

// if(!json){

//   http_response_code(400);
//   $errorJson=[];
//   $errorJson['message']='Could not load current position';
//   echo json_encode($errorJson);



// }
// else{

//   http_response_code(200);
//   echo $json;
// }
// exit();
























