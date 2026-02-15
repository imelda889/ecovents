<?php
$localhost = '127.0.0.1';
$user = 'root';
$pass = '';
$dbName = 'users'; 

$dbConn = mysqli_connect($localhost, $user, $pass, $dbName);

if(mysqli_connect_errno()){
    die('<script>alert("Connection failed: Please check your SQL connection!");</script>');
}
?>