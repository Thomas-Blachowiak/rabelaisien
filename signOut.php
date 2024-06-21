<?php

session_start();
// Si on est pas connecté on va sur connexion.php
if (!isset($_SESSION["user"])) {
    header("Location: signIn.php");
    exit;
}
// Supprime une variable
unset($_SESSION["user"]);

header("Location: index.php");
