<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>Registration</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

</script>
<script>
function validateForm() {
    var x = document.forms["myForm"]["contact"].value;
    if (x == "" || x.length != 10) {
        alert("contact must be filled out correctly in 10 digits ");
        return false;
    }
    if (isNaN(x)) {
      alert ("Contact is not a number ")
      return false;
    }
    var y = document.forms["myForm"]["date"].value;
    if (y == "") {
        alert("date must be filled out ");
        return false;
    }
    var z = document.forms["myForm"]["time"].value;
    if (z == "") {
        alert("time must be filled out ");
        return false;
    }
    
}
</script>

<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php


session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
  $name1=$_SESSION["name1"];
  $user_id=$_SESSION["user_id"];
} else {
  header( "Location:login.php" ); die;
}

?>

<div class='header'>
  <a href=''  color="red" class='logo'>Student Travel</a>
 
  <div class='header-right'>
    <a  href='index.php'>Home</a>
    <a class='active'href='user.php'>My Account</a>
    <a class=''href='logout.php'>Logout</a>
  </div>
  <a> welcome <?php echo "$name1";?></a>
</div>

<h2>Add new:</h2>
<form name="myForm" onsubmit="return validateForm()" method="post" action = "user.php" method = "post">

 select place:        
         <select name = 'places'>
            <option value = '1'>Palakkad Railway station</option>
            <option value = '2'>Coimbatore airport</option>
            <option value = '3'>Coimbatore railway station</option>
         </select>
 select date:
         <input type='date' name='date'>
select time:
        <input type='time' name='time'>
contact Number:
        <input type='int' name='contact'>         
         <input type = 'submit' value = 'Submit' />
      </form>



<h2>your travel chart:</h2>
<table id='t01'>
  <tr>
    <th>Name</th>
    <th>Contact</th>
    <th>Going to</th>
    <th>Date</th>
    <th>Time</th>
    <th>Delete Entry</th>
  </tr>
  
<?php
require('db.php');
$flag_red=0;



      if (isset($_REQUEST['places'])){
        $place = stripslashes($_REQUEST['places']); // removes backslashes
        $place = mysqli_real_escape_string($con,$place); //escapes special characters in a string
        if($place=='1')
        {
          $place='Palakkad Railway station';
        }
        else if($place=='2')
        {
          $place='Coimbatore airport';
        }
        else if($place=='3')
        {
          $place='Coimbatore railway station';
        }
        else
        {
          $flag_red=1;
        }
       // echo "$place";
        $date = stripslashes($_REQUEST['date']);
        //echo date('Y-m-d');
        if($date<date('Y-m-d'))
        {
          $flag_red=1;
          echo"<script>alert('this event will be reported')</script>";
        }
  
        $date = mysqli_real_escape_string($con,$date);
        $time = stripslashes($_REQUEST['time']);
        $time= mysqli_real_escape_string($con,$time);
        $contact = stripslashes($_REQUEST['contact']);
        $contact= mysqli_real_escape_string($con,$contact);
        if($contact==''||strlen($contact)!=10 )
        { 
          $flag_red=1;
        }
        if(!ctype_digit ( $contact ))
        {
          $flag_red=1;
        }
      
      //  $check=validate_phone_number($contact);
       


        if($flag_red==0)
        {
        $query = "INSERT into `chart` (chart_id,user_id,name,contact_no,place,date,time) VALUES (NULL,'$user_id','$name1','$contact','$place','$date','$time')";
        $result = mysqli_query($con,$query);
        
        if($result){
            //echo "success";
        }
        else{
            //echo "fail";
        }
      }
      }
      $sql = "SELECT * FROM chart WHERE user_id='$user_id'";
      $run_query = mysqli_query($con,$sql);

      function delete($chart_ide){
        $query = "DELETE  FROM chart WHERE chart_id='$chart_id'";
        $result = mysqli_query($con,$query);
        if($result){
          echo "success";
                     }
      else{
          echo "fail";
           }
      }
      if(mysqli_num_rows($run_query) > 0){
        $number=0;
		while($row = mysqli_fetch_array($run_query)){
      $number=$number+1;
			$name1   = $row['name'];
			$contact1   = $row['contact_no'];
			$place1 = $row['place'];
			$date1 = $row['date'];
      $time1 = $row['time'];
      $chart_id1=$row['chart_id'];
      $name='table'.$number;
			echo "<tr>
      <td>$name1</td>
      <td>$contact1</td>
      <td>$place1</td>
      <td>$date1</td>
      <td>$time1</td>
      <td><form action='delete.php' method='post'>        
      <input type = 'submit' name='$chart_id1' value = 'delete' />
   </form></td>    

    </tr>
			";
		}
    }
    echo"</table>";
     ?>
   <footer>
    <p>Powered by @oquisa.com</p>
  </footer> 

