<?php

class Child {

  // Database properties

  private $conn;      
  private $table = 'children';

  // User properties

  public $id_parent;
  public $child_id;
  public $first_name;
  public $last_name;
  public $code;
  public $longitude;
  public $latitude;
  public $active_point;
  public $fallen;

  // Constructor 

  public function __construct($db) {

    $this->conn = $db;

  }

//   public function getChildren() {

//     // $parentId = 16; // = $_SESSION['user_id']
//     $currentUser = $_SESSION['user'];
//     // echo $_SESSION['user'];
//     $query_id = 'SELECT user_id FROM users WHERE user_name =?';
//     $stmt_id = $this->conn->prepare($query_id);
//     $stmt_id->execute([$currentUser]);


//     $num_id = $stmt_id->rowCount();
//     // echo $num_id;

//     if($num_id == 0) {

//       return false;
//     }
//     else {

//       while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
//         $foundId = $getId['user_id'];
//       }

//       // echo "am gasit ".$gasit;

//     // echo $_SESSION['user'];
//     $json = [];
//     $bigJson = [];
//     $query_children = 'SELECT child_id, first_name, last_name, longitude, latitude
//                          FROM '. $this->table .' WHERE id_parent=?;';

//     // echo $query_children;

//     $stmt = $this->conn->prepare($query_children);
//     $stmt->execute([$foundId]);


//     $num = $stmt->rowCount();

//     if($num == 0) {

//       return false;
//     }
//     else {

//       while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

//         $json['child_id'] = $childInfo['child_id'];
//         $json['first_name'] = $childInfo['first_name'];
//         $json['last_name'] = $childInfo['last_name'];
//         $json['longitude'] = $childInfo['longitude'];
//         $json['latitude'] = $childInfo['latitude'];
//         // $bigJson['data'] = $json;
//         array_push($bigJson, $json);

//         // return json_encode($bigJson);

//       }
//       return json_encode($bigJson);
//     }

    
//   }
// }

public function exportCSV() {

  $currentUser = $_SESSION['user'];
  $query_id = 'SELECT user_id FROM users WHERE user_name =?';
  $stmt_id = $this->conn->prepare($query_id);
  $stmt_id->execute([$currentUser]);

  
    while($getId = $stmt_id->fetch(PDO::FETCH_ASSOC)) {
      $foundId = $getId['user_id'];
    }


$f=fopen('../../csv_info/parent_'.$foundId.'.csv', 'w+');
fputcsv($f, array('id_parent', 'child_id', 'first_name', 'last_name', 'code', 'longitude', 'latitude', 'active_point', 'fallen'), ";");

$query = 'SELECT *
FROM '. $this->table .' WHERE id_parent=?;';

$stmt=$this->conn->prepare($query);
$stmt->execute(array($foundId));


$a=0;
while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {
// echo($childInfo);
$array=array($childInfo['id_parent'], $childInfo['child_id'], $childInfo['first_name'], $childInfo['last_name'], $childInfo['code'], $childInfo['longitude'], $childInfo['latitude'], $childInfo['active_point'], $childInfo['fallen'] );
  fputcsv($f, $array, ";");
$a=$a+1;

}

fclose($f);

}

  public function addChild() {

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

$query='INSERT INTO '.
 $this->table. 
 ' SET 
 id_parent= :id_parent, 
 first_name= :first_name,
 last_name= :last_name,
 code= :code';


// Prepare statement

$stmt=$this->conn->prepare($query);


// Clean data

$this->first_name=htmlspecialchars(strip_tags($this->first_name));
$this->last_name=htmlspecialchars(strip_tags($this->last_name));
$this->code=htmlspecialchars(strip_tags($this->code));

// Bind the data

// $stmt->bindParam(':id_parent', $this->id_parent);
$stmt->bindParam(':id_parent', $foundId);
$stmt->bindParam(':first_name', $this->first_name);
$stmt->bindParam(':last_name', $this->last_name);
$stmt->bindParam(':code', $this->code);


// Execute query

if($stmt->execute()){

$this->exportCSV();
return 'AddChild ok';

}

//Print error if something goes wrong 

// printf("Error: %s.", $stmt->error );
  return 'Execution error';

  }
}

