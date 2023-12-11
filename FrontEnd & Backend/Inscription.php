<?php
include "connexion.php";
// Définir les expressions régulières
$pattern_nom_prenom = '/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]{3,}$/u';
$pattern_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
$pattern_mot_de_passe =  '/^.{8,}$/' ;

// Initialiser les variables pour stocker les messages d'erreur
$erreur_nom = $erreur_prenom = $erreur_email = $erreur_mot_de_passe = "";
$nom = $prenom = $email = $mot_de_passe = "";



// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Récupérer les valeurs du formulaire
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mot_de_passe = $_POST["password"];

    // Valider le nom
    if (!preg_match($pattern_nom_prenom, $nom)) {
        $erreur_nom = "Veuillez entrer un nom valide (au moins 3 caractères)";
        
    }

    // Valider le prénom
    if (!preg_match($pattern_nom_prenom, $prenom)) {
        $erreur_prenom = "Veuillez entrer un prénom valide (au moins 3 caractères)";
    }

    // Valider l'email
    if (!preg_match($pattern_email, $email)) {
        $erreur_email = "Veuillez entrer une adresse e-mail valide.";
    }
    $user = "SELECT * FROM users where email = '$email'";
    $result = mysqli_query($conn, $user);
    if (mysqli_num_rows($result) > 0) {
      $erreur_email = "Email déjà utilisé";
  }

    // Valider le mot de passe
    if (!preg_match($pattern_mot_de_passe, $mot_de_passe)) {
        $erreur_mot_de_passe = "Veuillez entrer un mot de passe valide (au moins 8 caractères)";
    }
   
    
    

     // Si aucune erreur, rediriger vers la page souhaitée
     if (empty($erreur_nom) && empty($erreur_prenom) && empty($erreur_email) && empty($erreur_mot_de_passe)) {
      // Remplacez "page-de-destination.php" par le chemin de votre page de destination
      $requete = "INSERT INTO users (last_name, first_name, email, password) VALUES ('$nom', '$prenom', '$email', '$mot_de_passe')";
      $query = mysqli_query($conn, $requete);
      header("Location: validation.php");
  }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <section class="vh-100" style="background-color: #6BA7F0;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-flex align-items-center">
                                <img src="../Image/10705723_44658.jpg" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-4 text-black">

                                    <form method="post" action="">


                                        <h5 class="fw-semibold mb-3 mt-3 pb-3" style="letter-spacing: 1px;">Créer un
                                            compte
                                        </h5>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="prenom" class="form-control" id="floatingInput"
                                                value="<?php echo $prenom; ?>" placeholder="name">
                                            <label class="text-secondary" for="floatingInput">Prénom</label>
                                            <span class="ms-2 text-danger "><?php echo $erreur_prenom;?></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="nom" class="form-control" id="floatingInput"
                                                value="<?php echo $nom; ?>" placeholder="last">
                                            <label class="text-secondary" for="floatingInput">Nom</label>
                                            <span class="ms-2 text-danger "><?php echo $erreur_nom;?></span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="floatingInput"
                                                value="<?php echo $email; ?>" placeholder="name@example.com">
                                            <label class="text-secondary" for="floatingInput">Email address</label>
                                            <span class="ms-2 text-danger "><?php echo $erreur_email; ?></span>
                                        </div>
                                        <div class="form-floating mb-3 ">
                                            <input type="password" name="password" class="form-control"
                                                id="floatingPassword" placeholder="Password">
                                            <label class="text-secondary" for="floatingPassword">Mot de passe</label>
                                            <span class="ms-2 text-danger "><?php echo $erreur_mot_de_passe; ?></span>
                                        </div>

                                        <div class="pt-1 mb-3 d-flex justify-content-end">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit"
                                                name="submit">Créer un compte</button>
                                        </div>

                                        <p class="mb-3 pb-lg-2" style="color: #393f81;">Vous avez déjà un compte ?<a
                                                href="index.php" style="color: #393f81;"> Connectez-vous ici</a></p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>