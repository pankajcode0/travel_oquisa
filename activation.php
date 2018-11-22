<?php
	require_once("db.php");
	if(!empty($_GET["id"])) {
	$query = "UPDATE user_info set activity = 'yes' WHERE user_id='" . $_GET["id"]. "'";
    $result = mysqli_query($con,$query);
		if(!empty($result)) {
            $message = "Your account is activated.";
            echo"sucess";
		} else {
            $message = "Problem in account activation.";
            echo"fail";
		}
	}
?>