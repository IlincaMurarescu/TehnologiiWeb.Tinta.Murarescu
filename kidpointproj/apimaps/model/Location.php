<?php

class Location {

  // Database properties
  private $conn;      
  private $table = 'locations';

  // User properties

public $title;
public $lng;
public $lat;
public $id_parent; // SESSION



  // Constructor 

  public function __construct($db) {

    $this->conn = $db;

  }


  public function add()
  {

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
    
    $query='INSERT INTO '.
     $this->table. 
     ' SET 
     id_parent= :id_parent, 
     latitude= :location_lat,
     longitude= :location_lng, 
     title= :location_title';
    
    
    //Prepare statement
    $stmt=$this->conn->prepare($query);
    
    // console.log($query);
    
    //Clean data
    $this->title=htmlspecialchars(strip_tags($this->title));
    // $this->user_password=htmlspecialchars(strip_tags($this->user_password));
    // $this->user_email=htmlspecialchars(strip_tags($this->user_email));
    
    //Bind the data
    $stmt->bindParam(':id_parent', $foundId);
    $stmt->bindParam(':location_title', $this->title);
    $stmt->bindParam(':location_lat', $this->lat);
    $stmt->bindParam(':location_lng', $this->lng);
    
    
    //Execute query
    if($stmt->execute()){
    
    return 'Add location ok';
    
    }
    
    
      return 'Execution error';
    
    
    }
  }

  public function getLocations() {

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

      // echo "am gasit ".$gasit;

    // echo $_SESSION['user'];
    $json = [];
    $bigJson = [];
    $query_locations = 'SELECT title, longitude, latitude, location_id
                         FROM '. $this->table .' WHERE id_parent=?;';

    // echo $query_children;

    $stmt = $this->conn->prepare($query_locations);
    $stmt->execute([$foundId]);


    $num = $stmt->rowCount();

    if($num == 0) {

      return false;
    }
    else {

      while($LocationInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $json['title'] = $LocationInfo['title'];
        $json['longitude'] = $LocationInfo['longitude'];
        $json['latitude'] = $LocationInfo['latitude'];
        $json['location_id'] = $LocationInfo['location_id'];
        // $bigJson['data'] = $json;
        array_push($bigJson, $json);

        // return json_encode($bigJson);

      }
      return json_encode($bigJson);
    }

    
  }
}






  }



