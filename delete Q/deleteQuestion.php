<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_question'])) {

    // Fetch the project name from the form
    $id_question = $_POST['id_question'];

    // Perform the deletion query
    $delete_query = "DELETE FROM questions WHERE id_question = '$id_question'";
    mysqli_query($con, $delete_query);

    // Redirect back to the page after deletion
    header('Location: ../community.php');
    exit();
} else {
}
?>
