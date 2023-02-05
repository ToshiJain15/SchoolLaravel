<?php
include 'common.php';
include 'checklogin.php';
$_SESSION['login_user']='';
session_destroy();

 header('location: login.php');

 ?>