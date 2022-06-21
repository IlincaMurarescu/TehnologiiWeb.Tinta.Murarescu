<?php

class Friend {

  // Database properties

  private $conn;      
  private $table = 'friends';

  // Friend properties

  public $user_id;
  public $friend_id;
  public $user_name;
  public $role;

  // Constructor 

  public function __construct($db) {

    $this->conn = $db;

  }

  public function getFriends() {

    // $parentId = 16; // = $_SESSION['user_id']
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
    
    $json = [];
    $bigJson = [];
    $query_friends = 'SELECT friend_id, user_name, role
                         FROM '. $this->table .' WHERE user_id=?;';

    // echo $query_children;

    $stmt = $this->conn->prepare($query_friends);
    $stmt->execute([$foundId]);


    $num = $stmt->rowCount();

    if($num == 0) {

      return false;
    }
    else {

      while($friendInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $json['friend_id'] = $friendInfo['friend_id'];
        $json['user_name'] = $friendInfo['user_name'];
        $json['role'] = $friendInfo['role'];
        // $bigJson['data'] = $json;
        array_push($bigJson, $json);

        // return json_encode($bigJson);

      }
      return json_encode($bigJson);
    }
  }

    
  }

  

  public function addFriend() {

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

    // Test to see if the friend's user is a valid one

    $query_user = 'SELECT user_id FROM users WHERE user_name=?';

    $stmt_test = $this->conn->prepare($query_user);
    // $this->user_name=htmlspecialchars(strip_tags($this->user_name));
    // $stmt_test->bindParam(':nume', $nume);
    $stmt_test->execute([$this->user_name]);
    echo $this->user_name; 
    echo $query_user;

    $num_test = $stmt_test->rowCount();
    echo $num_test;

    if($num_test == 0) {
      return 'Badusername';
    }

    // Test to see if the user is already on my friend's list

//Create query

$query='INSERT INTO '.
 $this->table. 
 ' SET 
 user_id= :user_id, 
 user_name= :user_name,
 role= :role';

echo $query;
// Prepare statement

$stmt=$this->conn->prepare($query);


// Clean data

$this->user_name=htmlspecialchars(strip_tags($this->user_name));
$this->role=htmlspecialchars(strip_tags($this->role));

// Bind the data

// $stmt->bindParam(':id_parent', $this->id_parent);
$stmt->bindParam(':user_id', $foundId);
$stmt->bindParam(':user_name', $this->user_name);
$stmt->bindParam(':role', $this->role);


// Execute query

if($stmt->execute()){

return 'AddFriend ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
  return 'Execution error';

  }
}


}