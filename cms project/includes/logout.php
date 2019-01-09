<?php session_start(); ?>
<?php include "../admin/functions.php" ?>


<?php 

    $_SESSION['loggedin'] = false;  
    $_SESSION['username'] = null;
    $_SESSION['firstname'] = null;
    $_SESSION['lastname'] = null;
    $_SESSION['user_role'] = null;

    redirect("../index.php");

?>