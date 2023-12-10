<?php
session_start();
include "FrontEnd & Backend/connexion.php";


$question_id = $_GET['id'];
$req=mysqli_query($conn, "DELETE FROM questions WHERE id_question = $question_id");
header("Location: Mquestion.php");


?>