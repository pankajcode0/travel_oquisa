<?php
// Start the session
session_start();
?>
<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();
header( "Location:index.php" ); die;
?>