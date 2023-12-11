<!-- index.php -->

<?php
include('votes_reponse.php');

$sql = "SELECT * FROM questions INNER JOIN users ON questions.user_id = users.id_user ORDER BY questions.date_creation DESC";
$result = mysqli_query($conn, $sql);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Like and Dislike system</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="posts-wrapper">
        <?php foreach ($questions as $question): ?>
            <div class="post">
                <a href="Question.php?id=<?=$question['id_question']?>" class="text-decoration-none text-dark">
                    <h3><?php echo $question['titre']; ?></h3>
                </a>
                <div class="post-info">
                   
                    <!-- Voting for responses -->
                    <?php
                    $responseSql = "SELECT * FROM responses WHERE question_id = {$question['id_question']}";
                    $responseResult = mysqli_query($conn, $responseSql);
                    $responses = mysqli_fetch_all($responseResult, MYSQLI_ASSOC);
                    foreach ($responses as $response):
                    ?>
                        <div class="response-votes">
                            <button class="like-btn" data-id="<?php echo $response['id_response'] ?>" data-type="response" <?php if (userLiked($response['id_response'], 'response')): ?>style="color: blue;"<?php endif; ?>>
                                Like
                            </button>
                            <span class="likes"><?php echo getLikes($response['id_response'], 'response'); ?></span>

                            <button class="dislike-btn" data-id="<?php echo $response['id_response'] ?>" data-type="response" <?php if (userDisliked($response['id_response'], 'response')): ?>style="color: red;"<?php endif; ?>>
                                Dislike
                            </button>
                            <span class="dislikes"><?php echo getDislikes($response['id_response'], 'response'); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <script>
        $(document).ready(function () {

            // if the user clicks on the like or dislike button ...
            $('.like-btn, .dislike-btn').on('click', function () {
                var item_id = $(this).data('id');
                var type = $(this).data('type');
                $clicked_btn = $(this);

                var action = $clicked_btn.hasClass('like-btn') ? 'like' : 'dislike';

                $.ajax({
                    url: 'server.php', // Update the URL to your server.php file
                    type: 'post',
                    data: {
                        'action': action,
                        'item_id': item_id,
                        'type': type
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        // Update the color of the button based on the user's vote
                        if (action == "like") {
                            $clicked_btn.css('color', 'blue');
                            $clicked_btn.siblings('.dislike-btn').css('color', 'black');
                        } else if (action == "dislike") {
                            $clicked_btn.css('color', 'red');
                            $clicked_btn.siblings('.like-btn').css('color', 'black');
                        }

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
