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
        ?>
</body>
</html>