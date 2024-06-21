<?php
// On démarre la session PHP
session_start();
// Si on est connecté on va sur recipes.php
if (isset($_SESSION["user"])) {
    header("Location: recipes.php");
    exit;
}
// On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
    // Le formulaire à été envoyé
    // On vérifie que TOus les champs requis sont remplis
    if (
        isset($_POST["nickname"], $_POST["email"], $_POST["pass"])
        && !empty($_POST["nickname"]) && !empty($_POST["email"]) && !empty($_POST["pass"])
    ) {

        // Le formulaire est complet
        // On récupère les données en les protégeant
        $nickname = strip_tags($_POST["nickname"]);

        $_SESSION["error"] = [];

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "L'adresse email est incorrecte";
        }

        if ($_SESSION["error"] === []) {
            // On va hasher le mot de passe 
            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

            // On enregistre en bdd
            require_once "includes/connect.php";

            $sql = "INSERT INTO `users`(`name`, `email`, `password`, `roles`) VALUES (:nickname, :email, '$pass', '[\"ROLE_USER\"]')";

            $request = $db->prepare($sql);

            $request->bindValue(":nickname", $nickname, PDO::PARAM_STR);
            $request->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

            $request->execute();

            // On récupère l'id du nouvel utilisateur
            $id = $db->lastInsertId();

            // On connectera l'utilisateur
            // On va pourvoir "connecter" l'utilisateur (ouvri la session)


            // On stocke dans $_SESSION les information de l'utilisateur
            $_SESSION["user"] = [
                "id" => $id,
                "nickname" => $nickname,
                "email" => $_POST["email"],
                "roles" => ["ROLE_USER"]
            ];

            // On redirige vers la page profil
            header("Location: recipes.php");
        }
    } else {
        die("Le formulaire est incomplet");
    }
}


require_once "includes/header.php";
include_once "includes/nav.php";
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Inscription</h1>

    <?php
    if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $message)
    ?>
        <p><?= $message ?></p>
    <?php
    }
    ?>
    <form method="post">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="nickname" id="nickname" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="pass">Mot de passe</label>
            <input type="password" name="pass" id="pass" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-block">M'inscrire</button>
    </form>
</div>


<?php
include_once "includes/footer.php";
?>