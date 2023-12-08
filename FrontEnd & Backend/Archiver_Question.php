<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archiver une question</title>
</head>
<body>

<?php
include "connexion.php";

// Fonction pour archiver une question
function archiveQuestion($questionId, $userId, $reason, $conn)
{
    $sql = "INSERT INTO archives (user_id, question_id, raison) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Vérifier la préparation de la requête
    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }
    
    // Binder les paramètres
    $stmt->bind_param("iis", $userId, $questionId, $reason);
    
    // Exécuter la requête
    if ($stmt->execute() === true) {
        echo "La question a été archivée avec succès.";
    } else {
        echo "Erreur lors de l'archivage de la question : " . $stmt->error;
    }
    
    // Fermer la déclaration
    $stmt->close();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $questionId = $_POST["question_id"];
    $reason = $_POST["reason"];

    // Vérifier si la question existe
    $checkQuestionSql = "SELECT COUNT(*) FROM questions WHERE id_question = ?";
    $stmtCheckQuestion = $conn->prepare($checkQuestionSql);

    if ($stmtCheckQuestion === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtCheckQuestion->bind_param("i", $questionId);
    $stmtCheckQuestion->execute();
    $stmtCheckQuestion->bind_result($questionCount);
    $stmtCheckQuestion->fetch();
    $stmtCheckQuestion->close();

    if ($questionCount > 0) {
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
            // Archiver la question avec les données du formulaire
            archiveQuestion($questionId, $userId, $reason, $conn);
        } else {
            echo "L'utilisateur n'a pas les droits nécessaires pour archiver des questions.";
        }
    } else {
        echo "La question avec l'ID $questionId n'existe pas.";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>

<h2>Archiver une question</h2>

<form method="post" action="#">
    <label for="question_id">ID de la question à archiver :</label>
    <input type="text" name="question_id" required>
    
    <label for="reason">Raison de l'archivage :</label>
    <textarea name="reason" required></textarea>

    <input type="submit" value="Archiver la question">
</form>

</body>
</html>