<?php
session_start();
include "FrontEnd & Backend/connexion.php";
$message="";


$user= $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="FrontEnd & Backend/style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Document</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-scroll  shadow-0 border-bottom border-dark">
            <div class="container">

                <img src="Image/log.png" alt="logo" class="rounded-4" style="width: 80px; height: 60px;">
                <div class="input-group w-50 ms-md-4 ">
                    <input type="search" id="myInput" class="form-control rounded" placeholder="Search"
                        aria-label="Search" aria-describedby="search-addon" />
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
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Equipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Gestionequi.php">Membres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Assignation.php">Assignation</a>
                        </li>
                        <a href="FrontEnd & Backend/deconnexion.php"
                            class="btn bg-danger p-2 rounded-3 text-light text-decoration-none "><i
                                class="bi bi-box-arrow-left"></i> Deconnexion</a>
                    </ul>

                </div>
            </div>
        </nav>



        <div class="d-flex flex-lg-row justify-content-between flex-sm-column flex-md-column">
            <div class="d-flex justify-content-center mt-5 w-25 p-3 d-none d-lg-block ">
                <div class="form-floating w-100">
                <select class="form-control" onchange="selectdata(this.options[this.selectedIndex].value)">
                <option value="All">All</option>
                <?php
                // Include your database connection
                include "FrontEnd & Backend/connexion.php";;

                // Query to get distinct categories
                $query = "SELECT DISTINCT nom_projet FROM projets";
                $result = mysqli_query($conn, $query);

                // Display options
                while ($row = mysqli_fetch_assoc($result)) {
                    $category = $row['nom_projet'];
                    echo "<option value='$category'>$category</option>";
                }
                ?>
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
                    <a href="poser_question.php"
                        class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-75"><i
                            class="bi bi-bookmark-plus-fill"></i> Poser une question </a>
                    <a href="Mquestion.php"
                        class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-75">Mes
                        questions </a>


                    <div id="result" class="d-flex flex-column align-items-center w-100"></div>
                             
    <div id="result"  class="d-flex flex-column align-items-center w-100"></div> 



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
<script type="text/javascript">
    $(document).ready(function () {
        showdata();
    });

    function showdata(page) {
        $.ajax({
            url: 'show-data.php',
            method: 'post',
            data: {page_no: page},
            success: function (result) {
                $("#result").html(result);
            }
        });
    }

    $(document).on("click", ".pagination a", function () {
        var page = $(this).attr('id');
        showdata(page);
    });

    function selectdata(cat) {
        $.ajax({
            url: 'show-data.php',
            method: 'post',
            data: 'cat_name=' + cat,
            success: function (result) {
                $("#result").html(result);
            }
        });
    }
    $(document).ready(function () {
                $('#myInput').on('keyup', function () {
                    let inputValue = this.value;
                    let outputDiv = "#result";
                    console.log('inputValue ', inputValue);

                    if (inputValue != "") {
                        $.ajax({
                            url: "Rechercher_Questions.php",
                            data: {
                                'input': inputValue
                            },
                            dataType: "html",
                            type: "POST",
                            success: function (response) {
                                $(outputDiv).empty().html(response);
                            }
                        });
                    } else {
                        let msg = "Veuillez taper votre question ou le tag.";
                        $('.errMsg').text(msg);
                        $(outputDiv).empty();
                    }
                });
            });
</script>

