<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contenu']) && isset($_POST['newcontenu'])) {
    // Fetch the project name from the form
    $contenu = $_POST['contenu'];

    // Fetch the new content from the form
    // For example, let's assume you have a form field named 'newcontenu'
    $newcontenu = mysqli_real_escape_string($con, $_POST['newcontenu']);

    // Perform the modification query
    $update_query = "UPDATE questions SET contenu = '$newcontenu' WHERE contenu = '$contenu'";
    mysqli_query($con, $update_query);

    // Redirect back to the page after modification
    header('Location: ../Q&A.php');
    exit();
} else {
    // Handle the case when the form is not submitted properly
    // You may want to display an error message or redirect to an error page
}
?>