public function getNotification2() {

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
  // $query_children = 'SELECT child_id, first_name, last_name
  //                      FROM '. $this->table .' WHERE fallen=?;';
  $query_children = 'SELECT child_id, first_name, last_name
                       FROM '. $this->table .' WHERE fallen=1 AND id_parent=?;';

  // echo $query_children;
$fallen = 1;
  $stmt = $this->conn->prepare($query_children);
  $stmt->execute([$foundId]);


  $num = $stmt->rowCount();

  if($num == 0) {

    return false;
  }
  else {
    $notifTitle = 'Kidpoint notification';
    $notif_msg = 'Your child has fallen: ';

    while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $json['child_id'] = $childInfo['child_id'];
      $json['first_name'] = $childInfo['first_name'];
      $json['last_name'] = $childInfo['last_name'];
      $json['notif_title'] = $notifTitle;
      $json['notif_msg'] = $notif_msg . $childInfo['first_name'] . ' ' . $childInfo['last_name'];
      // $bigJson['data'] = $json;
      array_push($bigJson, $json);

      // return json_encode($bigJson);

    }
    // $query_upd='UPDATE '.
    // $this->table. 
    // ' SET 
    // fallen=0
    // WHERE id_parent= :id
    // ';
    
    // echo $query;
    
    // // // Prepare statement
    
    // $stmt_upd=$this->conn->prepare($query_upd);
    
    
    // // Bind the data
    
    
    // $stmt_upd->bindParam(':id', $foundId);
    // if(!$stmt_upd->execute()){
    
    //   return 'Execution error';
      
    //   }
    return json_encode($bigJson);
  }

  
}

}

public function getChildren() {

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
  $query_children = 'SELECT child_id, first_name, last_name, longitude, latitude
                       FROM '. $this->table .' WHERE id_parent=?;';

  // echo $query_children;

  $stmt = $this->conn->prepare($query_children);
  $stmt->execute([$foundId]);


  $num = $stmt->rowCount();

  if($num == 0) {

    return false;
  }
  else {

    while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $json['child_id'] = $childInfo['child_id'];
      $json['first_name'] = $childInfo['first_name'];
      $json['last_name'] = $childInfo['last_name'];
      $json['longitude'] = $childInfo['longitude'];
      $json['latitude'] = $childInfo['latitude'];
      // $bigJson['data'] = $json;
      array_push($bigJson, $json);

      // return json_encode($bigJson);

    }


// Afisarea copiilor uitilizatorului care "ne-a adaugat" in lista lui de prieteni

$query= 'SELECT user_id
FROM friends WHERE user_name=?;';


$stmt_f = $this->conn->prepare($query);
$stmt_f->execute([$currentUser]);


$num = $stmt_f->rowCount();

if($num != 0) {
while($realParentInfo = $stmt_f->fetch(PDO::FETCH_ASSOC)) {

  $realParentId = $realParentInfo['user_id'];

  $parent_children = 'SELECT child_id, first_name, last_name, longitude, latitude
  FROM '. $this->table .' WHERE id_parent=?;';

// echo $query_children;

$stmt_parent = $this->conn->prepare($parent_children);
$stmt_parent->execute([$realParentId]);


$num = $stmt_parent->rowCount();

if($num != 0) {

while($newChildInfo = $stmt_parent->fetch(PDO::FETCH_ASSOC)) {

  $json['child_id'] = $newChildInfo['child_id'];
  $json['first_name'] = $newChildInfo['first_name'];
  $json['last_name'] = $newChildInfo['last_name'];
  $json['longitude'] = $newChildInfo['longitude'];
  $json['latitude'] = $newChildInfo['latitude'];
  // $bigJson['data'] = $json;
  array_push($bigJson, $json);

  // return json_encode($bigJson);

}


}

}

}

    return json_encode($bigJson);
  }

}
}

public function updateFall() {

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
  $query_upd='UPDATE '.
  $this->table. 
  ' SET 
  fallen=0
  WHERE id_parent= :id
  ';
  
  
  
  // // Prepare statement
  
  $stmt_upd=$this->conn->prepare($query_upd);
  
  
  // Bind the data
  
  
  $stmt_upd->bindParam(':id', $foundId);
  if(!$stmt_upd->execute()){
  
    echo 'nu';
    }
  }
  echo 'ok';
}

