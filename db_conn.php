<?php
$servername = "localhost";
$username = "root";
$password ="" ;
$dbname ="enquiry-system";
$conn = new mysqli($servername, $username,$password,$dbname);

if($conn->connect_error){
    die("connection_failed:".$conn>connect_error);
}
$conn-> set_charset("utf8mb4");
?>