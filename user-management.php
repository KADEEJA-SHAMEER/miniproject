<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once("connect.php");

    $sql="SELECT *FROM `users` WHERE `user_status`=true";
    $data=mysqli_query($conn,$sql);
    if(mysqli_num_rows($data)>0)
    {
        echo"<table>";
        echo "<tr>";
        echo "<th>Name of the use</th>";
        echo "<th>Email id</th>";
        echo "<th>Role</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($data))
           {
            echo"<tr>";
            echo"<form action='' method='post'>";
            echo"<td><input type='text' name='Name' value=".$row['Name']."></td>";
            echo "<td><input type='text' name='email' value=".$row['email'].".</td>";
            echo"<td><input type='text' name='role' value=".$row['role']."></td>";
            echo"<input type='hidden' name='user_id' value=".$row['user_id'].">";
            echo"<td><button type=submit name='edit' >EDIT</button></td>";
            echo"<td> <button type=submit name='delete' >DELETE</button></td>";
            echo"</tr>";
          }
        echo"</table>";
        }
        if(isset($_POST['edit']))
        {
          $name=$_POST['Name'];
          $role=$_POST['role'];
          $email=$_POST['email'];
          $user_id=$_POST['user_id'];
          $sql="UPDATE `users` SET `Name`='$name',`email`='$email',`role`='$role' 
          WHERE `user_id`='$user_id'";
          $data=mysqli_query($conn,$sql);
          if(!$data)
          {
            echo "<script>alert('Error updating values')</script>";
          }
          else{
            echo "<script>alert('Updated Successfully')</script>";
          }
        }
       if(isset($_POST['delete']))
       {
        $user_id=$_POST['user_id'];
        $sql="UPDATE `users` SET `user_status`=false WHERE `user_id`='$user_id' ";
        $data=mysqli_query($conn,$sql);
        if($data)
        {
          echo"<scrpit>alert('user deleted successfully')</script>";
        }
        else
        {
          echo"<script>alert('error deleting the user')</script>";
        }
       }
        ?>
</body>
</html>