<?php
// Start the session
session_start();
require('db.php');
$name1=$_SESSION["name1"];
$user_id=$_SESSION["user_id"];
$sql = "SELECT chart_id FROM chart WHERE user_id = '$user_id'";
$run_query = mysqli_query($con,$sql);
while($row = mysqli_fetch_array($run_query)){
    $y=$row['chart_id'];
    if($_POST["$y"])
    {
        $m=$y;
    }
}
?>
<?php




echo "$user_id";
echo "$name1";
echo "$m";

$query = "DELETE  FROM chart WHERE chart_id='$m'";
$result = mysqli_query($con,$query);
        if($result){
          echo "success";
      }
      else{
          echo "fail";
      }
header( "Location:user.php" ); die;
?>