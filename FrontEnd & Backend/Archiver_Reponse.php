<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archiver une réponse</title>
</head>
<body>

<?php
include "connexion.php";

// Fonction pour archiver une réponse
function archiveReponse($reponseId, $userId, $reason, $conn)
{
    $sql = "INSERT INTO archives (user_id, reponse_id, raison) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vérifier la préparation de la requête
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    
    // Binder les paramètres
    $stmt->bind_param("iis", $userId, $reponseId, $reason);
    
    // Exécuter la requête
    if ($stmt->execute() === true) {
        echo "La réponse a été archivée avec succès.";
    } else {
        echo "Erreur lors de l'archivage de la réponse : " . $stmt->error;
    }
    
    // Fermer la déclaration
    $stmt->close();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $reponseId = $_POST["reponse_id"];
    $reason = $_POST["reason"];

    // Vérifier si la réponse existe
    $checkReponseSql = "SELECT COUNT(*) FROM reponses WHERE id_reponse = ?";
    $stmtCheckReponse = $conn->prepare($checkReponseSql);

    if ($stmtCheckReponse === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtCheckReponse->bind_param("i", $reponseId);
    $stmtCheckReponse->execute();
    $stmtCheckReponse->bind_result($reponseCount);
    $stmtCheckReponse->fetch();
    $stmtCheckReponse->close();

    if ($reponseCount > 0) {
        // Vérifier le rôle de l'utilisateur (Scrum Master)
        $userId = 3; // ID de l'utilisateur Scrum Master (à récupérer depuis votre système d'authentification)

        $sqlRole = "SELECT role FROM users WHERE id_user = ?";
        $stmtRole = $conn->prepare($sqlRole);

        if ($stmtRole === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        $stmtRole->bind_param("i", $userId);
        $stmtRole->execute();
        $stmtRole->bind_result($role);
        $stmtRole->fetch();
        $stmtRole->close();

        // Vérifier si l'utilisateur est Scrum Master
        if ($role === 'scrum_master') {
            // Archiver la réponse avec les données du formulaire
            archiveReponse($reponseId, $userId, $reason, $conn);
        } else {
            echo "L'utilisateur n'a pas les droits nécessaires pour archiver des réponses.";
        }
    } else {
        echo "La réponse avec l'ID $reponseId n'existe pas.";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>

<h2>Archiver une réponse</h2>

<form method="post" action="#">
    <label for="reponse_id">ID de la réponse à archiver :</label>
    <input type="text" name="reponse_id" required>
    
    <label for="reason">Raison de l'archivage :</label>
    <textarea name="reason" required></textarea>

    <input type="submit" value="Archiver la réponse">
</form>

</body>
</html>