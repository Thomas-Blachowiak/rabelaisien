<?php
session_start();
// On traite le formulaire
if (!empty($_POST)) {
    // POST n'est pas vide, on vérifie que toutes les données sont présentes
    if (
        isset($_POST["titre"], $_POST["content"])
        && !empty($_POST["titre"]) && !empty($_POST["content"])
    ) {
        // Le formulaire est complet
        // On récupère les données en les protégeant (faille xss)
        // On retire toute la balise du titre
        $titre = strip_tags($_POST["titre"]);
        //on neutralise toute balise du contenu
        $content = htmlspecialchars($_POST["content"]);

        $author = $_SESSION["user"]["nickname"];
        var_dump($author);
        // On peut les enregistrer
        // On se connecte à la bdd
        require_once "includes/connect.php";

        // On écrit la requête
        $sql = "INSERT INTO `recipes`(`title`, `content`, `author`) VALUES (:title, :content, '$author')";
        // On prépare la requête
        $request = $db->prepare($sql);
        // On injecte les valeurs
        $request->bindValue(":title", $titre, PDO::PARAM_STR);
        $request->bindValue(":content", $content, PDO::PARAM_STR); // on fait le liens entre les valeurs 

        // On exécute la requête
        if (!$request->execute()) {
            die("Une erreur est survenue");
        }
        // On récupère l'id de l'article
        $id = $db->lastInsertId();

        header("Location: recipes.php");
        die("Article ajouté sous le numéro $id");
    } else {
        die("Le formulaire est incomplet !");
    }
}
require_once "includes/header.php";
include_once "includes/nav.php";
?>
<h1 class="my-5 text-center">Consigner un met</h1>

<form method="post" class="container">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="content">Comment le réaliser</label>
        <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Partager</button>
</form>


<?php

include_once "includes/footer.php";
