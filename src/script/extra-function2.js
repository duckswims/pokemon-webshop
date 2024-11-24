document.addEventListener("DOMContentLoaded", () => {
let iChooseYou = document.getElementById("i-choose-you");

    // Random choice of product
    iChooseYou.addEventListener("click", random);

    function random() {
        index = Math.floor(Math.random() * 6);
        switch (index) {
            case 0:
                window.location.href= "product_id/0001.html";
                break;
            case 1:
                window.location.href= "product_id/0002.html";
                break;
            case 2:
                window.location.href= "product_id/0003.html";
                break;
            case 3:
                window.location.href= "product_id/0007.html";
                break;
            case 4:
                window.location.href= "product_id/0008.html";
                break;
            case 5:
                window.location.href= "product_id/0009.html";
                break;
        }

    }
})