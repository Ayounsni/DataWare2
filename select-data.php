<?php
include "FrontEnd & Backend/connexion.php";
$catname = $_POST['cat_name'];

if($catname!='All')
{
	$cond = "'$catname'";
}
else
{
	$cond = 0;
}

$fetch_query = mysqli_query($conn, "SELECT * FROM questions INNER JOIN projets ON questions.projet_id = projets.id_projets where nom_projet= $cond");
$row = mysqli_num_rows($fetch_query);
if ($row > 0) {
    while ($res = mysqli_fetch_array($fetch_query)) {
        ?>
        <div class="card w-75 mt-4">
            <div class="card-header d-flex justify-content-between text-danger">
                <p><?php echo $res['titre']; ?></p>
                <p><?php echo $res['date_creation']; ?></p>
            </div>
            <div class="card-body d-flex flex-column">
                <a href="#" class="text-decoration-none text-dark">
                    <h3><?php echo $res['titre']; ?></h3>
                </a>
                <div class="d-flex gap-2 mt-2">
                    <!-- You can display additional information here if needed -->
                </div>
            </div>
        </div>
    <?php
    }
} else {
    echo "Aucun résultat trouvé.";
}
?>