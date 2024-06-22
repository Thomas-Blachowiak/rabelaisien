<?php
session_start();
// On traite le formulaire
if (!empty($_POST)) {
    // POST n'est pas vide, on vérifie que toutes les données sont présentes
    if (
        isset($_POST["titre"], $_POST["ingredient"], $_POST["preparation"], $_POST["duration"])
        && !empty($_POST["titre"]) && !empty($_POST["ingredient"]) && !empty($_POST["preparation"]) && !empty($_POST["duration"])
    ) {
        // Le formulaire est complet
        // On récupère les données en les protégeant (faille xss)
        // On retire toute la balise du titre
        $titre = strip_tags($_POST["titre"]);
        //on neutralise toute balise du contenu
        $ingredient = htmlspecialchars($_POST["ingredient"]);
        $preparation = htmlspecialchars($_POST["preparation"]);
        $duration = strip_tags($_POST["duration"]);
        $author = $_SESSION["user"]["nickname"];

        // On peut les enregistrer
        // On se connecte à la bdd
        require_once "includes/connect.php";

        // On écrit la requête
        $sql = "INSERT INTO `recipes`(`title`, `ingredient`, `preparation`, `duration`, `author`) VALUES (:title, :ingredient, :preparation, :duration, '$author')";
        // On prépare la requête
        $request = $db->prepare($sql);
        // On injecte les valeurs
        $request->bindValue(":title", $titre, PDO::PARAM_STR);
        $request->bindValue(":ingredient", $ingredient, PDO::PARAM_STR); // on fait le liens entre les valeurs 
        $request->bindValue(":preparation", $preparation, PDO::PARAM_STR); // on fait le liens entre les valeurs 
        $request->bindValue(":duration", $duration, PDO::PARAM_STR); // on fait le liens entre les valeurs 


        // On exécute la requête
        if (!$request->execute()) {
            die("Une erreur est survenue");
        }
        // On récupère l'id de l'article
        $id = $db->lastInsertId();

        header("Location: recipes.php");
    } else {
        var_dump($_POST);
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
        <label for="ingredient">Ingrédients</label>
        <textarea name="ingredient" id="ingredient" class="form-control" rows="5" required
            placeholder="ex : Salade, tomates, oignons......"></textarea>
    </div>
    <div class="form-group">
        <label for="preparation">Préparation</label>
        <textarea name="preparation" id="preparation" class="form-control" rows="5" required
            placeholder="ex : Casser les oeux, les battres....."></textarea>
    </div>
    <div class="form-group">
        <label for="duration">Temps</label>
        <input type="text" name="duration" id="duration" class="form-control" required>

    </div>
    <button type="submit" class="btn btn-primary">Partager</button>
</form>


<?php

include_once "includes/footer.php";