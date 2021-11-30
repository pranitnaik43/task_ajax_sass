<?php
  
include('sql.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  //condition for select query
  $cond = "where email='".$email."'";
  
  $response = getValue($cond);  
  $response = json_decode($response); 
  // print_r($response);

  if($response->success == false) {
    print_r(json_encode((object)["success"=>false, "message"=>"Email not found"]));
    return;
  }
  else if($response->success == true && $response->data && $response->data->password) {
    // return $response->data;
    $userPass = $response->data->password;
    if(password_verify($password, $userPass)) {
      print_r(json_encode((object)["success"=>true, "message"=>"Login successful"]));
      return;
    }
  }
  print_r(json_encode((object)["success"=>false, "message"=>"Login failed"]));
}
 
?>