<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "dataware_v3";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assurez-vous de filtrer et valider les données du formulaire
        $question_id = filter_input(INPUT_POST, 'question_id', FILTER_SANITIZE_NUMBER_INT);
        $contenu_reponse = filter_input(INPUT_POST, 'contenu_reponse', FILTER_SANITIZE_STRING);

        // Vérifiez si les valeurs nécessaires sont présentes
        if ($question_id !== null && $contenu_reponse !== null) {
            $query = "INSERT INTO reponses (question_id, contenu) VALUES (:question_id, :contenu_reponse)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
            $stmt->bindParam(':contenu_reponse', $contenu_reponse, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo 'La réponse a été ajoutée avec succès.';
            } else {
                echo 'Erreur lors de l\'ajout de la réponse : ' . $stmt->errorInfo()[2];
            }
        } else {
            echo 'Les données du formulaire sont invalides.';
        }
    }
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}

// Fermez la connexion à la base de données à la fin du script
$conn = null;
?>
