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
user_id INT(5) PRIMARY KEY AUTO_INCREMENT,Name  VARCHAR(20) NOT NULL ,
email varchar(20) NOT NULL,password varchar(8) not null,
role enum('job provider','job seeker'))";
if($conn->query($sql)===FALSE){
    die("error creating table: ".$conn->error);
}

$sql="CREATE TABLE IF NOT EXISTS job_provider(
    user_id INT(5) not null,
    job_provider_id INT(5) PRIMARY KEY AUTO_INCREMENT,
    company_name VARCHAR(30) NOT NULL,
    phone_no int(10) Not null,
    FOREIGN KEY(user_id) REFERENCES users(user_id))";
    if($conn->query($sql)===FALSE){
        die("error creating table: ".$conn->error);
    }

    $sql="CREATE TABLE IF NOT EXISTS job_seeker(
        user_id INT(5) not null,
        job_seeker_id INT(5) PRIMARY KEY AUTO_INCREMENT,
        company_name VARCHAR(30) NOT NULL,
        phone_no int(10) Not null,
        FOREIGN KEY(user_id) REFERENCES users(user_id))";
        if($conn->query($sql)===FALSE){
            die("error creating table: ".$conn->error);
        }
?>