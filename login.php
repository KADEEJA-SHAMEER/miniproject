<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="post">
        <h1>LOGIN</h1>
        <label>Email: </label>
        <input type="email" name="email" placeholder="enter your email" required><br>
        <label>password: </label>
        <input type="password" name="psword" placeholder="enter your password" required ><br>
        <button type="submit" name="submit">LOGIN</button> 
        <p>Forget password?<a href="reset.php" >RESET</a></p>
        <p>Not Registered Yet? <a href="register.html">Register</a><p><br>
    </form>
</body>
</html>
<?php
require_once("connect.php");
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['psword'];
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $data = mysqli_query($conn, $sql);

    if (!$data) {
        echo "no data!";
    } 
    else
     {
        $users = [];
        while ($row = mysqli_fetch_array($data)) {
            if (($email == $row['email']) && ($password == $row['password'])) {
                $users = $row;
            }
        }

        if (!$users)
        {
            echo "<script>alert('Invalid user. Check the email and password you entered. If you are not registered, please register.')</script>";
        }
        else
        {
            $userid = $users['user_id'];
            $_SESSION['user_id'] = $userid;
            $firstLogin = $users['first_login'];
            $role=$users['role'];
            switch ($role)
            {
            case 'job provider':
                                if ($firstLogin)
                                 {
                                     header('Location: job-provider.html');
                                      exit;
                                 } else {
                                  header('Location: job-posting.html');
                                     exit;
                                 }
                                 break;
            case 'job seeker': 
                                 if ($firstLogin)
                                      {
                                       header('Location: job-seeker.html');
                                       exit;
                                      } else {
                                      header('Location: home.php');
                                      exit;
                                     }
                                 break;
            default : echo 'Unknown user role.';
                      break;
    
        }
    } 
     }
}
?>
