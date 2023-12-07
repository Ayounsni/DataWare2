<?php
require_once('config/db.php');

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'id_question' parameter exists in the POST data
    if (isset($_POST['id_question']) && isset($_POST['reponce'])) {
        // Retrieve the value of 'id_question' and sanitize inputs
        $id_question = mysqli_real_escape_string($con, $_POST['id_question']);
        $reponce = mysqli_real_escape_string($con, $_POST['reponce']);

        $query_reponce = "INSERT INTO reponses (question_id, contenu) VALUES ('$id_question', '$reponce')";
        $result_reponce = mysqli_query($con, $query_reponce);

        // Check if both queries were successful
        if ($result_reponce) {
            header('Location: community.php');
            exit(); // Make sure to exit after the header to prevent further execution
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
} else {
    // Handle the case when the form was not submitted using POST method
    echo "Error: Form was not submitted using POST method.";
}

// Close the connection
mysqli_close($con);
?>
