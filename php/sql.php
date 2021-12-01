<?php 


$servername="localhost";
$username="root";
$pass="root";
$dbname="task_ajax_sass";

function createDatabase() {
  global $servername, $username, $pass, $dbname;
  try {
    //initial connection to create database
    $conn = new mysqli($servername, $username, $pass);

    if($conn->connect_error) {
      die("Connection failed: ".$conn->connect_error);
    }

    $sql = "CREATE DATABASE " . $dbname;
    if ($conn->query($sql) === TRUE) {
      echo "Database created";
    } else {
      echo "Error creating database: " . $conn->error;
    }
  }
  catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
  finally {
    $conn->close();
  }
}

function createTable() {
  global $servername, $username, $pass, $dbname;
  try {
    $conn = new mysqli($servername, $username, $pass, $dbname);

    if($conn->connect_error) {
      die("Connection failed: ".$conn->connect_error);
    }

    $sql = "CREATE TABLE users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      first_name VARCHAR(30) NOT NULL,
      last_name VARCHAR(30) NOT NULL,
      email VARCHAR(50) NOT NULL,
      dob date,
      contact VARCHAR(15) NOT NULL,
      password VARCHAR(256) NOT NULL
      )";

    if ($conn->query($sql) === TRUE) {
      echo "Table created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

  }
  catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
  finally {
    $conn->close();
  }
}

function getValue($cond="") {
  global $servername, $username, $pass, $dbname;

  try {
    $conn = new mysqli($servername, $username, $pass, $dbname);

    if($conn->connect_error) {
      die("Connection failed: ".$conn->connect_error);
    }

    $query = "SELECT * FROM users ".$cond;
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
      if($row = $result->fetch_assoc()) {
        return json_encode((object)["success"=>true, "data"=>$row]);
      }
    }
    return json_encode((object)["success"=>false, "message"=>"Data not found"]);

  }
  catch(Exception $e) {
    return 'Message: ' .$e->getMessage();
  }
  finally {
    $conn->close();
  }
}

function insertValue($first_name, $last_name, $email, $dob, $contact, $password) {
  global $servername, $username, $pass, $dbname;

  try {
    $conn = new mysqli($servername, $username, $pass, $dbname);

    if($conn->connect_error) {
      die("Connection failed: ".$conn->connect_error);
    }

    //check if email already exists
    $sql = "SELECT * FROM users where email='".$email."'";
    $result = $conn->query($sql);

    // print_r($result, $result->num_rows);
    if ($result && $result->num_rows > 0) {
      return json_encode((object)["success"=>false, "message"=>"email already exists"]);
      return;
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (first_name, last_name, email, dob, contact, password) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $first_name, $last_name, $email, $dob, $contact, $hashed_password);
    $query->execute();

    return json_encode((object)["success"=>true, "message"=>"data inserted sucessfully"]);

    $query->close();
  }
  catch(Exception $e) {
    return 'Message: ' .$e->getMessage();
  }
  finally {
    $conn->close();
  } 
}

// createDatabase();
// createTable();
?>