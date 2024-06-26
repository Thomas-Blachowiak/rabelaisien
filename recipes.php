<?php
session_start();
require_once "includes/connect.php";
//On écrit la requête
$sql = "SELECT * FROM `recipes`";

//On exécute la requête
$request = $db->query($sql);

//On récupère les données
$recipes = $request->fetchAll();

require_once "includes/header.php";
include_once "includes/nav.php";
?>
<div class="d-flex align-items-center justify-content-center" id="recette">
    <div class="container">
        <div class="col">
            <h1 class="p-4 fs-1">
                <strong>Les Réjouissances culinaires de nos compères</strong>
            </h1>
        </div>
    </div>
</div>

<section class="container mt-4">
    <div class="row">
        <?php foreach ($recipes as $recipe) : ?>
        <div class="col-md-4 mb-4">
            <article class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">
                        <a href="recipe.php?id=<?= $recipe["id_recipes"] ?>" class="text-decoration-none">
                            <?= strip_tags($recipe["title"]) ?>
                        </a>
                    </h2>
                    <div class="card-text"><?= nl2br(strip_tags($recipe["ingredient"])) ?></div><br>
                    <div class="card-text"><?= nl2br(strip_tags($recipe["preparation"])) ?></div><br>
                    <p class="card-text text-muted">Temps estimé :
                        <?= strip_tags($recipe["duration"]) ?></p>
                    <p class="card-text text-muted">Publié par :
                        <?= strip_tags($recipe["author"]) ?></p>
                    <button data-recipe-id="<?= $recipe['id_recipes'] ?>" class="btn btn-primary like-btn">
                        <span class="like-count pr-1"><?= $recipe['like_count'] ?></span>
                        Like
                    </button>

                </div>
                <img src="data:image/jpeg;base64,<?= base64_encode($recipe['image']) ?>" class="card-img-bottom"
                    alt=" <?= htmlspecialchars($recipe['title']) ?>">
            </article>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php
include_once "includes/footer.php";
?>