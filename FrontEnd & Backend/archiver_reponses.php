<?php
session_start();
include("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'identifiant de la réponse à archiver depuis l'URL
    $reponse_id = $_GET['reponse_id'];

    // Vérifier si l'utilisateur est connecté et a le rôle de Scrum Master
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'scrum_master') {
        // Récupérer l'identifiant de la question associée à la réponse
        $query = "SELECT question_id FROM reponses WHERE id_reponse = $reponse_id";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $question_id = $row['question_id'];

            // Exécuter la requête SQL pour archiver la réponse
            $archive_query = "UPDATE reponses SET archivee = 1 WHERE id_reponse = $reponse_id";
            mysqli_query($conn, $archive_query);

            // Rediriger l'utilisateur vers la page de la question après l'archivage
            header("Location: Community.php");
            exit();
        } else {
            // Gestion de l'erreur de requête
            echo "Erreur de requête : " . mysqli_error($conn);
        }
    }
} else {
    // Si la page est accédée de manière incorrecte (non via le lien), rediriger vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>


