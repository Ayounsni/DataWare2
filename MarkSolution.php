<?php
session_start();
include "FrontEnd & Backend/connexion.php";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or display an error message
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Get the user's ID from the session
$user_id = $_SESSION['id'];

// Check the database connection
if (!$conn) {
    echo json_encode(['error' => 'Error connecting to the database: ' . mysqli_connect_error()]);
    exit();
}

// Check if the required parameters are set
if (!isset($_POST['reponse_id'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit();
}

$reponse_id = $_POST['reponse_id'];

// Retrieve the question ID associated with the response
$question_id_sql = "SELECT question_id FROM reponses WHERE id_reponse = $reponse_id";
$question_id_result = mysqli_query($conn, $question_id_sql);
$question_id_row = mysqli_fetch_assoc($question_id_result);

if (!$question_id_row) {
    echo json_encode(['error' => 'Error retrieving question ID']);
    exit();
}

$question_id = $question_id_row['question_id'];

// Check if the user who asked the question is the one trying to mark the solution
$check_user_sql = "SELECT user_id FROM questions WHERE id_question = $question_id";
$check_user_result = mysqli_query($conn, $check_user_sql);
$check_user_row = mysqli_fetch_assoc($check_user_result);

if (!$check_user_row || $check_user_row['user_id'] !== $user_id) {
    echo json_encode(['error' => 'Permission denied']);
    exit();
}

// Update the is_solution column
$sql = "UPDATE reponses SET is_solution = 1 WHERE id_reponse = $reponse_id";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => 'Response marked as solution']);
} else {
    echo json_encode(['error' => 'Error marking response as solution']);
}
?>
