<?php
session_start();
require_once "includes/connect.php";
require_once "includes/header.php";
include_once "includes/nav.php";
?>

<div class="d-flex align-items-center justify-content-center" id="about-me">
    <div class="container">
        <div class="col p-3">
            <h1 class="fs-1 ">
                <strong>Les Rabelaisiens</strong>
            </h1>
            <h2 class="fs-3">
                Partagez vos secrets culinaires, échangez vos astuces et laissez-vous guider par les conseils avisés des
                maîtres queux. <br>
                Que ce site devienne le grimoire de vos cuisines, le guide inestimable de vos festins et banquets !
            </h2>
        </div>
    </div>
</div>


<?php
include_once "includes/footer.php";
?>