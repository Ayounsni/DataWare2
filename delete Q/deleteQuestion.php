<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_question'])) {

    // Assuming you have a database connection established
    
    $questionIdToDelete = $_POST['id_question']; // Replace with the actual ID of the question you want to delete
    
    // Start a transaction
    mysqli_begin_transaction($con);
    
    try {
        // Delete related responses
        $deleteResponsesQuery = "DELETE FROM reponses WHERE question_id = $questionIdToDelete";
        if (mysqli_query($con, $deleteResponsesQuery)) {
            // Delete the question
            $deleteQuestionQuery = "DELETE FROM questions WHERE id_question = $questionIdToDelete";
            if (mysqli_query($con, $deleteQuestionQuery)) {
                // If both queries executed successfully, commit the transaction
                mysqli_commit($con);
                echo "Question and its responses deleted successfully.";
            } else {
                throw new mysqli_sql_exception("Error deleting question: " . mysqli_error($con));
            }
        } else {
            throw new mysqli_sql_exception("Error deleting responses: " . mysqli_error($con));
        }
    } catch (mysqli_sql_exception $e) {
        // If an error occurred, rollback the transaction
        mysqli_rollback($con);
    
        // Handle the error (you can log or display an error message)
        echo "Error: " . $e->getMessage();
    }
    
    // Close the database connection
    mysqli_close($con);
    
    
} else {
}
?>
