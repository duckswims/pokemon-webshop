document.addEventListener("DOMContentLoaded", () => {
    let convertButton = document.getElementById("convert-button");
    let fromCurrency = document.getElementById("from-currency");
    let toCurrency = document.getElementById("to-currency");
    let convertedResult = document.getElementById("converted-result");

    // Function to convert currency from EUR to < >
    convertButton.addEventListener("click", convert); 

    function convert() {
        switch (toCurrency.value) {
            case "usd":
                convertedResult.value = fromCurrency.value * 1.04;
                break;
            case "gbp":
                convertedResult.value = fromCurrency.value * 0.83;
                break;
            case "cad":
                convertedResult.value = fromCurrency.value * 1.46;
                break;
            case "aud":
                convertedResult.value = fromCurrency.value * 1.60;
                break;
            case "jpy":
                convertedResult.value = fromCurrency.value * 161.25;
                break;
            case "sgd":
                convertedResult.value = fromCurrency.value * 1.40;
                break;
            case "hkd":
                convertedResult.value = fromCurrency.value * 8.11;
                break;
            case "cny":
                convertedResult.value = fromCurrency.value * 7.55;
                break;
            case "myr":
                convertedResult.value = fromCurrency.value * 4.64;
                break;
            case "krw":
                convertedResult.value = fromCurrency.value * 1463.80;
                break;
            case "btc":
                convertedResult.value = fromCurrency.value * 0.000011;
                break;    
        }
    }
})