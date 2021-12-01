<?php
  
include('sql.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $email = $_GET['email'];

  //condition for select query
  $cond = "where email='".$email."'";
  
  $response = getValue($cond);  
  $response = json_decode($response); 
  // print_r($response);

  if($response->success == true) {
    $data = $response->data;
    print_r(json_encode((object)["success"=>true, "data"=>$data]));
    return;
  }
  
  print_r(json_encode((object)["success"=>false, "message"=>"Login failed"]));
}
 
?>