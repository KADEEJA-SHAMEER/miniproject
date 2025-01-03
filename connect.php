<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_partTime_job_portal";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql="CREATE DATABASE IF NOT EXISTS $dbname";
$con_res = $conn->query($sql);

if(!$con_res){
    echo "error creating database: ";
}
$conn->select_db($dbname);
$sql="CREATE TABLE IF NOT EXISTS users(
user_id INT(5) PRIMARY KEY AUTO_INCREMENT,Name  VARCHAR(20) NOT NULL ,
email varchar(50) NOT NULL,password varchar(20) not null,
role enum('job provider','job seeker'),
 first_login boolean default true,
 user_status boolean default true )";
if($conn->query($sql)===FALSE){
    die("error creating table: ".$conn->error);
}
$sql="ALTER TABLE users AUTO_INCREMENT = 10";
if($conn->query($sql)===FALSE){
    die("error running the query: ".$conn->error);}

$sql="CREATE TABLE IF NOT EXISTS job_provider(
    user_id INT(5) not  null,
    name VARCHAR(50) NOT NULL,
    phone_no VARCHAR(10) Not null,
    FOREIGN KEY(user_id) REFERENCES users(user_id))";
    if($conn->query($sql)===FALSE){
        die("error creating table: ".$conn->error);
    }

    $sql="CREATE TABLE IF NOT EXISTS job_seeker(
        user_id INT(5) not null,
        full_name varchar(30) not null,
        date_of_birth date not null,
        gender varchar(10) not null,
        skills VARCHAR(100) NOT NULL,
        education ENUM('High School', 'Diploma', 'Bachelor\'s Degree',
         'master\'s Degree', 'PhD', 'Other') Not null,
         seeker_address varchar(100) not null,
         seeker_phno varchar(10) not null,
        FOREIGN KEY(user_id) REFERENCES users(user_id))";
        if($conn->query($sql)===FALSE)
        {
            die("error creating table: ".$conn->error);
        }
        $sql="CREATE TABLE IF NOT EXISTS job_posting(
            user_id INT(5) not null,
            job_post_id int(5) auto_increment primary key,
            job_title varchar(50) not null,
            contact_no varchar(10) not null,
            schedule_type ENUM('Evening & weekend jobs','Flexible hours') Not null,
            job_type ENUM('Retail','Hospitality','Education','Healthcare','Finance','Customer service') Not null,
            schedule_requirement varchar(100) not null,
            location text not null,
            description text not null,
            posted_date date not null,
            exp_date date not null,
            salary int(10) not null,
            status boolean default true,
            admin_status boolean default false,
            FOREIGN KEY(user_id) REFERENCES users(user_id))";
            if($conn->query($sql)===FALSE){
                die("error creating table: ".$conn->error);
            }
            $sql="CREATE TABLE IF NOT EXISTS job_application(
                user_id INT(5) not null,
                provider_id int(5) not null,
                job_apply_id int(5) auto_increment primary key,
                job_post_id int(5)  not null,
                apply_date date not null,
                availabilty varchar(50) not null,
                experience varchar(100),
                application_status VARCHAR(50) DEFAULT 'Pending', 
                status boolean default true, 
                FOREIGN KEY(user_id) REFERENCES users(user_id),
                FOREIGN KEY(provider_id) REFERENCES job_provider(user_id),
                FOREIGN KEY(job_post_id) REFERENCES job_posting(job_post_id))";
                if (!$conn->query($sql)) {
                    $error = $conn->error;
                    echo "Error creating table: $error";
                }
        $sql="CREATE TABLE IF NOT EXISTS notifications (
        notification_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,  -- The user who will receive the notification
        message TEXT NOT NULL,  -- The content of the notification
        status ENUM('unread', 'read') DEFAULT 'unread',  -- The notification status
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- When the notification was created
         )";
        if (!$conn->query($sql)) {
        $error = $conn->error;
        echo "Error creating table: $error";
        }
           $sql="CREATE TABLE IF NOT EXISTS admins(
                 admin_id INT(5) AUTO_INCREMENT PRIMARY KEY,
                 Name VARCHAR(50) NOT NULL,
                 email VARCHAR(100) UNIQUE NOT NULL,
                 password VARCHAR(255) NOT NULL,
                 phone_number VARCHAR(20),
                 role VARCHAR(50) DEFAULT 'Admin')";
                 if (!$conn->query($sql)) {
                    $error = $conn->error;
                    echo "Error creating table: $error";
                }
/*$sql="INSERT INTO admins (Name, email, password, phone_number, role)
          VALUES ('Kadeeja shameer', 'kadeejashameer110@gmail.com', 'ks12345#', '8129030978', 'Admin')";
           if (!$conn->query($sql)) {
            $error = $conn->error;
            echo "Error running the query: $error";
        }*/
                 
?>