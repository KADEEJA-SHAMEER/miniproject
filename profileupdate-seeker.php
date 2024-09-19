<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style-jobseeker.css">
    <script>

   function validatePhoneNumber(phoneNumber) {
    const phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phoneNumber);
}

        function calculateAge(dob) {
    const today = new Date();
    const birthDate = new Date(dob);
    const age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth() - birthDate.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function validateForm() {
    const phoneNumber = document.querySelector('input[name="seeker_phno"]').value;
    const dob = document.querySelector('input[name="dob"]').value;

    if (!validatePhoneNumber(phoneNumber)) {
        alert("Invalid phone number. Please enter a 10-digit number.");
        return false;
    }

    const age = calculateAge(dob);
    if (age < 18) {
        alert("You are a minor and cannot create a profile.");
        return false;
    }

    return true;
}


    </script>
</head>
<body>
    
<?php
require_once("connect.php");
session_start();
/*$user_id= $_SESSION['user_id']; */
$user_id=12;
$sql="SELECT * FROM job_seeker where user_id='$user_id'";
$data=mysqli_query($conn,$sql);
if($data)
{
  $row=mysqli_fetch_array($data);
  
}
else
{
    echo"no data retrieved";
}
?>
 <form method="post" action="" id="jobSeekerForm" onsubmit="return validateForm()" >
        <h1>CREATE YOUR PROFILE</h1>
        <label>Enter your date of birth:</label>
        <input type="date" name="dob"  value="<?php echo $row['date_of_birth']; ?>" ><br><br>
        <label>Select your gender:</label><br>
        <label class="lab">Female</label>
        <input type="radio" name="gender" value="female"<?php if($row['gender'] == 'female') echo 'checked'; ?>><br>
        <label class="lab">Male</label>
        <input type="radio" name="gender" value="Male"<?php if($row['gender'] == 'Male') echo 'checked'; ?>><br><br>
        <label>About your skills:</label><br>
        <textarea name="skills" rows="5" cols="30" ><?php echo $row['skills']; ?></textarea><br><br>
        <label>Select your educational status:</label>
        <select name="education" required>
            <option value="High School" <?php if($row['education'] == 'High School') echo 'selected'; ?>>High school</option>
            <option value="Diploma"<?php if($row['education'] == 'Diploma') echo 'selected'; ?>>Diploma</option>
            <option value="Bachelor's Degree"<?php if($row['education'] == 'Bachelor\'s Degree') echo 'selected'; ?>>Bachelor's Degree</option>
            <option value="Master's Degree" <?php if($row['education'] == 'Master\'s Degree') echo 'selected'; ?>>Master's Degree</option>
            <option value="PhD" <?php if($row['education'] == 'PhD') echo 'selected'; ?>>PhD</option>
            <option value="Other <?php if($row['education'] == 'Other') echo 'selected'; ?>">Other</option>
        </select><br><br>
        <label>Enter your address:</label><br>
        <textarea name="address" rows="5" cols="30" ><?php echo $row['seeker_address']; ?></textarea><br><br>
        <label>Enter your phone number:</label>
        <input type="number" name="seeker_phno"  value="<?php echo $row['seeker_phno']; ?>" ><br><br>
        <button type="submit" name="submit">UPDATE PROFILE</button>
    </form>
<?php
if (isset($_POST['submit']))
{
   $dob = $_POST['dob'];
   $gender = $_POST['gender'];
   $skills = $_POST['skills'];
   $education = mysqli_real_escape_string($conn, $_POST['education']);
   $address = $_POST['address'];
   $seeker_phno = $_POST['seeker_phno'];
   $query = "UPDATE `job_seeker` SET `date_of_birth`='$dob',
   `gender`='$gender',`skills`='$skills',`education`='$education',`seeker_address`='$address',
   `seeker_phno`='$seeker_phno' WHERE `user_id`='$user_id'";
   if (mysqli_query($conn, $query)) {
    header("Location: profileupdate-seeker.php");
    exit;
       echo "Profile updated successfully.";

   } else {
       echo "Error: " . mysqli_error($conn);
   }
}
?>
</body>
</html>