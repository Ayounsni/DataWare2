<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['input'])) {
    $inputValues = $_POST['input'];

    $sql_query = "SELECT DISTINCT questions.*, GROUP_CONCAT(tags.nom_tag) AS tag_list
                  FROM questions
                  LEFT JOIN question_tags ON questions.id_question = question_tags.question_id
                  LEFT JOIN tags ON question_tags.tag_id = tags.id_tag
                  WHERE questions.titre LIKE '%$inputValues%'
                    OR tags.nom_tag LIKE '%$inputValues%'
                    OR questions.contenu LIKE '%$inputValues%'
                  GROUP BY questions.id_question";

    $result = mysqli_query($conn, $sql_query);

    $output = "";
    if (mysqli_num_rows($result) > 0) {
        $output .= '<table class="myTable">';
        $output .= '<tr class="header">';
        $output .= '<th style="width:30%;">ID</th>';
        $output .= '<th style="width:25%;">Titre</th>';
        $output .= '<th style="width:25%;">Contenu</th>';
        $output .= '<th style="width:20%;">Tags</th>';
        $output .= '</tr>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '<tr>';
            $output .= '<td>' . $row['id_question'] . '</td>';
            $output .= '<td>' . $row['titre'] . '</td>';
            $output .= '<td>' . $row['contenu'] . '</td>';
            $output .= '<td>' . $row['tag_list'] . '</td>';
            $output .= '</tr>';
        }
        $output .= '</table>';
    } else {
        $output .= 'Aucune donnée correspondante.';
    }

    echo $output;
}
?>

