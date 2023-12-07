<?php
require_once('config/db.php');

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'id_question' parameter exists in the POST data
    if (isset($_POST['id_question'])) {
        // Retrieve the value of 'id_question'
        $id_question = $_POST['id_question'];

        $result_id_questions = mysqli_query($con, "SELECT  id_question FROM questions");

        $result_title = mysqli_query($con, "SELECT titre FROM questions where id_question = $id_question  ");

        $result_tags = mysqli_query($con, "SELECT nom_tag FROM tags");

        $result_date = mysqli_query($con, "SELECT date_creation FROM questions  where id_question = $id_question");

        $result_contenu = mysqli_query($con, "SELECT contenu FROM questions  where id_question = $id_question");

    } else {
        // Handle the case when 'id_question' is not set in the POST data
        echo "Error: id_question is not set in the POST data.";
    }
} else {
    // Handle the case when the form was not submitted using POST method
    echo "Error: Form was not submitted using POST method.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="FrontEnd & Backend/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-scroll  shadow-0 border-bottom border-dark">
            <div class="container">

                <img src="Image/log.png" alt="logo" class="rounded-4" style="width: 80px; height: 60px;">
                <div class="input-group w-50 ms-md-4 ">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button type="button" class="btn btn-outline-primary" data-mdb-ripple-init><i class="bi bi-search"></i></button>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class=" text-light bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto d-flex gap-5">
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Equipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Gestionequi.php">Membres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Assignation.php">Assignation</a>
                        </li>
                        <a href="deconnexion.php" class="btn bg-danger p-2 rounded-3 text-light text-decoration-none "><i class="bi bi-box-arrow-left"></i> Deconnexion</a>
                    </ul>

                </div>
            </div>
        </nav>
        <div class="d-flex flex-lg-row justify-content-between flex-sm-column flex-md-column">
            <div class="d-flex justify-content-center mt-3 w-25 p-3 d-none d-lg-block ">
                <a href="community.php" class="col-md-auto col-sm-12 bg-danger p-2 rounded-3 text-light text-decoration-none btn mt-1 w-100"><i class="bi bi-arrow-return-left"></i> Retour</a>
                <a href="#" class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-100"><i class="bi bi-bookmark-plus-fill"></i> Poser une question</a>
            </div>
            <div class="vr"></div>
            <div class="d-flex flex-column col w-100 p-4">

                <div class="d-flex  flex-column align-items-start  ">
                    <h2 class="fw-lighter text-primary mt-3">Questions</h2>
                    <?php
                    while (
                        ($row_title = mysqli_fetch_array($result_title)) &&
                        ($row_tags = mysqli_fetch_array($result_tags)) &&
                        ($row_date = mysqli_fetch_array($result_date)) &&
                        ($row_contenu = mysqli_fetch_array($result_contenu)) &&
                        ($row_id_questions = mysqli_fetch_array($result_id_questions)) 
                        ) {
                    ?>
                        <h3 class="mt-3"><?php echo $row_title['titre']; ?> </h3>
                        <div class="jumbotron bg w-75 ">
                            <p class="lead mt-3 p-2">
                            <?php echo $row_contenu['contenu']; ?>
                            </p>
                            <hr class="my-4">
                            <div class="d-flex justify-content-between px-2">
                                <p>Poser par : <span class="text-danger">Ayoub Snini</span></p>
                                <p>Poser le : <span class="text-primary"><?php echo $row_date['date_creation']; ?></span></p>
                                <form method="post" action="modify Q/modifyQuestionform.php">
                                    <input type="hidden" name="contenu" value="<?php echo $row_contenu['contenu']; ?>">
                                    <button type="submit" class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                </form>
                                
                            <form method="post" action="delete Q/deleteQuestionform.php">
                            <input type="" name="id_question" value="<?php echo $row_id_questions['id_question']; ?>">
                                <button type="submit" class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none j-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <h2 class="fw-lighter text-primary mt-3">Réponses</h2>
                <div class="jumbotron bg w-75 mt-2">
                    <p class="lead mt-3 p-2">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.
                        This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured
                        This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured
                    </p>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between px-2">
                        <p>Répondre par : <span class="text-danger">zouhair ghoumri</span></p>
                        <div class="d-flex justify-content-center gap-3">
                            <p onclick="myFunction(this)" class="like"><i class="fa fa-thumbs-up"></i> 1</p>
                            <p onclick="yourFunction(this)" class="dislike"><i class="fa fa-thumbs-down"></i> 1</p>
                        </div>
                        <p>Répondre le : <span class="text-primary">2023-02-27</span></p>
                    </div>
                </div>
                <form action="" class="w-75 ">
                    <h2 class="fw-lighter text-primary mt-3">Répondre</h2>
                    <div class="form-floating mt-3  ">
                        <textarea class="form-control bg h-80" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Votre reponse</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-2">
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

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>