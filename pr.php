<?php
include "FrontEnd & Backend/connexion.php";

// Consulter le nombre de questions par projet
$query = "SELECT projets.nom_projet, COUNT(questions.id_question) as total_questions
          FROM projets
          LEFT JOIN questions ON projets.id_projets = questions.projet_id
          GROUP BY projets.id_projets";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Statistiques</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Nombre de questions par projet :</h2>

        <?php if ($result) : ?>
            <ul class="list-group">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $row['nom_projet'] ?>
                        <span class="badge bg-primary rounded-pill"><?= $row['total_questions'] ?> questions</span>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                Erreur lors de la récupération des données.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
