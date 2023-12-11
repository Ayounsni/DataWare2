<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        nav {
            background-color: #343a40;
        }

        .card {
            width: 950px;
        }

        .bg1 {
            background-color: #f8f9fa;
        }
    </style>
    <title>Archiver une question</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <img src="Image/log.png" alt="logo" class="rounded-4" style="width: 80px; height: 60px;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="community.php">Community</a>
                    </li>
                    <li class="nav-item">
                        <a href="FrontEnd & Backend/deconnexion.php" class="btn btn-danger"><i
                                class="bi bi-box-arrow-left"></i> Deconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light text-center">
                        <h3 class="mb-0">Archiver une question</h3>
                    </div>
                    <div class="card-body bg1">
                        <?php
                        include("./FrontEnd & Backend/connexion.php");

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

                        <h2 class="mt-3">Archiver une question</h2>

                        <form method="post" action="#" class="mt-3">
                            <div class="mb-3">
                                <label for="question_id" class="form-label">ID de la question à archiver :</label>
                                <input type="text" name="question_id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Raison de l'archivage :</label>
                                <textarea name="reason" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Archiver la question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