public function getLocation() {

  $query = 'SELECT longitude, latitude, active_point
  FROM '. $this->table .' WHERE child_id=?;';

$stmt=$this->conn->prepare($query);
$stmt->execute(array($this->child_id));

$num=$stmt->rowCount();

if($num==0)
{
  return false;
}
else {
  $json = [];
  $bigJson = [];
  while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $latitudep=$childInfo['latitude'];
    $longitudep=$childInfo['longitude'];
    $active_point=$childInfo['active_point'];

  //  $position=array("latitude" => $latitudep,
  //  "longitude"=> $longitudep);

  }


if($active_point==0 || $active_point==null)
$position=array("latitude" => $latitudep,
   "longitude"=> $longitudep,
  "point_latitude"=>0,
"point_longitude"=>0,
"distance"=>0);
else{

  $query = 'SELECT longitude, latitude FROM locations WHERE location_id=?;';

$stmt=$this->conn->prepare($query);
$stmt->execute(array($active_point));

while($locationInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

  $point_latitude=$locationInfo['latitude'];
  $point_longitude=$locationInfo['longitude'];

}

// Calcularea distantei dintre copil si punctul de referinta
$theta = round($longitudep,4) - round($point_longitude, 4);
$dist = sin(deg2rad(round($latitudep, 4))) * sin(deg2rad(round($point_latitude, 4))) +  cos(deg2rad(round($latitudep, 4))) * cos(deg2rad(round($point_latitude, 4))) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;
$distance=$miles* 1.609344*1000; //calculata in metri
// -------

$position=array("latitude" => $latitudep,
   "longitude"=> $longitudep,
  "point_latitude"=>$point_latitude,
"point_longitude"=>$point_longitude,
"distance"=>$distance);

}



  $_SESSION['child_id']=$this->child_id;
  // echo($_SESSION['child_id']);
  return json_encode($position);
}



}

public function changeRefPoint($idrefpoint)
{


// Verificam daca locatia selectata nu este cea activa
  $query = 'SELECT active_point
  FROM '. $this->table .' WHERE child_id=?;';

$stmt=$this->conn->prepare($query);
$stmt->execute(array($this->child_id));

$num=$stmt->rowCount();

if($num==0)
{
  return "Error";
}
else {
 
  while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $current_point=$childInfo['active_point'];

  }

  // Locatia selectata este activa, deci s-a dorit resetarea locatiei
  if($idrefpoint==$current_point)
{

  $query='UPDATE '.
  $this->table. 
  ' SET 
  active_point=0 WHERE child_id= :child_id';
 
 //Prepare statement
 $stmt=$this->conn->prepare($query);
 
 //Bind the data
 $stmt->bindParam(':child_id', $this->child_id);

 //Execute query
 if($stmt->execute()){
 
 return 'Unset';
 
 }
   return 'Error';
}
// Se doreste selectarea unei locatii noi
else{
  $query='UPDATE '.
  $this->table. 
  ' SET 
  active_point= :idrefpoint WHERE child_id= :child_id';
 
 //Prepare statement
 $stmt=$this->conn->prepare($query);
 
 //Bind the data
 $stmt->bindParam(':child_id', $this->child_id);
 $stmt->bindParam(':idrefpoint', $idrefpoint);


 //Execute query
 if($stmt->execute()){
 
 return 'Changed';
 
 }
   return 'Error';

}
}
}

public function getNotification() {

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
  $query_children = 'SELECT child_id, first_name, last_name
                       FROM '. $this->table .' WHERE fallen=1 AND id_parent=?;';

  // echo $query_children;
  $fallen = 1;
  $stmt = $this->conn->prepare($query_children);
  $stmt->execute([$foundId]);


  $num = $stmt->rowCount();

  if($num == 0) {

    return false;
  }
  else {
   

    while($childInfo = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $json['child_id'] = $childInfo['child_id'];
      $json['first_name'] = $childInfo['first_name'];
      $json['last_name'] = $childInfo['last_name'];
      // $bigJson['data'] = $json;
      array_push($bigJson, $json);

      // return json_encode($bigJson);

    }
    return json_encode($bigJson);

    $query_upd='UPDATE '.
$this->table. 
' SET 
fallen=0
WHERE id_parent= :id
';

echo $query;

// // Prepare statement

$stmt_upd=$this->conn->prepare($query_upd);


// Bind the data


$stmt_upd->bindParam(':id', $foundId);
if(!$stmt_upd->execute()){

  return 'Execution error';
  
  }
  }

  
}

}




}