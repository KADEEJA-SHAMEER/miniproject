<?php
require_once("connect.php");
if(isset($_POST['search']))
{
    $searching = $_POST['searching']; // Get the selected filter value

    // Redirect based on the selected value
    switch ($searching) {
        case 'flexible-hours':
            // Redirect to page listing flexible hours jobs
            header('Location: searching/flexible-hours.php');
            break;

        case 'weekend-jobs':
            // Redirect to page listing weekend jobs
            header('Location: searching/weekend-jobs.php');
            break;

        case 'retail':
            // Redirect to retail jobs page
            header('Location: searching/retail.php');
            break;

        case 'hospitality':
            // Redirect to hospitality jobs page
            header('Location: searching/hospitality.php');
            break;

        case 'education':
            // Redirect to education jobs page
            header('Location:searching/education.php');
            break;

        case 'healthcare':
            // Redirect to healthcare jobs page
            header("Location: searching/healthcare.php");
            break;

        case 'finance':
            // Redirect to finance jobs page
            header("Location:searching/finance.php");
            break;

        case 'customer-service':
            // Redirect to customer service jobs page
            header("Location: searching/customer-service.php");
            break;

        default:
            // If the selected value doesn't match any case, you can redirect to a default page
            header("Location: seeker-main.html");
            echo"<script>alert('invalid category')</script>";
            break;
    }

    // It's a good practice to call exit() after header redirection to stop the rest of the script from executing
    exit();
}
?>
