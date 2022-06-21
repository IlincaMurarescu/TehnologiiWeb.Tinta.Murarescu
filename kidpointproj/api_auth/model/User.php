<?php
session_start();

class User {

  // Database properties

  private $conn;      
  private $table = 'users';

  // User properties

  public $user_id;
  public $user_name;
  public $user_password;
  public $user_email;

  // Constructor 

  public function __construct($db) {

    $this->conn = $db;

  }

  // Get users

  // public function auth($username, $password) {
  //   $json =[];
  //   $stmt = $this->conn->prepare("SELECT user_id, user_name, user_password, user_email FROM users WHERE user_name=?;");
  //   $stmt->execute([$username]);
    
  //   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  //     if(password_verify($password, $row['user_password'])) {
  //       $json['user_id'] = $row['user_id'];
  //       $json['user_name'] = $row['user_name'];
  //       $json['user_password'] = $row['user_password'];
  //       $json['user_email'] = $row['user_email'];
  //       return json_encode($json);
  //     }
  //   }
  //   return false;
  // }


  public function login() {

    $query_user = 'SELECT user_password FROM '. $this->table .' WHERE user_name=?;';

    $stmt_test = $this->conn->prepare($query_user);
    $stmt_test->execute(array($this->user_name));

    $num_test = $stmt_test->rowCount();

    if($num_test == 0) {
      return 'Badusername';
    }

    $user_password_tabel = $stmt_test->fetchAll(PDO::FETCH_ASSOC);

    if (hash("sha256", $this->user_password) == $user_password_tabel[0]["user_password"]) {

        $checkPwd = true;

    }
    else {
      $checkPwd = false;
    }
    if($checkPwd == true) {
      // $query_test_final = 'SELECT user_id, user_name, user_password FROM '. $this->table .' WHERE user_name=?;';


      // $stmt_test_final = $this->conn->prepare($query_test_final);
      // $stmt_test_final->execute(array($this->user_name));
      // return $stmt_test_final;
      
      $_SESSION['user'] = $this->user_name;
      $_SESSION['child_id'] = 0;
      echo $_SESSION['user'];
      echo "merge";
      return "Login succesful!";

    }

    else{

      // $query_test_final = 'SELECT user_id, user_name, user_password FROM '. $this->table .' WHERE user_name=? and user_password=?;';


      // $stmt_test_final = $this->conn->prepare($query_test_final);
      // $stmt_test_final->execute(array($this->user_name, $this->password));

      // return $stmt_test_final;

      return 'Badpassword';


    }
  }
  

  public function validateEmail($mail){
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $result = false;
    }
    else {
      $result = true;
    }
  
    return $result;
  }
  

  public function checkUsername($user_name) {

    $stmt = $this->conn->prepare('SELECT user_name FROM users WHERE user_name = ?;');

    if(!$stmt->execute(array($user_name))) {

      return 'Execution error';

    }

    $resultCheck;
    if($stmt->rowCount() > 0) {
      $resultCheck = false;

    }
    else {
      $resultCheck = true;
    }

    return $resultCheck;
  }


  public function checkEmail($email) {

    $stmt = $this->conn->prepare('SELECT user_name FROM users WHERE user_email = ?;');

    if(!$stmt->execute(array($email))) {

      return 'Execution error';


    }

    $resultCheck;
    if($stmt->rowCount() > 0) {
      $resultCheck = false;

    }
    else {
      $resultCheck = true;
    }

    return $resultCheck;
  }



