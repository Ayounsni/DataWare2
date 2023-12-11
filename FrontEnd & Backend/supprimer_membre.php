<?php
include "connexion.php";

$membre_id = $_GET['membre_id'];
$req=mysqli_query($conn, "UPDATE users SET id_equip = NULL WHERE id_user = $membre_id;");
header("Location: Gestionequi.php");


?>
