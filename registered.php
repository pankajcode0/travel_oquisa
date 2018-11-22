<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
<title>Travel-oquisa</title>
<link rel="stylesheet" href="style.css"/>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
function validateForm() {
    var x = document.forms["myForm"]["name"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
    var y = document.forms["myForm"]["email"].value;
    if (y == "") {
        alert("Email must be filled out");
        return false;
    }
    var z = document.forms["myForm"]["password"].value;
    if (z == "") {
        alert("password must be filled out");
        return false;
    }
    var l = document.forms["myForm"]["contact"].value;
    if (l == "") {
        alert("Contact must be filled out");
        return false;
    }
}
</script>
<style>
  body {
  background-color: dodgerblue;
  font-family: "Helvetica Neue", Helvetica, Arial;
  padding-top: 20px;
}
</style>
	</head>
<body  >

<div class="header">
  <a href="#default" class="logo">Student Travel</a>
  <div class="header-right">
    <a href="index.php">Home</a>
    <a class="active"href="registered.php">Register</a>
    <a href="auto.php">Vehicles</a>
    <a href='user.php'>My Account</a>
  </div>
</div>
<div class="container">
<h2 >Register form</h2>
<br>
 <form name="myForm" onsubmit="return validateForm()" method="post" action = "registered.php" method = "post">
 <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name"  placeholder="Name">
    <small id="" class="form-text text-muted"></small>
  </div>
 <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password">
    <small id="" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirm Password</label>
    <input type="password" class="form-control" name="password2" placeholder="Password">
    <small id="" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="">Contact No</label>
    <input type="text" class="form-control" name="contact" placeholder="contact_no">
    <small id="" class="form-text text-muted"></small>
  </div>
      <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      <a href="login.php" >Login<a>
      </div>
      <?php
  require('db.php');
  $red_flag=0;
  function Emailvalidate($email)
  {
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
// Validate e-mail
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
} else {
    return false;
} }

 function Namevalidate($name)
 {
  if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
    return false; 
  }
  else
  {
    return true;
  }
 }
 function validate_phone_number($phone)
{
     // Allow +, - and . in phone number
     $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
     // Remove "-" from number
     $phone_to_check = str_replace("-", "", $filtered_phone_number);
     // Check the lenght of number
     // This can be customized if you want phone number from a specific country
     if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 14) {
        return false;
     } else {
       return true;
     }
}

    // If form submitted, insert values into the database.
    if (isset($_REQUEST['name'])){
		$username = stripslashes($_REQUEST['name']); // removes backslashes
    $username = mysqli_real_escape_string($con,$username); //escapes special characters in a string
    $check1=Namevalidate($username);
    if($check1)
    {

    }
    else{
      $red_flag=1;
    }
		$email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con,$email);
    $check2=Emailvalidate($email);
    if($check2)
    {

    }
    else{
      $red_flag=1;
    }
    $sql = "SELECT email FROM user_info WHERE email = '$email'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) > 0)
    {
      echo"<script>alert('email already registered')</script>";
      $red_flag=1;
    }
		$contact = stripslashes($_REQUEST['contact']);
    $contact = mysqli_real_escape_string($con,$contact);
    $check3=validate_phone_number($contact);
    if($check3)
    {

    }
    else{
      $red_flag=1;
    }
		$password = stripslashes($_REQUEST['password']);
    $password= mysqli_real_escape_string($con,$password);
    $password2= stripslashes($_REQUEST['password2']);
    $password2= mysqli_real_escape_string($con,$password2);
    if($password==$password2)
    {
     // echo "$password , $password2";
    $hashed_password =password_hash($password, PASSWORD_DEFAULT);
    if($red_flag==0)
    {
  	$query = "INSERT into `user_info` (user_id,name,email,password,contact_no) VALUES (NULL,'$username','$email', '$hashed_password','$contact')";
    $result = mysqli_query($con,$query);
        if($result){
          echo "success";
          session_unset();

// destroy the session
        session_destroy();
        session_start();
          $sql = "SELECT * FROM user_info WHERE email = '$email'and password ='$hashed_password'";
          $run_query = mysqli_query($con,$sql);
          if(mysqli_num_rows($run_query) > 0)
          {
              $row = mysqli_fetch_array($run_query);
              $name1   = $row['name'];
              $_SESSION["name1"] = $row['name'];
              $_SESSION["login"] = true;
              $_SESSION["user_id"] =$row['user_id'];
              header( "Location:user.php" ); die;
          
              echo "$name1";
              
              
          } 
      
      }
      else{
        echo"<script>alert('password doesn't match')</script>";
      }
  }
    else{
       echo"<script>alert('password doesn't match')</script>";
    }
  }
   
       
    }
   ?>
