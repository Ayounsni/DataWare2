<?php
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $title = $_POST['title'];
   $question = $_POST['question'];
   $Tag = $_POST['Tag'];


// Insert into the 'questions' table
$query_questions = "INSERT INTO questions (titre, contenu) VALUES ('$title', '$question')";
$result_questions = mysqli_query($con, $query_questions);

// Insert into the 'Tags' table
$query_Tags = "INSERT INTO Tags (nom_Tag) VALUES ('$Tag')";
$result_Tags = mysqli_query($con, $query_Tags);

// Check if both queries were successful
if ($result_questions && $result_Tags) {
    echo "Data inserted successfully into both tables.";
    header('Location: ../Q&A.php');
} else {
    echo "Error: " . mysqli_error($con);
}
}