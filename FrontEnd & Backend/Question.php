<?php
session_start();
include "connexion.php";
$message="";
$question_id = $_GET['id'];
$_SESSION['question'] = $_GET['id'];
$user= $_SESSION['username'];
$role= $_SESSION['role'];
$sql = "SELECT * FROM questions INNER JOIN users ON questions.user_id  = users.id_user WHERE questions.id_question = $question_id ";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$membre= $_SESSION['id'];

if (isset($_POST["submit"])) {
    $text = $_POST["text"];
    
    $requete = "INSERT INTO reponses (user_id , question_id, contenu) VALUES ('$membre', '$question_id', '$text')";
      $query = mysqli_query($conn, $requete);
      header("Location: Question.php?id=$question_id");
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
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-scroll  shadow-0 border-bottom border-dark">
            <div class="container">

                <img src="../Image/log.png" alt="logo" class="rounded-4" style="width: 80px; height: 60px;">
                <div class="input-group  ms-md-4 ">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init><i
                            class="bi bi-search"></i></button>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class=" text-light bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto d-flex gap-5">
                        <?php
    if($role == "user") {
        ?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="community.php.php">Community</a>
                        </li>

                        <li class="nav-item w-1">
                            <a class="nav-link text-center" href="Gestionequi.php">Equipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Assignation.php">Projets</a>
                        </li>
                        <li class="nav-item">
                            <a href="deconnexion.php"
                                class="btn bg-danger p-2 rounded-3 text-light text-decoration-none d-flex gap-1 ">
                                <i class="bi bi-box-arrow-left"> </i>
                                <p class="m-0"> Deconnexion </p>
                            </a>
                        </li>
                        <?php
    } elseif($role == "scrum_master") {
        ?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Community</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Equipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Gestionequi.php">Membres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Assignation.php">Assignation</a>
                        </li>
                        <li class="nav-item">
                            <a href="deconnexion.php"
                                class="btn bg-danger p-2 rounded-3 text-light text-decoration-none d-flex gap-1 ">
                                <i class="bi bi-box-arrow-left"> </i>
                                <p class="m-0"> Deconnexion </p>
                            </a>
                        </li>

                        <?php
    } else {
        ?>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Community</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="DashboardM.php">Projets</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="MembreP.php">Membres</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link" href="assigner.php">Assignation</a>
                        </li>
                        <li class="nav-item">
                            <a href="deconnexion.php"
                                class="btn bg-danger p-2 rounded-3 text-light text-decoration-none d-flex gap-1 ">
                                <i class="bi bi-box-arrow-left"> </i>
                                <p class="m-0"> Deconnexion </p>
                            </a>
                        </li>
                        <?php
    }
    ?>

                    </ul>


                </div>
            </div>
        </nav>



        <div class="d-flex flex-lg-row justify-content-between flex-sm-column flex-md-column">
            <div class="d-flex justify-content-center mt-3 w-25 p-3 d-none d-lg-block ">
                <a href="community.php"
                    class="col-md-auto col-sm-12 bg-danger p-2 rounded-3 text-light text-decoration-none btn mt-1 w-100"><i
                        class="bi bi-arrow-return-left"></i> Retour</a>
                <a href="poser_question.php"
                    class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-100"><i
                        class="bi bi-bookmark-plus-fill"></i> Poser une question</a>
            </div>
            <div class="vr"></div>
            <div class="d-flex flex-column col w-100 p-4">

                <div class="d-flex  flex-column align-items-start  ">
                    <a href="community.php"
                        class="col-md-auto col-sm-12 bg-danger p-2 rounded-3 text-light text-decoration-none btn mt-1 d-block d-lg-none w-75"><i
                            class="bi bi-arrow-return-left"></i> Retour</a>
                    <a href="poser_question.php"
                        class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 d-block d-lg-none w-75"><i
                            class="bi bi-bookmark-plus-fill"></i> Poser une question</a>
                    <h2 class="fw-lighter text-primary mt-3">Questions</h2>
                    <h3 class="mt-3"><?php echo $row['titre']; ?></h3>
                    <div class="jumbotron bg w-75 ">
                        <p class="lead mt-3 p-2"><?php echo $row['contenu']; ?> </p>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between px-2">
                            <p>Poser par : <span
                                    class="text-danger"><?php echo $row['First_name']. ' ' . $row['Last_name'] ; ?></span>
                            </p>
                            <p>Poser le : <span class="text-primary"><?php echo $row['date_creation']; ?></span></p>
                        </div>
                    </div>
                    <h2 class="fw-lighter text-primary mt-3">Réponses</h2>
                    <?php

$sql = "SELECT * FROM reponses INNER JOIN users ON reponses.user_id  = users.id_user WHERE reponses.question_id = $question_id ";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    $message="Il n'y a pas encore de réponse.";
    
   } else{
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
                    <div class="jumbotron bg w-75 mt-2">
                        <div class="d-flex justify-content-between pt-2 px-3 ">
                            <?php
                // Check if the response belongs to the current user
                if ($role == 'scrum_master') {
                    ?>

                            <a href="#" class="text-success"><i class="bi bi-archive-fill"></i></a>
                            <?php
                }
                ?>

                            <p> <span class="text-primary"><?php echo $row['date_creation']; ?></span></p>
                        </div>

                        <p class="lead  px-2 " style="overflow-wrap: break-word; word-wrap: break-word;">
                            <?php echo $row['contenu']; ?> </p>

                        <hr class="my-4">
                        <div class="d-flex justify-content-between px-2">
                            <p>Répondre par : <span
                                    class="text-danger"><?php echo $row['First_name']. ' ' . $row['Last_name'] ; ?></span>
                            </p>
                            <?php
                // Check if the response belongs to the current user
                if ($row['user_id'] == $membre) {
                    ?>
                            <div class="d-flex justify-content-center me-5">
                                <a href="supprimer_reponse.php?id=<?php echo $row['id_reponse']; ?>"
                                    class="text-danger ms-4 text-center">
                                    <i class=" bi-trash3-fill"></i>
                                </a>
                                <a href="modifier_reponse.php?id=<?php echo $row['id_reponse']; ?>"
                                    class="text-primary ms-4 text-center">
                                    <i class=" bi bi-pencil"></i>
                                </a>
                            </div>
                            <?php
                }
                ?>
                            <div class="d-flex justify-content-center gap-3">
                                <p onclick="myFunction(this)" class="like"><i class="fa fa-thumbs-up"></i> 1</p>
                                <p onclick="yourFunction(this)" class="dislike"><i class="fa fa-thumbs-down"></i> 1
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
    }
} 
?>
                    <p class="text-center fs-5 fw-bolder text-danger"><?php echo $message;?></p>

                    <form method="post" action="" class="w-75 ">
                        <h2 class="fw-lighter text-primary mt-3">Répondre</h2>
                        <div class="form-floating mt-3  ">
                            <textarea name="text" class="form-control bg h-80" placeholder="Leave a comment here"
                                id="floatingTextarea"></textarea>
                            <label for=" floatingTextarea">Votre reponse</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit"
                                class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-2">
                                <i class="bi bi-file-post"></i> Publier votre réponse</button>
                        </div>
                    </form>




                    <script>
                    function myFunction(x) {
                        x.classList.toggle("text-success");
                    }

                    function yourFunction(x) {
                        x.classList.toggle("text-danger");
                    }
                    </script>

                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
                    </script>


</body>

</html>