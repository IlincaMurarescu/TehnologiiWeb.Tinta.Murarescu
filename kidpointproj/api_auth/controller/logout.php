<?php
// session_start();
// Headers

header('Access-Control-Allow-Origin: http://localhost:80');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');


include_once '../config/dbh.classes.php';
include_once '../model/User.php';

// Instantiate database object & creating connection

$database = new Dbh();  
$db = $database->connect();

// Instantiate a user object  + Extract form data

$user = new User($db);

//aici vor fi puse in parametru username si parola introduse de client
$result = $user->logout();

switch($result){


case "Not logged in":

  http_response_code(400);
  
  echo 'You are not logged in!';
  exit();
  break;

case 'Logout ok':
    http_response_code(200);
    //  $_SESSION['user']=$user->user_id;
    echo 'Login successful!';
    exit();
    
}

