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
        <label>Email: </label><br>
        <input type="email" name="email" placeholder="enter your email" required><br><br>
        <label>password: </label><br>
        <input type="password" name="psword" placeholder="enter your password" required ><br><br>
        <button type="submit" name="submit">LOGIN</button> 
        <p>Forget password?<a href="reset.php" >RESET</a></p>
        <p>Not Registered Yet? <a href="register.html">Register</a><p><br>
    </form>
</body>
</html>
<?php
/*require_once("connect.php");
session_start();
if (isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['psword'];
    $sql="SELECT * FROM users";
    $data=mysqli_query($conn,$sql);
    if(mysqli_num_rows($data)<0)
    {
        echo "query failed!";
    }
    else
    {
      $users = [];
      while($row=mysqli_fetch_array($data))
      {
        if(($email == $row['email'])&&($password == $row['password']))
        {
          $users=$row;
        }
      }
      if(!$users)
      {
         echo "<script><alert>invalid user  check the email and password you entered is correct
           if you are not registered please register</alert></script>";
      }
     else 
     {
       echo"valid user";
       $sqll="SELECT * FROM `users` WHERE email='$email'";
       $data1=mysqli_query($conn,$sqll);
       $row=mysqli_fetch_array($data1);
       $userid=$row['user_id'];
       echo"$userid";
       $_SESSION['user_id'] = $userid; 
    }
}
}

?>




<?php */
require_once("connect.php");
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['psword'];
    echo $email;
    echo $password;

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $data = mysqli_query($conn, $sql);

    if (mysqli_num_rows($data) >=0) {
        $user = mysqli_fetch_array($data);
        $_SESSION['user_id'] = $user['user_id'];
        $userid=$user['user_id'];
        echo $userid;
        // Check first login flag
        $firstLogin = $user['first_login'];
        echo $firstloginl;
        if ($firstLogin) {
            // Redirect to profile creation page
            header('Location:job-provider.html');
            exit;
        } else {
            // Redirect to dashboard or main page
            header('Location: home.php');
            exit;
        }
    } else {
        echo "<script>alert('Invalid user. Check the email and password you entered. If you are not registered, please register.')</script>";
    }
}
?>
