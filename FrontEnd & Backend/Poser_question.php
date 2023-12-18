<?php
session_start();
if($_SESSION['autoriser'] != "oui"){
  header("Location: index.php");
  exit();
}
$erreur="";
include "connexion.php";
$membre= $_SESSION['id'];
$select="SELECT * FROM users WHERE id_user=$membre";
  $query = mysqli_query($conn,$select);
  $fetch = mysqli_fetch_assoc($query);
  if (isset($_POST["sub"])) {
    // Retrieve the tags as a string
    $tagsArray = $_POST["tag"];
    foreach ($tagsArray as $tag) {
        if (preg_match('/\s/', $tag)) {
            // Display an error message or handle it as needed
            $errors['tag'] = "Les tags ne doivent pas contenir d'espaces.";
            break; // Stop further processing if there's an error
        }
    }

    if (empty($errors)) {

    // Escape each tag individually
    foreach ($tagsArray as &$tag) {
        $tag = mysqli_real_escape_string($conn, $tag);
    }
    unset($tag); // Unset the reference to the last element to avoid unexpected behavior

    // Use implode to create a comma-separated string of escaped tags
    $tagsString = implode(",", $tagsArray);

    // Use explode to create an array of tags
    $tagsArray = explode(",", $tagsString);

    foreach ($tagsArray as $tagId) {
        // Vérification si le tag existe déjà dans la table des tags avec une requête préparée
        $tagId = trim($tagId);  // Trim les espaces du nom du tag
        $checkQuery = mysqli_prepare($conn, "SELECT * FROM tags WHERE nom_tag = ?");
        mysqli_stmt_bind_param($checkQuery, "s", $tagId);
        mysqli_stmt_execute($checkQuery);

        // Récupérez le résultat
        $result = mysqli_stmt_get_result($checkQuery);

        if (mysqli_num_rows($result) == 0 && !empty($tagId)) {
            // Si le tag n'existe pas et n'est pas vide, l'ajouter à la table des tags avec une requête préparée
            $insertQuery = mysqli_prepare($conn, "INSERT INTO tags (nom_tag) VALUES (?)");
            mysqli_stmt_bind_param($insertQuery, "s", $tagId);
            mysqli_stmt_execute($insertQuery);
        }
        // Vous pouvez également gérer le cas où le tag existe déjà

        // Fermez la requête préparée
        mysqli_stmt_close($checkQuery);
        mysqli_stmt_close($insertQuery);
    }

    header("Location: poser_question.php");
    exit(); // Assurez-vous de sortir après une redirection d'en-tête
}
}



  if (isset($_POST["submit"])) {
    // Récupérer les valeurs du formulaire
    $projet_id = $_POST["projet"];
    $titre = $_POST["name"];
    $contenu = $_POST["text"];

    // Les tags sélectionnés sont un tableau, vous pouvez les récupérer directement
    $tags = $_POST["tags"];
    if (empty($projet_id)) {
        $errors['projet'] = "Vous n'avez pas de projet.";
    }

    if (empty($titre)) {
        $errors['name'] = "Le champ Titre est obligatoire.";
    }

    if (empty($contenu)) {
        $errors['text'] = "Le champ Contenu est obligatoire.";
    }

    if (empty($tags)) {
        $errors['tags'] = "Le champ Tags est obligatoire.";
    }

    
    if (!empty($errors)) {
        // Afficher les erreurs sous chaque champ
        foreach ($errors as $field => $error) {
        
        }
    } else {
    

    // Insérer la question dans la table des questions
    $requeteQuestion = $conn->prepare("INSERT INTO questions (projet_id, user_id, titre, contenu) VALUES (?, ?, ?, ?)");
    $requeteQuestion->bind_param("iiss", $projet_id, $membre, $titre, $contenu);

    // Exécutez la requête
    $requeteQuestion->execute();

    // Récupérez l'ID de la question insérée
    $question_id = mysqli_insert_id($conn);

    // Insérer les tags dans la table de pivot (tag_reponse) avec une requête préparée
    $requeteTag = $conn->prepare("INSERT INTO question_tags (question_id, tag_id) VALUES (?, ?)");

    // Utilisez la boucle foreach pour exécuter la requête pour chaque tag
    foreach ($tags as $tag_id) {
        $requeteTag->bind_param("ii", $question_id, $tag_id);
        $requeteTag->execute();
    }

    // Fermez les requêtes préparées
    $requeteQuestion->close();
    $requeteTag->close();

    // Redirigez l'utilisateur vers la page community.php
    header("Location: community.php");
    exit();
}
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="style.css" type="text/css">

    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-scroll  shadow-0 border-bottom border-dark">
            <div class="container">
                <img src="../Image/log.png" alt="logo" class="rounded-4" style="width: 80px; height: 60px;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class=" text-light bi bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto d-flex gap-5">
                        <li class="nav-item">
                            <a class="nav-link text-center" href="community.php">Community</a>
                        </li>

                        <a href="deconnexion.php"
                            class="btn bg-danger p-2 rounded-3 text-light text-decoration-none "><i
                                class="bi bi-box-arrow-left"></i> Deconnexion</a>
                    </ul>
                </div>
            </div>
        </nav>



        <div class="container center mt-4 mb-4 ">
            <div class="row ">
                <div class="col d-flex justify-content-center ">

                    <div class="card  " style="width: 950px;">
                        <div class="card-header navbar-scroll ">
                            <h3 class="mb-0 text-center text-light fw-light w-100">Poser une question</h3>
                        </div>
                        <div class="card-body bg1 d-flex flex-column align-items-center w-100">
                            <img src="../Image/data.png" class="img-fluid " alt="img">
                            <form method="post" action="">
                                <div class="d-flex flex-row gap-2">
                                    <div class="form-floating mb-3 mt-3 ">
                                        <input type="text" name="tag[]" class="form-control w1" id="floatingInput"
                                            placeholder="name" required>
                                        <label class="text-secondary fs " for="floatingInput">Ajouter les tags (
                                            Entre
                                            chaque tag virgule "," )</label>
                                        <?php if (isset($errors['tag']) && !empty($errors['tag'])): ?>
                                        <span style='color: red;'><?= $errors['tag']; ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <button
                                        class="btn btn-primary h-100 align-middle align-self-center btn-md btn-block "
                                        type="submit" name="sub">Ajouter</button>

                                </div>
                            </form>
                            <form method="post" action="">
                                <div class="form-floating w-100 mt-3">
                                    <select class="form-select" name="projet" id="floatingSelect"
                                        aria-label="Floating label select example">
                                        <option value="" selected>Sélectionnez Projet</option>

                                        <?php
                                         if($fetch["role"]== "user"){
                                            $queryProjets = mysqli_query($conn, "SELECT * FROM projets INNER JOIN equipes ON projets.equipe_id = equipes.id_equipe INNER JOIN users ON equipes.id_equipe = users.id_equip  WHERE id_user=$membre ");
                                            while ($Projets = mysqli_fetch_assoc($queryProjets)) {
                                             echo "<option value='{$Projets['id_projets']}'>{$Projets['nom_projet']}</option>";
                                          }
                     
                                          }
                                          elseif($fetch["role"]== "scrum_master"){
                                            $queryProjets = mysqli_query($conn, "SELECT * FROM projets WHERE scrum_master_id=$membre ");
                                            while ($Projets = mysqli_fetch_assoc($queryProjets)) {
                                             echo "<option value='{$Projets['id_projets']}'>{$Projets['nom_projet']}</option>";
                                            }
                                        } else
                                            $queryProjets = mysqli_query($conn, "SELECT * FROM projets");
                                            while ($Projets = mysqli_fetch_assoc($queryProjets)) {
                                             echo "<option value='{$Projets['id_projets']}'>{$Projets['nom_projet']}</option>";
                                            }
                                        
                              
                               ?>
                                    </select>
                                    <label for=" floatingSelect">Question a propos ce projet</label>
                                    <span
                                        class="ms-2 text-danger "><?php echo isset($errors['projet']) ? $errors['projet'] : ''; ?></span>
                                </div>

                                <div class="form-floating mb-3 mt-3 ">
                                    <input type="text" name="name" class="form-control w-100 w" id="floatingInput"
                                        placeholder="name">
                                    <label class="text-secondary " for="floatingInput">Titre de question</label>
                                    <span
                                        class="ms-2 text-danger "><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
                                </div>
                                <div class="form-floating mt-3  ">
                                    <textarea name="text" class="form-control h-80" placeholder="Leave a comment here"
                                        id="floatingTextarea"></textarea>
                                    <label for=" floatingTextarea" class="text-secondary">Contenu</label>
                                    <span
                                        class="ms-2 text-danger "><?php echo isset($errors['text']) ? $errors['text'] : ''; ?></span>
                                </div>
                                <div class="mt-3">
                                    <p class="m-0">Ajoutez des tags :</p>
                                    <select id="tags" name="tags[]" class="form-control" multiple required>

                                        <?php
                                        $querytags = mysqli_query($conn, "SELECT * FROM tags ");
                                        while ($tags = mysqli_fetch_assoc($querytags)) {
                                         echo "<option value='{$tags['id_tag']}'>{$tags['nom_tag']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="pt-1 mb-3 d-flex mt-2 justify-content-end">
                                        <button class="btn btn-primary btn-md btn-block " type="submit"
                                            name="submit">Valider</button>
                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

            <script>
            $(document).ready(function() {
                $('#tags').select2({
                    tags: false, // Permet aux utilisateurs d'ajouter de nouveaux tags
                    tokenSeparators: [',', ' '] // Délimiteurs de séparation entre les tags
                });
            });
            </script>




</body>

</html>