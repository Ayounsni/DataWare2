
<?php
include('server.php');

// Assuming $conn is your database connection
$sql = "SELECT * FROM questions INNER JOIN users ON questions.user_id = users.id_user ORDER BY questions.date_creation DESC";
$result = mysqli_query($conn, $sql);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                <a href="#" class="col-md-auto col-sm-12 bg-primary p-2 rounded-3 text-light text-decoration-none btn mt-4 w-75">
                    <i class="bi bi-bookmark-plus-fill"></i> Poser une question </a>

                <?php foreach ($questions as $question): ?>
                    <!-- Your question card here -->
                    <div class="card w-75 mt-4">
                        <!-- Card content -->
                        <div class="card-header d-flex justify-content-between text-danger">
                            <p><?php echo $question['First_name'] . ' ' . $question['Last_name']; ?></p>
                            <p><?php echo $question['date_creation']; ?></p>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <a href="Question.php?id=<?= $question['id_question'] ?>" class="text-decoration-none text-dark">
                                <h3><?php echo $question['titre']; ?></h3>
                            </a>
                            <div class="d-flex gap-2 mt-2">
                                <!-- Tags display -->
                                <?php
                                $sql_tags = "SELECT * FROM questions 
                                    JOIN question_tags ON questions.id_question = question_tags.question_id
                                    JOIN tags ON question_tags.tag_id = tags.id_tag WHERE questions.id_question = {$question['id_question']}";
                                $result_tags = mysqli_query($conn, $sql_tags);

                                while ($tag = mysqli_fetch_assoc($result_tags)) {
                                    echo '<p class="btn btn-outline-primary">' . $tag['nom_tag'] . '</p>';
                                }
                                ?>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-3">
                                <!-- Like and Dislike buttons -->
                                <i <?php echo (userLiked($question['id_question'])) ? 'class="fa fa-thumbs-up like-btn"' : 'class="fa fa-thumbs-o-up like-btn"'; ?>
                                    data-id="<?php echo $question['id_question']; ?>"></i>
                                <span class="likes"><?php echo getLikes($question['id_question']); ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <i <?php echo (userDisliked($question['id_question'])) ? 'class="fa fa-thumbs-down dislike-btn"' : 'class="fa fa-thumbs-o-down dislike-btn"'; ?>
                                    data-id="<?php echo $question['id_question']; ?>"></i>
                                <span class="dislikes"><?php echo getDislikes($question['id_question']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <!-- Pagination -->
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
    // if the user clicks on the like button ...
    $('.like-btn').on('click', function () {
        var question_id = $(this).data('id');
        $clicked_btn = $(this);

        // Check if the button is currently in the like state
        var isLiked = $clicked_btn.hasClass('fa-thumbs-up');

        $.ajax({
            url: 'server.php',
            type: 'post',
            data: {
                'action': isLiked ? 'unlike' : 'like',
                'question_id': question_id
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
        var question_id = $(this).data('id');
        $clicked_btn = $(this);

        // Check if the button is currently in the dislike state
        var isDisliked = $clicked_btn.hasClass('fa-thumbs-down');

        $.ajax({
            url: 'server.php',
            type: 'post',
            data: {
                'action': isDisliked ? 'undislike' : 'dislike',
                'question_id': question_id
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

</body>

</html>
