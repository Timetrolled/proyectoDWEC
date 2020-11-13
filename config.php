<?php 

ob_start();
session_start();



$con = mysqli_connect($servername,$username,$password,$database);

if (!$con) {
    die("Connection failed: ". mysqli_connect_error());
}






?>