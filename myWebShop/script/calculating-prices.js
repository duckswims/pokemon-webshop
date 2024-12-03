document.addEventListener("DOMContentLoaded", () => {
    let calculateButton = document.getElementById("calculate-button");
    let priceInput = document.getElementById("priceWOTax");
    let priceResult = document.getElementById("priceWTax");
    let taxResult = document.getElementById("tax-result");

    // //Function to calculate price with taxes of 19%
    calculateButton.addEventListener("click", getTotalPrice); 

    function getTotalPrice() {
        let tax = priceInput.value * 19 / 100;
        taxResult.value = tax;
        priceResult.value = Number(priceInput.value) + Number(tax);
    }
})