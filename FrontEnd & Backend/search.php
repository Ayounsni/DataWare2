<?php
include "connexion.php";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["search"])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET["search"]);

    // Recherche par titre ou tag using prepared statements
    $sql = "
        SELECT DISTINCT questions.*
        FROM questions
        LEFT JOIN question_tags ON questions.id_question = question_tags.question_id
        LEFT JOIN tags ON question_tags.tag_id = tags.id_tag
        WHERE questions.titre LIKE ? OR tags.nom_tag LIKE ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Affichage des résultats pour la recherche instantanée
    if (mysqli_num_rows($result) > 0) {
        echo '<ul class="list-group">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="list-group-item">' . htmlspecialchars($row["titre"]) . '</li>';
        }
        echo '</ul>';
    } else {
        echo "Aucun résultat trouvé.";
    }
}
?>
