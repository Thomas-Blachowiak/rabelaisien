<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Rabelaisiens</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="recipes.php">Les recettes</a>
                </li>
                <?php
                if (isset($_SESSION["user"])) {
                    echo '<a class="nav-link p-2" aria-current="page" href="signIn.php">Ajouter une recette</a>';
                }
                ?>

            </ul>
            <?php if (!isset($_SESSION["user"])) : ?>
                <a class="nav-link p-2" aria-current="page" href="signIn.php">Connexion</a>
                <a class="nav-link p-2" aria-current="page" href="signUp.php">S'inscrire</a>
            <?php else : ?>
                <a class="nav-link p-2" aria-current="page" href="signOut.php">Deconnexion</a>
            <?php endif; ?>
        </div>
    </div>
</nav>