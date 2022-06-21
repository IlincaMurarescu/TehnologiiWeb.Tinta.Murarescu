<?php

class Dbh {

  private $host = 'localhost';
  private $dbname = 'kidpoint';
  private $username = 'root';
  private $password = '';
  private $conn; 


 public function connect() {

  $this->conn = null;

  try {

    $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->dbname, $this->username, $this->password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }

  catch(PDOException $e) {

    http_response_code(400);
    echo 'Error Message: '. $e->getMessage();
    
  }

  return $this->conn;

 }

  }
