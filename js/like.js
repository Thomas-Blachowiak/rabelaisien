// Attend que le document soit complètement chargé avant d'exécuter le script
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionne tous les boutons avec la classe "like-btn"
    document.querySelectorAll(".like-btn").forEach(function (button) {
        // Ajoute un écouteur d'événements pour chaque bouton "like-btn"
        button.addEventListener("click", function () {
            // Récupère l'ID de la recette à partir de l'attribut "data-recipe-id" du bouton
            var recipeId = this.getAttribute("data-recipe-id");
            // Sélectionne l'élément qui affiche le nombre de likes (enfant du bouton)
            var likeCountSpan = this.querySelector(".like-count");
            var xhr = new XMLHttpRequest();
            // Configure la requête pour envoyer des données en POST à "like_recipe.php"
            xhr.open("POST", "like_recipe.php", true);
            // Définit l'en-tête de la requête pour indiquer que les données sont envoyées en URL-encoded format
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );

            // Définit une fonction à exécuter lorsque l'état de la requête change
            xhr.onreadystatechange = function () {
                if (
                    xhr.readyState === XMLHttpRequest.DONE &&
                    xhr.status === 200
                ) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        likeCountSpan.textContent = response.like_count;
                    } else {
                        alert(response.message);
                    }
                }
            };
            // Envoie la requête avec l'ID de la recette comme paramètre
            xhr.send("recipe_id=" + recipeId);
        });
    });
});
