<?php
include('votes.php');

// Assuming $conn is your database connection

// Retrieve the question ID from the URL
if (isset($_GET['question_id'])) {
    $question_id = $_GET['question_id'];

    // Fetch the question details
    $question_sql = "SELECT * FROM questions INNER JOIN users ON questions.user_id = users.id_user WHERE id_question = $question_id";
    $question_result = mysqli_query($conn, $question_sql);
    $question = mysqli_fetch_assoc($question_result);

    // Fetch answers for the specific question
    $answers_sql = "SELECT * FROM reponses INNER JOIN users ON reponses.user_id = users.id_user WHERE question_id = $question_id ORDER BY reponses.date_creation DESC";
    $answers_result = mysqli_query($conn, $answers_sql);
    $answers = mysqli_fetch_all($answers_result, MYSQLI_ASSOC);
} else {
    // Handle the case when no question ID is provided
    echo "No question ID provided.";
    exit();
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
    <link rel="stylesheet" href="main.css">
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
            <div class="d-flex flex-column align-items-start">
                <h2 class="fw-lighter text-primary mt-3">Question</h2>
                <h3 class="mt-3"><?php echo $question['titre']; ?></h3>
                <div class="jumbotron bg w-75">
                    <p class="lead mt-3 p-2"><?php echo $question['contenu']; ?> </p>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between px-2">
                        <p>Posé par: <span class="text-danger"><?php echo $question['First_name'] . ' ' . $question['Last_name']; ?></span></p>
                        <p>Posé le: <span class="text-primary"><?php echo $question['date_creation']; ?></span></p>
                    </div>
                </div>

                <h2 class="fw-lighter text-primary mt-3">Réponses</h2>
                <?php if (count($answers) > 0): ?>
                    <?php foreach ($answers as $answer): ?>
                        <div class="jumbotron bg <?php echo $answer['is_solution'] ? 'bg-warning' : ''; ?> w-75 mt-2">
                            <p class="lead mt-3 p-2"><?php echo $answer['contenu']; ?> </p>
                            <hr class="my-4">
                            <div class="d-flex justify-content-between px-2">
                                <p>Répondu par: <span class="text-danger"><?php echo $answer['First_name'] . ' ' . $answer['Last_name']; ?></span></p>
                                <!-- Like and Dislike buttons -->
                                <i <?php if (userLiked($answer['id_reponse'])): ?>
                                                class="fa fa-thumbs-up like-btn"
                                            <?php else: ?>
                                                class="fa fa-thumbs-o-up like-btn"
                                            <?php endif ?>
                                            data-id="<?php echo $answer['id_reponse'] ?>"></i>
                                            <span class="likes"><?php echo getLikes($answer['id_reponse']); ?></span>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <i <?php if (userDisliked($answer['id_reponse'])): ?>
                                                class="fa fa-thumbs-down dislike-btn"
                                            <?php else: ?>
                                                class="fa fa-thumbs-o-down dislike-btn"
                                            <?php endif ?>
                                            data-id="<?php echo $answer['id_reponse'] ?>"></i>
                                            <span class="dislikes"><?php echo getDislikes($answer['id_reponse']); ?></span>
                                            <?php
                                            // Check if the logged-in user is the one who asked the question
                                            if ($question['user_id'] === $_SESSION['id'] && !$answer['is_solution']):
                                            ?>
                                                <!-- Display the "Mark as Solution" button only if the logged-in user is the one who asked the question and the answer is not already marked as a solution -->
                                                <button class="btn btn-success mark-solution-btn" data-id="<?php echo $answer['id_reponse']; ?>">Mark as Solution</button>
                                            <?php endif; ?>
                                <p>Répondu le: <span class="text-primary"><?php echo $answer['date_creation']; ?></span></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center fs-5 fw-bolder text-danger">Il n'y a pas encore de réponse.</p>
                <?php endif; ?>
                <form method="post" action="" class="w-75">
        <h2 class="fw-lighter text-primary mt-3">Répondre</h2>
        <div class="form-floating mt-3">
            <textarea name="text" class="form-control bg h-80" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
            <label for="floatingTextarea">Votre reponse</label>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" name="submit" class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-2">
                <i class="bi bi-file-post"></i> Publier votre réponse
            </button>
        </div>
    </form>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function () {

        // if the user clicks on the like button ...
        $('.like-btn').on('click', function () {
            var reponse_id = $(this).data('id');
            $clicked_btn = $(this);

            if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
                action = 'like';
            } else if ($clicked_btn.hasClass('fa-thumbs-up')) {
                action = 'unlike';
            }

            $.ajax({
                url: 'Question.php', // Replace with the correct PHP script handling votes
                type: 'post',
                data: {
                    'action': action,
                    'reponse_id': reponse_id
                },
                success: function (data) {
                    res = JSON.parse(data);
                    if (action == "like") {
                        $clicked_btn.removeClass('fa-thumbs-o-up');
                        $clicked_btn.addClass('fa-thumbs-up');
                    } else if (action == "unlike") {
                        $clicked_btn.removeClass('fa-thumbs-up');
                        $clicked_btn.addClass('fa-thumbs-o-up');
                    }

                    // display the number of likes and dislikes
                    $clicked_btn.siblings('span.likes').text(res.likes);
                    $clicked_btn.siblings('span.dislikes').text(res.dislikes);

                    // change button styling of the other button if user is reacting the second time to post
                    $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
                }
            });
        });

        // if the user clicks on the dislike button ...
        $('.dislike-btn').on('click', function () {
            var reponse_id = $(this).data('id');
            $clicked_btn = $(this);

            if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
                action = 'dislike';
            } else if ($clicked_btn.hasClass('fa-thumbs-down')) {
                action = 'undislike';
            }

            $.ajax({
                url: 'Question.php', // Replace with the correct PHP script handling votes
                type: 'post',
                data: {
                    'action': action,
                    'reponse_id': reponse_id
                },
                success: function (data) {
                    res = JSON.parse(data);
                    if (action == "dislike") {
                        $clicked_btn.removeClass('fa-thumbs-o-down');
                        $clicked_btn.addClass('fa-thumbs-down');
                    } else if (action == "undislike") {
                        $clicked_btn.removeClass('fa-thumbs-down');
                        $clicked_btn.addClass('fa-thumbs-o-down');
                    }

                    // display the number of likes and dislikes
                    $clicked_btn.siblings('span.likes').text(res.likes);
                    $clicked_btn.siblings('span.dislikes').text(res.dislikes);

                    // change button styling of the other button if user is reacting the second time to post
                    $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
                }
            });
        });

        // if the user clicks on the mark as solution button ...
    $('.mark-solution-btn').on('click', function () {
        var reponse_id = $(this).data('id');

        $.ajax({
            url: 'MarkSolution.php',
            type: 'post',
            data: {
                'reponse_id': reponse_id
            },
            success: function (data) {
                res = JSON.parse(data);
                if (res.success) {
                    alert('Answer marked as solution!');
                    // Refresh the page or update the UI dynamically
                    location.reload();
                } else {
                    alert('Error marking answer as solution');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error marking solution:', textStatus, errorThrown);
            }
        });
    });
    
});


    </script>
</body>
</html>
