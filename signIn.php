<?php
// On démarre la session PHP
session_start();
// Si on est connecté on va sur profil.php (protection des pages)
if (isset($_SESSION["user"])) {
    header("Location: recipes.php");
    exit;
}
// On vérifie si le formulaire a été envoyé
if (!empty($_POST)) {
    // Le formulaire à été envoyé
    // On vérifie que TOus les champs requis sont remplis
    if (
        isset($_POST["email"], $_POST["pass"])
        && !empty($_POST["email"]) && !empty($_POST["pass"])
    ) {
        $_SESSION["error"] = [];
        // On vérifie que c'est bien un email 
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "Ce n'est pas un email";
        }

        if ($_SESSION["error"] === []) {
            // On se connecte en bdd
            require_once "includes/connect.php";



            $sql = "SELECT * FROM `users`WHERE `email`= :email";

            $request = $db->prepare($sql);

            $request->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

            $request->execute();

            $user = $request->fetch();

            if (!$user) {
                $_SESSION["error"][] = "L'utilisateur et/ou le mot de passe est incorrect";
            }

            // Ici on a un user existant, on peut vérifier le mdp
            if (!password_verify($_POST["pass"], $user["password"])) {
                $_SESSION["error"][] = "L'utilisateur et/ou le mot de passe est incorrect";
            }
            if ($_SESSION["error"] === []) {
                // Ici l'utilisateur et le mdp sont corrects
                // On va pourvoir "connecter" l'utilisateur (ouvri la session)


                // On stocke dans $_SESSION les information de l'utilisateur
                $_SESSION["user"] = [
                    "id" => $user["id"],
                    "nickname" => $user["name"],
                    "email" => $user["email"],
                    "roles" => $user["roles"]
                ];

                // On redirige vers la page profil
                header("Location: recipes.php");
            }
        }
    } else {
        die("Le formulaire est incomplet");
    }
}


require_once "includes/header.php";
include_once "includes/nav.php";
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Connexion</h1>

    <?php
    if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $message)
    ?>
        <p><?= $message ?></p>
    <?php
    }
    unset($_SESSION["error"]);
    ?>
    <form method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="pass">Mot de passe</label>
            <input type="password" name="pass" id="pass" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Me connecter</button>
    </form>
</div>


<?php
include_once "includes/footer.php";
?>