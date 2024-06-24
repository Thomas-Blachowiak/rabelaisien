<?php
session_start();
require_once "includes/connect.php";

if (!empty($_POST)) {
    if (
        isset($_POST["titre"], $_POST["ingredient"], $_POST["preparation"], $_POST["duration"], $_FILES["image"])
        && !empty($_POST["titre"]) && !empty($_POST["ingredient"]) && !empty($_POST["preparation"]) && !empty($_POST["duration"])
        && $_FILES["image"]["error"] == UPLOAD_ERR_OK
    ) {
        // Le formulaire est complet
        $titre = strip_tags($_POST["titre"]);
        $ingredient = htmlspecialchars($_POST["ingredient"]);
        $preparation = htmlspecialchars($_POST["preparation"]);
        $duration = strip_tags($_POST["duration"]);
        $author = $_SESSION["user"]["nickname"];

        // Gestion de l'image
        $image = file_get_contents($_FILES["image"]["tmp_name"]);

        // On écrit la requête
        $sql = "INSERT INTO `recipes`(`title`, `ingredient`, `preparation`, `duration`, `author`, `image`) VALUES (:title, :ingredient, :preparation, :duration, :author, :image)";
        // On prépare la requête
        $request = $db->prepare($sql);
        // On injecte les valeurs
        $request->bindValue(":title", $titre, PDO::PARAM_STR);
        $request->bindValue(":ingredient", $ingredient, PDO::PARAM_STR);
        $request->bindValue(":preparation", $preparation, PDO::PARAM_STR);
        $request->bindValue(":duration", $duration, PDO::PARAM_STR);
        $request->bindValue(":author", $author, PDO::PARAM_STR);
        $request->bindValue(":image", $image, PDO::PARAM_LOB);

        // On exécute la requête
        if (!$request->execute()) {
            die("Une erreur est survenue");
        }
        // On récupère l'id de la recette
        $id = $db->lastInsertId();

        header("Location: recipes.php");
    } else {
        var_dump($_POST);
        var_dump($_FILES);
        die("Le formulaire est incomplet !");
    }
}
require_once "includes/header.php";
include_once "includes/nav.php";
?>
<h1 class="my-5 text-center">Consigner un met</h1>

<form method="post" class="container" enctype="multipart/form-data">
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
            placeholder="ex : Casser les oeux, les battre....."></textarea>
    </div>
    <div class="form-group">
        <label for="duration">Temps</label>
        <input type="text" name="duration" id="duration" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control-file" required>
    </div>
    <button type="submit" class="btn btn-primary">Partager</button>
</form>

<?php include_once "includes/footer.php"; ?>