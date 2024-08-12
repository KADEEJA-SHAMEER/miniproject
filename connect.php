<?php
$servername="localhost";
$username="root";
$password="";
$dbname="online_partTime_job_portal";

$conn=mysqli_connect("localhost","root","");
 
if(!$conn){
    echo "connection failed!";
}

$sql="CREATE DATABASE IF NOT EXISTS $dbname";
$con_res = $conn->query($sql);

if(!$con_res){
    echo "error creating database: ";
}
$conn->select_db($dbname);
$sql="CREATE TABLE IF NOT EXISTS users(
user_id