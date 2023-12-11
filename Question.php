<?php
include('votes_reponse.php');
$question_id = $_GET['id'];
$user= $_SESSION['username'];
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
                        <li class="nav-item">
                            <a class="nav-link text-center" href="DashboardScrum.php">Equipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Gestionequi.php">Membres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-center" href="Assignation.php">Assignation</a>
                        </li>
                        <a href="deconnexion.php"
                            class="btn bg-danger p-2 rounded-3 text-light text-decoration-none "><i
                                class="bi bi-box-arrow-left"></i> Deconnexion</a>
                    </ul>

                </div>
            </div>
        </nav>
    </header>


        <div class="d-flex flex-lg-row justify-content-between flex-sm-column flex-md-column">
            <div class="d-flex justify-content-center mt-3 w-25 p-3 d-none d-lg-block ">
                <a href="community.php"
                    class="col-md-auto col-sm-12 bg-danger p-2 rounded-3 text-light text-decoration-none btn mt-1 w-100"><i
                        class="bi bi-arrow-return-left"></i> Retour</a>
                <a href="#"
                    class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-100"><i
                        class="bi bi-bookmark-plus-fill"></i> Poser une question</a>
            </div>
            <div class="vr"></div>
            <div class="d-flex flex-column col w-100 p-4">

                <div class="d-flex  flex-column align-items-start  ">
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
                <?php foreach ($reponses as $reponse): ?>
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
                        <p class="lead mt-3 p-2"><?php echo $row['contenu']; ?> </p>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between px-2">
                            <p>Répondre par : <span
                                    class="text-danger"><?php echo $row['First_name']. ' ' . $row['Last_name'] ; ?></span>
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <!-- Like and Dislike buttons -->
                                <i <?php echo (userLiked($reponse['id_reponse'])) ? 'class="fa fa-thumbs-up like-btn"' : 'class="fa fa-thumbs-o-up like-btn"'; ?>
                                    data-id="<?php echo $reponse['id_reponse']; ?>"></i>
                                <span class="likes"><?php echo getLikes($reponse['id_reponse']); ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <i <?php echo (userDisliked($reponse['id_reponse'])) ? 'class="fa fa-thumbs-down dislike-btn"' : 'class="fa fa-thumbs-o-down dislike-btn"'; ?>
                                    data-id="<?php echo $reponse['id_reponse']; ?>"></i>
                                <span class="dislikes"><?php echo getDislikes($reponse['id_reponse']); ?></span>
                            </div>
                            <p>Répondre le : <span class="text-primary"><?php echo $row['date_creation']; ?></span></p>
                        </div>
                    </div>
                    <?php
                        }
                    } 
                    ?>
                    <p class="text-center fs-5 fw-bolder text-danger"><?php echo $message;?></p>
                    <?php endforeach; ?>


                    <form method="post" action="" class="w-75 ">
                        <h2 class="fw-lighter text-primary mt-3">Répondre</h2>
                        <div class="form-floating mt-3  ">
                            <textarea name="text" class="form-control bg h-80" placeholder="Leave a comment here"
                                id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Votre reponse</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit"
                                class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-2">
                                <i class="bi bi-file-post"></i> Publier votre réponse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    <script>
        $(document).ready(function () {
    // if the user clicks on the like button ...
    $('.like-btn').on('click', function () {
        var reponse_id = $(this).data('id');
        $clicked_btn = $(this);

        // Check if the button is currently in the like state
        var isLiked = $clicked_btn.hasClass('fa-thumbs-up');

        $.ajax({
            url: 'server.php',
            type: 'post',
            data: {
                'action': isLiked ? 'unlike' : 'like',
                'reponse_id': reponse_id
            },
            success: function (data) {
                res = JSON.parse(data);
                // Toggle classes based on the action performed
                $clicked_btn.toggleClass('fa-thumbs-o-up fa-thumbs-up');
                $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                // Display the number of likes and dislikes
                $clicked_btn.siblings('span.likes').text(res.likes);
                $clicked_btn.siblings('span.dislikes').text(res.dislikes);
            }
        });
    });

    // if the user clicks on the dislike button ...
    $('.dislike-btn').on('click', function () {
        var reponse_id = $(this).data('id');
        $clicked_btn = $(this);

        // Check if the button is currently in the dislike state
        var isDisliked = $clicked_btn.hasClass('fa-thumbs-down');

        $.ajax({
            url: 'server.php',
            type: 'post',
            data: {
                'action': isDisliked ? 'undislike' : 'dislike',
                'reponse_id': reponse_id
            },
            success: function (data) {
                res = JSON.parse(data);
                // Toggle classes based on the action performed
                $clicked_btn.toggleClass('fa-thumbs-o-down fa-thumbs-down');
                $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                // Display the number of likes and dislikes
                $clicked_btn.siblings('span.likes').text(res.likes);
                $clicked_btn.siblings('span.dislikes').text(res.dislikes);
            }
        });
    });
});
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>