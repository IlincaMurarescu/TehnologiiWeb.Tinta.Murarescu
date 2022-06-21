<?php
// Headers

header('Access-Control-Allow-Origin: *'); //serve any request that comes
header('Content-Type: application/json');
header('Acces-Control-Allow-Methods: POST');
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

$user->user_name=$_POST['user_name'];
$user->user_password=$_POST['password'];
$user->user_email=$_POST['email'];


//Create new user

$su_result=$user->signup();

switch($su_result){


case "Incorrect email":
  http_response_code(400);
  // echo json_encode(
  //   array('message'=> 'The email adress is invalid!')
  // );
  echo 'The email adress is invalid!';
  exit();
  break;



  case "Username exists":
    http_response_code(400);
    // echo json_encode(
    //   array('message'=> 'The username is already taken!')
    // );
    echo 'The username is already taken!';
    exit();
    break;
  
  

    case "Email exists":
      http_response_code(400);
      // echo json_encode(
      //   array('message'=> 'The email is already taken!')
      // );
      echo 'The email is already taken!';
      exit();
      break;
    
    

      case "Signup ok":
        http_response_code(200);
        // echo json_encode(
        //   array('message'=> 'The user account has been created!')
        // );
        exit();
        break;
      
      
      
            
      case "Execution error":
        http_response_code(400);
        // echo json_encode(
        //   array('message'=> 'Sign up failed!')
        // );
        echo 'Sign up failed!';
        exit();
        break;
      
      

}


// if($user->signup())
// {
//   echo json_encode(
//     array('message'=> 'User created!')
//   );
// }
// else{
//   echo json_encode(
//     array('message'=> 'Sign up failed!')
//   );
// }