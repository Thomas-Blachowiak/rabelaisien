document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var recipeId = this.getAttribute("data-recipe-id");
            var likeCountSpan = this.querySelector(".like-count");

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "like_recipe.php", true);
            xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded"
            );
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
            xhr.send("recipe_id=" + recipeId);
        });
    });
});
