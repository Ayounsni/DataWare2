<?php
include "FrontEnd & Backend/connexion.php";

// Trouver l'utilisateur avec le plus de réponses
$query = "SELECT users.First_name, users.Last_name, 
          COALESCE(COUNT(DISTINCT reponses.id_reponse), 0) as total_reponses
          FROM users
          LEFT JOIN questions ON users.id_user = questions.user_id
          LEFT JOIN reponses ON questions.id_question = reponses.question_id
          GROUP BY users.id_user
          ORDER BY total_reponses DESC
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
    <title>Utilisateur avec le plus de réponses</title>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Utilisateur avec le plus de réponses :</h2>

        <?php if ($result && mysqli_num_rows($result) > 0) : ?>
            <?php $row = mysqli_fetch_assoc($result); ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['First_name'] ?> <?= $row['Last_name'] ?></h5>
                    <p class="card-text"><?= $row['total_reponses'] ?> réponses</p>
                </div>
            </div>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                Aucun utilisateur trouvé.
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
mysqli_close($conn);
?>
