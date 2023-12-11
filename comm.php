<?php

session_start();
include "FrontEnd & Backend/connexion.php";
file_put_contents('debug.log', print_r($_SERVER['REQUEST_METHOD'], true), FILE_APPEND);
file_put_contents('debug.log', 'Vote script reached', FILE_APPEND);

// Check if the user is logged in
$user= $_SESSION['username'];

$username = $_SESSION['username'];

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if required data is present
    if (!isset($data['question_id']) || !isset($data['type'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    $question_id = $data['question_id'];
    $type = $data['type'];

    // Check if the user has already voted for this question
    $checkVoteQuery = "SELECT * FROM question_votes WHERE username = $username AND question_id = $question_id";
    $checkVoteResult = mysqli_query($conn, $checkVoteQuery);

    if ($checkVoteResult) {
        if (mysqli_num_rows($checkVoteResult) > 0) {
            // User has already voted, delete the existing vote
            $deleteVoteQuery = "DELETE FROM question_votes WHERE username = $username AND question_id = $question_id";
            mysqli_query($conn, $deleteVoteQuery);
            echo json_encode(['success' => true, 'message' => 'Vote removed']);
        } else {
            // User has not voted, insert a new vote
            $insertVoteQuery = "INSERT INTO question_votes (username, question_id, type) VALUES ($username, $question_id, '$type')";
            mysqli_query($conn, $insertVoteQuery);
            echo json_encode(['success' => true, 'message' => 'Vote added']);
        }

        // Update total votes for the question
        updateTotalVotes($conn, $question_id);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing SQL query: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Function to update total votes for a question
function updateTotalVotes($conn, $question_id) {
    $getTotalVotesQuery = "SELECT COUNT(*) AS total_likes FROM question_votes WHERE question_id = $question_id AND type = 'like'";
    $totalLikesResult = mysqli_query($conn, $getTotalVotesQuery);

    $getTotalVotesQuery = "SELECT COUNT(*) AS total_dislikes FROM question_votes WHERE question_id = $question_id AND type = 'dislike'";
    $totalDislikesResult = mysqli_query($conn, $getTotalVotesQuery);

    $totalLikes = mysqli_fetch_assoc($totalLikesResult)['total_likes'];
    $totalDislikes = mysqli_fetch_assoc($totalDislikesResult)['total_dislikes'];

    $updateTotalVotesQuery = "UPDATE questions SET total_likes = $totalLikes, total_dislikes = $totalDislikes WHERE id_question = $question_id";
    mysqli_query($conn, $updateTotalVotesQuery);
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
    <title>Questions and Voting</title>
</head>

<body>

    <div class="container mt-5">
        <?php
        // Fetch questions from the database
        $sql = "SELECT * FROM questions";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $question_id = $row['id_question'];
        ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['titre']; ?></h5>
                        <p class="card-text"><?php echo $row['contenu']; ?></p>

                        <!-- Voting buttons -->
                        <div class="d-flex justify-content-between">
                            <form class="vote-form" onsubmit="vote('like', <?php echo $question_id; ?>); return false;">
                                <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                <button type="submit" class="btn btn-success"><i class="bi bi-arrow-up"></i> Like</button>
                            </form>

                            <form class="vote-form" onsubmit="vote('dislike', <?php echo $question_id; ?>); return false;">
                                <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                                <button type="submit" class="btn btn-danger"><i class="bi bi-arrow-down"></i> Dislike</button>
                            </form>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <script>
        fetch('your_php_script.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',  // Include this line to send cookies
            body: JSON.stringify({
                type: 'like',  // or 'dislike'
                question_id: 123,  // replace with the actual question_id
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Handle the response or update the UI as needed
        })
        .catch((error) => {
            console.error('Error:', error);
        });
        console.log(JSON.stringify({ type: 'like', question_id: 123 }));


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
