<?php
session_start();
if($_SESSION['autoriser'] != "oui"){
  header("Location: index.php");
  exit();
}
include "connexion.php";
include "server.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['input'])) {
    $inputValues = $_POST['input'];
  

    $sql_query = "SELECT * FROM questions 
                  INNER JOIN users ON questions.user_id = users.id_user
                  LEFT JOIN question_tags ON questions.id_question = question_tags.question_id
                  LEFT JOIN tags ON question_tags.tag_id = tags.id_tag
                  WHERE questions.titre LIKE '%$inputValues%'
                    OR questions.contenu LIKE '%$inputValues%'
                    OR tags.nom_tag LIKE '%$inputValues%'
                  GROUP BY questions.id_question
                  ORDER BY questions.date_creation DESC";
                  

    $result = mysqli_query($conn, $sql_query);

    $output = "";
    $row_count = mysqli_num_rows($result);

    if ($row_count > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '   <div  class="card w-75 mt-4 shadow p-3 mb-5 bg-body rounded">
                <div class="card-header d-flex justify-content-between text-danger">
                    <p>' . $row['First_name'] . ' ' . $row['Last_name'] . '</p>
                    <p>' .  date('Y-m-d', strtotime($row['date_creation'])) . '</p>
                </div>
                <div class="card-body d-flex flex-column">
                    <a href="Question.php?id=' . $row['id_question'] . '" class="text-decoration-none text-dark">
                        <h3>' . $row['titre'] . '</h3>
                    </a>
                    <div class="d-flex gap-2 mt-2">';
            
            // Afficher les balises des tags
            $question_id = $row['id_question'];
            $sqle = "SELECT * FROM questions 
                    JOIN question_tags ON questions.id_question = question_tags.question_id
                    JOIN tags  ON question_tags.tag_id = tags.id_tag WHERE questions.id_question = $question_id";

            $resulte = mysqli_query($conn, $sqle);
            while ($tag_row = mysqli_fetch_assoc($resulte)) {
                $output .= '<p class="btn btn-outline-primary">' . $tag_row['nom_tag'] . '</p>';
            }

 
            $output .= '</div>
                <div class="card-footer d-flex justify-content-end gap-3">
                <a class="text-primary text-decoration-none" href="Question.php?id=' . $row['id_question'] . '" class="text-decoration-none text-dark">
                <i class="bi bi-chat"></i> Répondre
                </a>
                    <!-- Like and Dislike buttons -->
                    <i ' . ((userLiked($question_id)) ? 'class="fa fa-thumbs-up like-btn text-success"' : 'class="fa fa-thumbs-o-up like-btn"') . '
                        data-id="' . $question_id . '"></i>
                    <span class="likes">' . getLikes($question_id) . '</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <i ' . ((userDisliked($question_id)) ? 'class="fa fa-thumbs-down dislike-btn text-danger"' : 'class="fa fa-thumbs-o-down dislike-btn"') . '
                        data-id="' . $question_id . '"></i>
                    <span class="dislikes">' . getDislikes($question_id) . '</span>
                </div>
            </div>
        </div>';
}
        }

    } else {
        $output .= 'Aucune donnée correspondante.';
    }

    echo $output;

?>