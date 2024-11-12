<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
      /* Table Styles */
table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f8f8;
    color: #333;
    font-weight: bold;
}

td input[type="text"] {
    width: 100%;
    padding: 8px;
    font-size: 14px;
    border: none;
    outline: none;
    border: none;
    outline: none;
   /* background-color: #f0f0f0;*/
}

/* Button Styling */
button[type="submit"] {
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Table container for responsive design */
.table-container {
    overflow-x: auto;
    margin: 20px 0;
}
</style>
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
            echo"<td><input type='text' name='Name' value='". htmlspecialchars($row['Name'])."'></td>";
            echo "<td><input type='text' name='email' value=".$row['email'].">.</td>";
            echo "<td><input type='text' name='role' value='" . htmlspecialchars($row['role']) . "'></td>";
            echo"<input type='hidden' name='user_id' value=".$row['user_id'].">";
            echo"<td><button type=submit name='edit' >EDIT</button></td>";
            echo"<td> <button type=submit name='delete' >DELETE</button></td>";
            echo"</tr>";
          }
        echo"</table>";
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
        $role=$_POST['role'];
        $user_id=$_POST['user_id'];
        $sql="UPDATE `users` SET `user_status`=false WHERE `user_id`='$user_id' ";
        $data=mysqli_query($conn,$sql);
        if($data)
        {
          if($role=='job provider')
          {
            $sql1="UPDATE `job_posting` SET `status`=false WHERE `user_id`='$user_id'";
            $data1=mysqli_query($conn,$sql1);
            $sql2="UPDATE `job_application` SET `status`='false' WHERE `provider_id`='$user_id'";
            $data2=mysqli_query($conn,$sql2);
            if($data1 && $data2)
            {
              echo "<scriptt>alert('user deleted successfully')</script>";
            }
          }
          else
          {
            if($role=='job seeker')
             {
              $sql3="UPDATE `job_application` SET `status`='false' WHERE `user_id`='$user_id'";
              $data3=mysqli_query($conn,$sql3);
              if($data3)   
                echo"<scrpit>alert('user deleted successfully')</script>";
            }
        }
        }
        else
        {
          echo"<script>alert('error deleting the user')</script>";
        }
       }
        }
        ?>
</body>
</html>