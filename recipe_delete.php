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

// Traitez la demande de suppression
if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $sql = "DELETE FROM `recipes` WHERE `id_recipes` = :id";
    $request = $db->prepare($sql);
    $request->bindValue(':id', $id, PDO::PARAM_INT);

    if ($request->execute()) {
        header("Location: recipes_user.php");
        exit;
    } else {
        die("Une erreur est survenue lors de la suppression.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer la recette</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Supprimer la recette</h1>
        <p>Êtes-vous sûr de vouloir supprimer la recette : <strong><?= strip_tags($recipe['title']) ?></strong> ?</p>
        <form method="post">
            <button type="submit" name="confirm" value="yes" class="btn btn-danger">Oui, supprimer</button>
            <a href="recipes.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>

</html>