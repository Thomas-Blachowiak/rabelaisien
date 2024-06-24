<?php
session_start();
require_once "includes/connect.php";

header('Content-Type: application/json');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(["success" => false, "message" => "Vous devez être connecté pour liker."]);
    exit;
}

$userId = $_SESSION['user']['id'];

// Vérifiez si l'ID de la recette est fourni
if (!isset($_POST['recipe_id']) || empty($_POST['recipe_id'])) {
    echo json_encode(["success" => false, "message" => "ID de recette manquant !"]);
    exit;
}

$recipeId = (int)$_POST['recipe_id'];

// Vérifiez si l'utilisateur a déjà aimé cette recette
$sql = "SELECT * FROM likes WHERE recipe_id = :recipe_id AND user_id = :user_id";
$request = $db->prepare($sql);
$request->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
$request->bindValue(':user_id', $userId, PDO::PARAM_INT);
$request->execute();

if ($request->fetch()) {
    echo json_encode(["success" => false, "message" => "Vous avez déjà aimé cette recette."]);
    exit;
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

    // Récupérez le nouveau nombre de likes
    $sql = "SELECT like_count FROM recipes WHERE id_recipes = :recipe_id";
    $request = $db->prepare($sql);
    $request->bindValue(':recipe_id', $recipeId, PDO::PARAM_INT);
    $request->execute();
    $likeCount = $request->fetchColumn();

    echo json_encode(["success" => true, "like_count" => $likeCount]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Une erreur est survenue lors de l'ajout du like."]);
    exit;
}