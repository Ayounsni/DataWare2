<?php
include "FrontEnd & Backend/connexion.php";

// Trouver les projets avec le plus de questions
$query = "SELECT projets.nom_projet, COUNT(questions.id_question) as total_questions
          FROM projets
          LEFT JOIN questions ON projets.id_projets = questions.projet_id
          GROUP BY projets.id_projets
          ORDER BY total_questions DESC
          LIMIT 1";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Projets avec le plus de questions</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Projet avec le plus de questions :</h2>

        <?php if ($result && mysqli_num_rows($result) > 0) : ?>
            <?php $row = mysqli_fetch_assoc($result); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['nom_projet'] ?></h5>
                    <p class="card-text"><?= $row['total_questions'] ?> questions</p>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                Aucun projet trouvé.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>