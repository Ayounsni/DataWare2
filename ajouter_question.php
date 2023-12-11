<!-- ajouter_question.php -->

<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "dataware_v2";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    $query = "INSERT INTO questions (titre, contenu) VALUES (:titre, :contenu)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':contenu', $contenu);

    if ($stmt->execute()) {
        echo 'La question a été ajoutée avec succès.';
    } else {
        echo 'Erreur lors de l\'ajout de la question : ' . $stmt->errorInfo()[2];
    }
}
?>