public function signup() {

//Verify username and email

$validadress=$this->validateEmail($this->user_email);
if($validadress==false)
return 'Incorrect email';

else {

  $unique_username=$this->checkUsername($this->user_name);
  
  if($unique_username==false)
return 'Username exists';


else{

  $unique_email=$this->checkEmail($this->user_email);
  
  if($unique_email==false)
return 'Email exists';


}

}

$hashedPassword = hash('sha256', $this->user_password);

$this->user_password=$hashedPassword;

//Create query

$query='INSERT INTO '.
 $this->table. 
 ' SET 
 user_name= :user_name, 
 user_password= :user_password,
 user_email= :user_email';


// Prepare statement

$stmt=$this->conn->prepare($query);


// Clean data

$this->user_name=htmlspecialchars(strip_tags($this->user_name));
$this->user_password=htmlspecialchars(strip_tags($this->user_password));
$this->user_email=htmlspecialchars(strip_tags($this->user_email));

// Bind the data

$stmt->bindParam(':user_name', $this->user_name);
$stmt->bindParam(':user_password', $this->user_password);
$stmt->bindParam(':user_email', $this->user_email);


// Execute query

if($stmt->execute()){
$_SESSION['user'] = $this->user_name;
return 'Signup ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
  return 'Execution error';

}

public function updateUsername() {

  // echo $_SESSION['user'];

  // $parentId = 16;

  $currentUser = $_SESSION['user'];
    // echo $_SESSION['user'];
    $query_id = 'SELECT user_id FROM users WHERE user_name =?';
    $stmt_id = $this->conn->prepare($query_id);
    $stmt_id->execute([$currentUser]);


    $num_id = $stmt_id->rowCount();
    // echo $num_id;

    if($num_id == 0) {

      return false;
    }
    else {

      while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
        $foundId = $getId['user_id'];
      }

//Create query

$query='UPDATE '.
$this->table. 
' SET 
user_name= :user_name
WHERE user_id= :id
';


// // Prepare statement

$stmt=$this->conn->prepare($query);


// // Clean data

$this->user_name=htmlspecialchars(strip_tags($this->user_name));
// $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// $this->code=htmlspecialchars(strip_tags($this->code));

// Bind the data

$stmt->bindParam(':user_name', $this->user_name);
$stmt->bindParam(':id', $foundId);


// // Execute query

if($stmt->execute()){
  $_SESSION['user'] = $this->user_name;

return 'UpdateUsername ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
return 'Execution error';
    }
}

// Update email

public function updateEmail() {

  // echo $_SESSION['user'];

  // $parentId = 16;
  $currentUser = $_SESSION['user'];
    // echo $_SESSION['user'];
    $query_id = 'SELECT user_id FROM users WHERE user_name =?';
    $stmt_id = $this->conn->prepare($query_id);
    $stmt_id->execute([$currentUser]);


    $num_id = $stmt_id->rowCount();
    // echo $num_id;

    if($num_id == 0) {

      return false;
    }
    else {

      while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
        $foundId = $getId['user_id'];
      }

  $unique_email=$this->checkEmail($this->user_email);
  echo $this->user_email;
  echo $unique_email;
  
  if($unique_email==false)
return 'Email exists';
//Create query

$query='UPDATE '.
$this->table. 
' SET 
user_email= :user_email
WHERE user_id= :id
';

echo $query;

// // Prepare statement

$stmt=$this->conn->prepare($query);


// // Clean data

$this->user_email=htmlspecialchars(strip_tags($this->user_email));
// $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// $this->code=htmlspecialchars(strip_tags($this->code));

// Bind the data

$stmt->bindParam(':user_email', $this->user_email);
$stmt->bindParam(':id', $foundId);


// // Execute query

if($stmt->execute()){

return 'UpdateEmail ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
return 'Execution error';
    }

}

public function updatePassword() {

  // echo $_SESSION['user'];

  // $parentId = 16;

    $currentUser = $_SESSION['user'];
    // echo $_SESSION['user'];
    $query_id = 'SELECT user_id FROM users WHERE user_name =?';
    $stmt_id = $this->conn->prepare($query_id);
    $stmt_id->execute([$currentUser]);


    $num_id = $stmt_id->rowCount();
    // echo $num_id;

    if($num_id == 0) {

      return false;
    }
    else {

      while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
        $foundId = $getId['user_id'];
      }

      $hashedPassword = hash('sha256', $this->user_password);

      $this->user_password=$hashedPassword;


//Create query

$query='UPDATE '.
$this->table. 
' SET 
user_password= :user_password
WHERE user_id= :id
';

echo $query;

// // Prepare statement

$stmt=$this->conn->prepare($query);


// // Clean data

$this->user_email=htmlspecialchars(strip_tags($this->user_email));
// $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// $this->code=htmlspecialchars(strip_tags($this->code));

// Bind the data

$stmt->bindParam(':user_password', $this->user_password);
$stmt->bindParam(':id', $foundId);


// // Execute query

if($stmt->execute()){

return 'UpdatePassword ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
return 'Execution error';

}
}

public function deleteUser() {

  $currentUser = $_SESSION['user'];
    // echo $_SESSION['user'];
    $query_id = 'SELECT user_id FROM users WHERE user_name =?';
    $stmt_id = $this->conn->prepare($query_id);
    $stmt_id->execute([$currentUser]);


    $num_id = $stmt_id->rowCount();
    // echo $num_id;

    if($num_id == 0) {

      return false;
    }
    else {

      while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
        $foundId = $getId['user_id'];
      }

// Create query

$query = 'DELETE FROM ' .$this->table . ' WHERE user_id = :user_id';

// // Prepare statement

$stmt=$this->conn->prepare($query);


// $this->user_id=htmlspecialchars(strip_tags($this->user_id));
// $this->code=htmlspecialchars(strip_tags($this->code));

// Bind the data

$stmt->bindParam(':user_id', $foundId);


// // Execute query

if($stmt->execute()){

return 'Delete ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
return 'Execution error';


}
}

public function logout() {
  if(!isset($_SESSION['user'])) 
    return 'Not logged in';
  
  else {
    unset($_SESSION['user']);
    session_destroy();
    return 'Logout ok';

  }
}

public function getInfo() {

  $currentUser = $_SESSION['user'];
  // echo $_SESSION['user'];
  $query_id = 'SELECT user_id FROM users WHERE user_name =?';
  $stmt_id = $this->conn->prepare($query_id);
  $stmt_id->execute([$currentUser]);


  $num_id = $stmt_id->rowCount();
  // echo $num_id;

  if($num_id == 0) {

    return false;
  }
  else {

    while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
      $foundId = $getId['user_id'];
    }

    // echo "am gasit ".$gasit;

  // echo $_SESSION['user'];
  $json = [];
  $bigJson = [];
  $query_children = 'SELECT user_name, user_email
                       FROM '. $this->table .' WHERE user_id=?;';

  // echo $query_children;

  $stmt = $this->conn->prepare($query_children);
  $stmt->execute([$foundId]);


  $num = $stmt->rowCount();

  if($num == 0) {

    return false;
  }
  else {

    while($userInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $json['user_name'] = $userInfo['user_name'];
      $json['user_email'] = $userInfo['user_email'];

      array_push($bigJson, $json);

      // return json_encode($bigJson);

    }
    return json_encode($bigJson);
  }

  
}
}

}