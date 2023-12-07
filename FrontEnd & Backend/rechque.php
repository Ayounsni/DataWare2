<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Recherche de Questions</title>
    <style>
        .result-table {
            margin-top: 20px;
        }
    </style>
</head>
<body class="vh-100" style="background-color: #6BA7F0;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem;">
                    <div class="d-flex justify-content-end px-3 py-1">
                        <a href="Gestionequi.php" class="text-danger fs-5">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none px-2 d-md-flex align-items-center">
                            <img src="../Image/ajouter.jpg" alt="login form" class="img-fluid" />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body text-black">
                                <!-- Formulaire unique pour la recherche par titre et tag -->
                                <form method="get" action="">
                                    <h5 class="fw-semibold mb-3 mt-3 pb-3" style="letter-spacing: 1px;">Recherche de Questions</h5>
                                    <div class="mb-3">
                                        <label for="search" class="my-2">Recherche par Titre ou Tag:</label>
                                        <div class="input-group">
                                            <input type="text" name="search" id="search" class="form-control" placeholder="Entrez le titre ou le tag">
                                            <button type="submit" class="btn btn-primary">Rechercher</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="result-table" id="resultTable"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search");
            const resultTable = document.getElementById("resultTable");

            searchInput.addEventListener("input", function() {
                const searchTerm = searchInput.value;
                if (searchTerm.length >= 2) {
                    // Effectuer la recherche AJAX ici
                    // Utilisez fetch() ou XMLHttpRequest pour envoyer une requête au serveur
                    // Mettez à jour resultTable avec les résultats de la recherche
                    // Exemple de fetch:
                    fetch(`search.php?search=${searchTerm}`)
                        .then(response => response.json())
                        .then(data => {
                            // Mettez à jour resultTable avec les données reçues
                            resultTable.innerHTML = renderResults(data);
                        })
                        .catch(error => {
                            console.error('Erreur lors de la recherche:', error);
                        });
                } else {
                    resultTable.innerHTML = "";
                }
            });

            function renderResults(data) {
                // Formatage des données reçues pour l'affichage dans resultTable
                let html = '<table class="table table-bordered">';
                html += '<thead><tr><th>ID</th><th>Titre</th><th>Contenu</th></tr></thead>';
                html += '<tbody>';
                data.forEach(row => {
                    html += `<tr><td>${row.id_question}</td><td>${row.titre}</td><td>${row.contenu}</td></tr>`;
                });
                html += '</tbody></table>';
                return html;
            }
        });
    </script>
</body>
</html>
