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
$user_id=10;
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
 <form method="post" action=" " id="jobSeekerForm" onsubmit="return validatePhoneNumber()" >
        <h1>CREATE YOUR PROFILE</h1>
        <label>Enter your date of birth:</label>
        <input type="date" name="dob" required><br><br>
        <label>Select your gender:</label><br>
        <label class="lab">Female</label>
        <input type="radio" name="gender" value="female"><br>
        <label class="lab">Male</label>
        <input type="radio" name="gender" value="Male"><br><br>
        <label>About your skills:</label><br>
        <textarea name="skills" rows="5" cols="30" placeholder="Enter here..." required></textarea><br><br>
        <label>Select your educational status:</label>
        <select name="education" required>
            <option value="High School">High school</option>
            <option value="Diploma">Diploma</option>
            <option value="Bachelor's Degree">Bachelor's Degree</option>
            <option value="Master's Degree">Master's Degree</option>
            <option value="PhD">PhD</option>
            <option value="Other">Other</option>
        </select><br><br>
        <label>Enter your address:</label><br>
        <textarea name="address" rows="5" cols="30" placeholder="Enter here..." required></textarea><br><br>
        <label>Enter your phone number:</label>
        <input type="number" name="seeker_phno" placeholder="Enter your phone number" required><br><br>
        <button type="submit">SUBMIT</button>
    </form>
<?php
if (isset($_POST['submit']))
{
   $dob = $_POST['dob'];
   $gender = $_POST['gender'];
   $skills = $_POST['skills'];
   $education = $_POST['education'];
   $address = $_POST['address'];
   $seeker_phno = $_POST['seeker_phno'];

   $query = "INSERT INTO `job_seeker`(`user_id`, `date_of_birth`, `gender`, `skills`, `education`,
    `seeker_address`, `seeker_phno`) VALUES ('$user_id','$dob', '$gender', '$skills', '$education', '$address',
     '$seeker_phno')";
   if (mysqli_query($conn, $query)) {
       echo "Profile created successfully.";
   } else {
       echo "Error: " . mysqli_error($conn);
   }
}
?>
</body>
</html>