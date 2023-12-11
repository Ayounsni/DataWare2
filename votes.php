<?php
session_start();
include "FrontEnd & Backend/connexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $question_id = $data['question_id'];
        $type = $data['type'];

        // Check if the user has already voted for this question
        $checkVoteQuery = "SELECT * FROM votes WHERE user_id = $user_id AND question_id = $question_id";
        $checkVoteResult = mysqli_query($conn, $checkVoteQuery);

        if ($checkVoteResult) {
            if (mysqli_num_rows($checkVoteResult) > 0) {
                // User has already voted, delete the existing vote
                $deleteVoteQuery = "DELETE FROM votes WHERE user_id = $user_id AND question_id = $question_id";
                mysqli_query($conn, $deleteVoteQuery);
                echo json_encode(['success' => true, 'message' => 'Vote removed']);
            } else {
                // User has not voted, insert a new vote
                $insertVoteQuery = "INSERT INTO votes (user_id, question_id, type) VALUES ($user_id, $question_id, '$type')";
                mysqli_query($conn, $insertVoteQuery);
                echo json_encode(['success' => true, 'message' => 'Vote added']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error executing SQL query: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
