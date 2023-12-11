<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archiver une réponse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h2 {
            color: #007bff;
        }

        label {
            font-weight: bold;
            color: #495057;
        }

        textarea,
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
    </nav> -->

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-light text-center">
                        <h3 class="mb-0">Archiver une réponse</h3>
                    </div>
                    <div class="card-body bg-light">
                        <?php
                        include("./FrontEnd & Backend/connexion.php");

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

                        <h2 class="mt-3">Archiver une réponse</h2>

                        <form method="post" action="#" class="mt-3">
                            <div class="mb-3">
                                <label for="reponse_id">ID de la réponse à archiver :</label>
                                <input type="text" name="reponse_id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason">Raison de l'archivage :</label>
                                <textarea name="reason" class="form-control" required></textarea>
                            </div>
                            <input type="submit" value="Archiver la réponse" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>