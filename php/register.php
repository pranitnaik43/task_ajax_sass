<?php
  
include('sql.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $dob = $_POST['dob'];
  $contact = $_POST['contact'];
  $password = $_POST['password'];
  
  $response = insertValue($first_name, $last_name, $email, $dob, $contact, $password);
  echo $response;
}
 
?>