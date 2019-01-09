<?php ob_start(); ?>              <!-- OVO CE NAM TREBATI KADA BUDEMO REDIREKTOVALI USERE ILI DELOVE KODA APLIKACIJE 
                                       I OVA FUNKCIJA SALJE ZAHTEV ODNOSNO BAFERUJE NAS ZAHTEV U HEADER SKRIPTE PA TAKO KADA ZAVRSIMO SA SKRIPTOM CE BITI IZVRSENO SVE U ISTO VREME, A PRE TOGA SE IZVRSAVALO JEDNO PO JEDNO -->
<?php include "../includes/db.php" ?>
<?php include "functions.php" ?>
<?php session_start(); ?>
<?php

    $user_role = $_SESSION['user_role'];

    if(!isset($user_role)){
        redirect("../index.php");
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
    <script src="js/jquery.js"></script>
</head>

<body>
