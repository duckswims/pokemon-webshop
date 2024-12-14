document.addEventListener("DOMContentLoaded", () => {
    let iChooseYou = document.getElementById("i-choose-you");
    
        // Random choice of product
        iChooseYou.addEventListener("click", random);
    
        function random() {
            fetch('json/product.json')
                .then(response => response.json())
                .then(data => {
                    const products = data.product;
                    const randomIndex = Math.floor(Math.random() * products.length);
                    const selectedProduct = products[randomIndex];
    
                    // Redirect to product.php with the selected product's pid
                    window.location.href = `product.php?pid=${selectedProduct.pid}`;
                })
                .catch(error => {
                    console.error('Error fetching product data:', error);
                });
    
        }
    })