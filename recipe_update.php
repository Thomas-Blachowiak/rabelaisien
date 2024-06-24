<?php
session_start();
require_once "includes/connect.php";

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION["user"]["nickname"])) {
    header("Location: login.php");
    exit;
}

$author = $_SESSION["user"]["nickname"];

// Vérifiez si l'ID de la recette est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de la recette manquant !");
}

$id = $_GET['id'];

// Récupérez les données de la recette
$sql = "SELECT * FROM `recipes` WHERE `id_recipes` = :id AND `author` = :author";
$request = $db->prepare($sql);
$request->bindValue(':id', $id, PDO::PARAM_INT);
$request->bindValue(':author', $author, PDO::PARAM_STR);
$request->execute();
$recipe = $request->fetch();

// Vérifiez si la recette existe
if (!$recipe) {
    die("Recette non trouvée ou vous n'êtes pas l'auteur !");
}

// Traitez le formulaire
if (!empty($_POST)) {
    // Récupérez et sécurisez les données
    $title = strip_tags($_POST['title']);
    $ingredient = htmlspecialchars($_POST['ingredient']);
    $preparation = htmlspecialchars($_POST['preparation']);
    $duration = strip_tags($_POST['duration']);

    // Mettez à jour la recette
    $sql = "UPDATE `recipes` SET `title` = :title, `ingredient` = :ingredient, `preparation` = :preparation, `duration` = :duration WHERE `id_recipes` = :id";
    $request = $db->prepare($sql);
    $request->bindValue(':title', $title, PDO::PARAM_STR);
    $request->bindValue(':ingredient', $ingredient, PDO::PARAM_STR);
    $request->bindValue(':preparation', $preparation, PDO::PARAM_STR);
    $request->bindValue(':duration', $duration, PDO::PARAM_STR);
    $request->bindValue(':id', $id, PDO::PARAM_INT);

    if ($request->execute()) {
        header("Location: recipes_user.php");
        exit;
    } else {
        die("Une erreur est survenue lors de la mise à jour.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la recette</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Modifier la recette</h1>
        <form method="post">
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="<?= strip_tags($recipe['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="ingredient">Ingrédients</label>
                <textarea name="ingredient" id="ingredient" class="form-control" rows="5"
                    required><?= htmlspecialchars($recipe['ingredient']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="preparation">Préparation</label>
                <textarea name="preparation" id="preparation" class="form-control" rows="5"
                    required><?= htmlspecialchars($recipe['preparation']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="duration">Durée</label>
                <input type="text" name="duration" id="duration" class="form-control"
                    value="<?= strip_tags($recipe['duration']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>
</body>

</html>