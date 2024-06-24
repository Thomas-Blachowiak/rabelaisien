<?php
session_start();
require_once "includes/connect.php";

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    die("Vous devez être connecté pour liker.");
}

$userId = $_SESSION['user']['id'];

// Vérifiez si l'ID de la recette est fourni
if (!isset($_POST['recipe_id']) || empty($_POST['recipe_id'])) {
    die("ID de recette manquant !");
}

$recipeId = (int)$_POST['recipe_id'];

// Vérifiez si l'utilisateur a déjà aimé cette recette
$sql = "SELECT * FROM likes WHERE recipe_id = :recipe_id AND user_id = :user_id";
$request = $db->prepare($sql);
$request->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
$request->bindValue(':user_id', $userId, PDO::PARAM_INT);
$request->execute();

if ($request->fetch()) {
    die("Vous avez déjà aimé cette recette.");
}

// Ajoutez le like
$sql = "INSERT INTO likes (recipe_id, user_id) VALUES (:recipe_id, :user_id)";
$request = $db->prepare($sql);
$request->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
$request->bindValue(':user_id', $userId, PDO::PARAM_INT);

if ($request->execute()) {
    // Mettez à jour le compteur de likes dans la table recipes
    $sql = "UPDATE recipes SET like_count = like_count + 1 WHERE id_recipes = :recipe_id";
    $request = $db->prepare($sql);
    $request->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
    $request->execute();

    header("Location: recipes.php");
    exit;
} else {
    die("Une erreur est survenue lors de l'ajout du like.");
}