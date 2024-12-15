document.addEventListener("DOMContentLoaded", function(){
    var addToCartButtons = document.querySelectorAll(".add-cart");

    addToCartButtons.forEach(function(button){
        var imgElement = button.closest(".box.product-box").querySelector("img");
        var imgBackupSrc = "img/pokeball.png";

        button.addEventListener("mouseenter", function(event){
            imgElement.dataset.originalSrc = imgElement.src; // store original src in data-* attribute
            imgElement.src = imgBackupSrc;
            imgElement.classList.add('shake'); // add the shake class to start the animation
        });

        button.addEventListener("mouseleave", function(event){
            imgElement.src = imgElement.dataset.originalSrc;
            imgElement.classList.remove('shake'); // remove the shake class to stop the animation
        });

    });
});