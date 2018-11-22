<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8"> 
  </head>
<title>Registration</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php

require('db.php');
?>

<div class='header'>
  <a href=''  color="red" class='logo'>Student Travel</a>
 
  <div class='header-right'>
    <a class='active' href='index.php'>Home</a>
    <a href='registered.php'>Register</a>
    <a href="auto.php">Vehicles</a>
    <a href='user.php'>My Account</a>
  </div>
</div>

<h2>Search By:</h2>
 <form action = '#' method = 'post'>

 select place:        
         <select name = 'place'>
            <option value = 'all'>All</option>
            <option value = 'Palakkad railway station '>Palakkad Railway station</option>
            <option value = 'Coimbatore airport'>Coimbatore airport</option>
            <option value = 'Coimbatore railway station'>Coimbatore railway station</option>
         </select>
 select date:
         <input type='date' name='date'>
         
         <input type = 'submit' value = 'Submit' />
      </form>



<h2>Student travel chart:</h2>
<table id='t01'>
  <tr>
    <th>Name</th>
    <th>Contact</th>
    <th>Going to</th>
    <th>Date</th>
    <th>Time</th>
  </tr>
  
<?php
      if (isset($_REQUEST['place'])){
        $name = stripslashes($_REQUEST['place']); // removes backslashes
        $name = mysqli_real_escape_string($con,$name); //escapes special characters in a string
        $date = stripslashes($_REQUEST['date']);
        $date = mysqli_real_escape_string($con,$date);
       
        if($name=='all' && $date==0)
        {
        $sql = "SELECT * FROM chart ";
        }
        elseif($name!='all' && $date==0)
        {
          $sql = "SELECT * FROM chart WHERE place = '$name' ";
        }
        elseif($name=="all"&& $date>0)
        {
          $sql = "SELECT * FROM chart WHERE date='$date'";
        }
        else
        {
          $sql = "SELECT * FROM chart WHERE place = '$name' and date='$date'";
        }
        $run_query = mysqli_query($con,$sql);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$name1   = $row['name'];
			$contact1   = $row['contact_no'];
			$place1 = $row['place'];
			$date1 = $row['date'];
			$time1 = $row['time'];
			echo "
      <tr>
      <td>$name1</td>
      <td>$contact1</td>
      <td>$place1</td>
      <td>$date1</td>
      <td>$time1</td>
    </tr>
			";
		}
	}
      }
      else{
        $sql = "SELECT * FROM chart ";
        $run_query = mysqli_query($con,$sql);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$name1   = $row['name'];
			$contact1   = $row['contact_no'];
			$place1 = $row['place'];
			$date1 = $row['date'];
			$time1 = $row['time'];
			echo "
      <tr>
      <td>$name1</td>
      <td>$contact1</td>
      <td>$place1</td>
      <td>$date1</td>
      <td>$time1</td>
    </tr>
			";

      }
    }
  }
  echo"</table>";
      ?>
   <footer>
    <p>Powered by @oquisa.com</p>
  </footer> 

