<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="form-container">
    <form action="" method="post">
        <div>
        <h1>LOGIN</h1>
        </div>
        <div class="div2">
        <input type="email" name="email" placeholder="enter your email" required><br><br>
        <input type="password" name="psword" placeholder="enter your password" required ><br><br>
        <button type="submit" name="submit">LOGIN</button> 
        <p>Forget password?<a href="reset.php" >RESET</a></p><br>
        <p>Not Registered Yet? <a href="register.html">Register</a><p><br>
        </div>
    </form>
    </div>
</body>
</html>
<?php
require_once("connect.php");
if (isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['psword'];
    $sql="SELECT * FROM users";
    $data=mysqli_query($conn,$sql);
    if(!$data)
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
       
    }
}
}
/*Login script
if ($user->loginSuccessful()) {
    // Check first login flag
    $firstLogin = $user->getFirstLogin();
    if ($firstLogin) {
        // Redirect to profile creation page
        header('Location: create-profile.php');
        exit;
    } else {
        // Redirect to dashboard or main page
        header('Location: dashboard.php');
        exit;
    }
}*/
?>