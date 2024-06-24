<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Rabelaisiens</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="recipes.php">Livre des festins</a>
                </li>
                <?php
                if (isset($_SESSION["user"])) {
                    echo '<a class="nav-link p-2" aria-current="page" href="add_recipes.php">Consigner un met au livre des festins</a>';
                    echo '<a class="nav-link p-2" aria-current="page" href="recipes_user.php">Mes partages</a>';
                }
                ?>

            </ul>
            <?php if (!isset($_SESSION["user"])) : ?>
            <a class="nav-link p-2" aria-current="page" href="signIn.php">Accès</a>
            <a class="nav-link p-2" aria-current="page" href="signUp.php">Ralliement</a>
            <?php else : ?>
            <a class="nav-link p-2 disabled">Bonjour <?php echo $_SESSION["user"]["nickname"]; ?> !</a>
            <a class="nav-link p-2" aria-current="page" href="signOut.php"><strong>Sortie</strong></a>
            <?php endif; ?>
        </div>
    </div>
</nav>