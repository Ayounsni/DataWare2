<?php
session_start();
include "FrontEnd & Backend/connexion.php";
$id=$_SESSION['question'];

$reponse_id = $_GET['id'];
$req=mysqli_query($conn, "DELETE FROM reponses WHERE id_reponse = $reponse_id");
header("Location: Question.php?id=$id");


?>