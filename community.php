<?php
require_once('config/db.php');

$result_id_questions = mysqli_query($con, "SELECT  id_question FROM questions");

$result_questions = mysqli_query($con, "SELECT  contenu FROM questions");

$result_title = mysqli_query($con, "SELECT titre FROM questions");

$result_tags = mysqli_query($con, "SELECT nom_tag FROM tags");

$result_date = mysqli_query($con, "SELECT date_creation FROM questions");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet integrity=" sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            <div class="d-flex justify-content-center mt-5 w-25 p-3 d-none d-lg-block ">
                <div class="form-floating w-100">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                        <option selected>All</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <label for="floatingSelect">Filtrer question par projet</label>
                </div>
            </div>
            <div class="vr"></div>
            <div class="d-flex flex-column col w-auto w-md-75">

                <div class="d-flex  flex-column align-items-center ">
                    <h1 class="fw-lighter text-primary mt-3">Questions</h1>
                    <div class="d-flex justify-content-center mt-1 w-25 p-3 d-block d-lg-none w-75 ">
                        <div class="form-floating w-100">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>All</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <label for="floatingSelect">Filtrer question par projet</label>
                        </div>
                    </div>
                    <a href="add Q/Add Questions.php" class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-75"><i class="bi bi-bookmark-plus-fill"></i> Poser une question </a>
                    <?php
                    while (
                        ($row_title = mysqli_fetch_array($result_title)) &&
                        ($row_tags = mysqli_fetch_array($result_tags)) &&
                        ($row_date = mysqli_fetch_array($result_date)) &&
                        ($row_id_questions = mysqli_fetch_array($result_id_questions)) &&
                        ($row_questions = mysqli_fetch_array($result_questions))

                    ) {
                    ?>
                        <div class="card w-75 mt-4">
                            <div class="card-header d-flex justify-content-between">
                                <p>Ayoub Snini</p>
                                <p><?php echo $row_date['date_creation']; ?></p>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <a href="" class="text-decoration-none text-dark">
                                    <h3><?php echo $row_title['titre']; ?></h3>
                                </a>
                                <div class="d-flex gap-2 mt-2">
                                    <p class="btn btn-outline-primary">HTML</p>
                                    <p class="btn btn-outline-primary">CSS</p>
                                </div>
                                    <div class="card-footer d-flex justify-content-end gap-3">
                                        <form method="POST" action="Question.php">
                                            <input type="" name="id_question" value="<?php echo $row_id_questions['id_question']; ?>">
                                            <button type="submit"></button>
                                        </form>

                                        <p onclick="myFunction(this)" class="like"><i class="fa fa-thumbs-up"></i> 1</p>
                                        <p onclick="yourFunction(this)" class="dislike"><i class="fa fa-thumbs-down"></i> 1</p>
                                    </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="d-flex justify-content-center align-items-center mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
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