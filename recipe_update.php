<?php
session_start();
require_once "includes/connect.php";

$sql = "UPDATE `users` SET `password` = 'blako57' WHERE `users`.`id` = 4";

$request = $db->query($sql);

require_once "includes/header.php";
include_once "includes/nav.php";
?>
<div class="d-flex align-items-center justify-content-center" id="recette">
    <div class="container">
        <div class="col">
            <h1 class="p-4 fs-1">
                <strong>Modifier <?= strip_tags($recipe["title"]) ?> </strong>
            </h1>
        </div>
    </div>
</div>

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
?>