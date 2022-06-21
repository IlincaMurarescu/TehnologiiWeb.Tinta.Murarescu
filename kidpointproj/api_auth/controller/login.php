<?php
// session_start();
// Headers

header('Access-Control-Allow-Origin: http://localhost:80');
header('Acces-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');


include_once '../config/dbh.classes.php';
include_once '../model/User.php';

// session_start();


//Extract form data

// $userName=$_POST['user_name'];
// $password=$_POST['password'];

// echo $userName;
// echo $password;





// Instantiate database object & creating connection

$database = new Dbh();  
$db = $database->connect();

// Instantiate a user object  + Extract form data

$user = new User($db);

$user->user_name = $_POST['user_name'];
$user->user_password = $_POST['password'];

//aici vor fi puse in parametru username si parola introduse de client
$result = $user->login();

switch($result){


case "Badusername":

  http_response_code(400);
  
  echo 'The username does not exist!';
  exit();
  break;

  case "Badpassword":

    http_response_code(400);
    
    echo 'Bad password!';
    exit();
    break;

default:
    http_response_code(200);
    //  $_SESSION['user']=$user->user_id;
    echo 'Login successful!';
    exit();
    
}


// ======================COMENTAT DE ILINCA ACUM====================================


// if($result =='Badusername') {
//   echo json_encode(
//     array('message' => 'Invalid Username')
//   );

//   http_response_code(400);
//   // echo 'Invalid Username!';
//   exit();
// }
// else {

//   $num = $result->rowCount();

//   // check if any users exist
  
//   if($num > 0) {
  
//     // User array for JSON
//     $user_arr = array();
//     $user_arr['data'] = array();
  
//     while($row = $result->fetch(PDO::FETCH_ASSOC)) {
//       extract($row);
  
//       $user_item = array(
//         'id' => $user_id,
//         'username' => $user_name,
//         'password' => $user_password
//       );
  
//       array_push($user_arr['data'],$user_item);
  
//     }
  
//     // turning array into JSON

    
//     // $_SESSION['user']=$userName;

//   http_response_code(200);
//   // echo $userName;
//     exit();


//     // echo json_encode($user_arr);
//   }
//   else {
  
//     // no users
  
//     echo json_encode(
//       array('message' => 'Invalid Password')
//     );

//     // http_response_code(400);
//     // echo 'Invalid Password!';
//     exit();
  
//   }
// }


// // ==========================================================



// $num = $result->rowCount();

// // check if any users exist

// if($num > 0) {

//   // User array for JSON
//   $user_arr = array();
//   $user_arr['data'] = array();

//   while($row = $result->fetch(PDO::FETCH_ASSOC)) {
//     extract($row);

//     $user_item = array(
//       'id' => $user_id,
//       'username' => $user_name,
//       'password' => $user_password
//     );

//     array_push($user_arr['data'],$user_item);

//   }

//   // turning array into JSON

//   echo json_encode($user_arr);
// }
// else {

//   // no users

//   echo json_encode(
//     array('message' => 'No Users Found')
//   );

// }