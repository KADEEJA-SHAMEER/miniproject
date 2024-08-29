<?php
$servername="localhost";
$username="root";
$password="";
$dbname="online_partTime_job_portal";

$conn=mysqli_connect("localhost","root","");
 
if(!$conn){
    echo "connection failed!";
}else{
    echo" connected";
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
role enum('job provider','job seeker'),
 first_login boolean default true )";
if($conn->query($sql)===FALSE){
    die("error creating table: ".$conn->error);
}

$sql="CREATE TABLE IF NOT EXISTS job_provider(
    user_id INT(5) not  null,
    company_name VARCHAR(30) NOT NULL,
    phone_no int(10) Not null,
    industry varchar(20) not null,
    address varchar(50) not null,
    FOREIGN KEY(user_id) REFERENCES users(user_id))";
    if($conn->query($sql)===FALSE){
        die("error creating table: ".$conn->error);
    }

    $sql="CREATE TABLE IF NOT EXISTS job_seeker(
        user_id INT(5) not null,
        date_of_birth date not null,
        gender varchar(10) not null,
        skills VARCHAR(30) NOT NULL,
        education ENUM('High School', 'Diploma', 'Bachelor\'s Degree',
         ' Master\'s Degree', 'PhD', 'Other') Not null,
         seeker_address varchar(50) not null,
         seeker_phno int(10) not null,
        FOREIGN KEY(user_id) REFERENCES users(user_id))";
        if($conn->query($sql)===FALSE){
            die("error creating table: ".$conn->error);
        }
        $sql="CREATE TABLE IF NOT EXISTS job_posting(
            user_id INT(5) not null,
            job_post_id int(5) auto_increment primary key,
            job_title varchar(20) not null,
            skills_required text not null,
            schedule_requirement varchar(50) not null,
            location text not null,
            description text not null,
            posted_date date not null,
            salary int(10) not null,
            FOREIGN KEY(user_id) REFERENCES users(user_id))";
            if($conn->query($sql)===FALSE){
                die("error creating table: ".$conn->error);
            }
            $sql="CREATE TABLE IF NOT EXISTS job_application(
                user_id INT(5) not null,
                job_apply_id int(5) auto_increment primary key,
                job_post_id int(5)  not null,
                apply_date date not null,
                availabilty varchar(50) not null,
                experience varchar(100),
                FOREIGN KEY(user_id) REFERENCES users(user_id),
                FOREIGN KEY(job_post_id) REFERENCES job_posting(job_post_id))";
                if (!$conn->query($sql)) {
                    $error = $conn->error;
                    // Log the error and display a user-friendly message
                    echo "Error creating table: $error";
                }
                
                 
?>