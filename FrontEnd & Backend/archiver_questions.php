<?php
session_start();
include("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'identifiant de la question à archiver depuis l'URL
    $question_id = $_GET['question_id'];

    // Vérifier si l'utilisateur est connecté et a le rôle de Scrum Master
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'scrum_master') {
        // Exécuter la requête SQL pour archiver la question
        $archive_query = "UPDATE questions SET archivee = 1 WHERE id_question = $question_id";
        mysqli_query($conn, $archive_query);

        // Rediriger l'utilisateur vers la page de pagination après l'archivage
        header("Location: community.php");
        exit();
    }
} else {
    // Si la page est accédée de manière incorrecte (non via le lien), rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>
