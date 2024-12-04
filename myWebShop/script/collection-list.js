document.addEventListener("DOMContentLoaded", () => {
    const collectionItemsContainer = document.getElementById("collection-items");
    const collectionSection = document.querySelector(".collection-list"); // Get the section element
    const addToCartButtons = document.querySelectorAll(".add-cart");
    const collectionList = {};

    // Function to render the collection list
    function renderCollectionList() {
        collectionItemsContainer.innerHTML = ""; // Clear the list

        if (Object.keys(collectionList).length === 0) {
            // If the collection is empty, hide the section
            collectionSection.style.display = "none";
        } else {
            // If the collection has items, display the section
            collectionSection.style.display = "block";

            for (const [productName, productData] of Object.entries(collectionList)) {
                const listItem = document.createElement("li");
                listItem.textContent = `${productName} - Quantity: ${productData.quantity}`;
                
                const removeButton = document.createElement("button");
                removeButton.textContent = "Remove";
                removeButton.style.marginLeft = "10px";
                removeButton.addEventListener("click", () => {
                    delete collectionList[productName];
                    renderCollectionList();
                });
                listItem.appendChild(removeButton);
                collectionItemsContainer.appendChild(listItem);
            }
        }
    }

    // Add event listener to the "Add to Collection" button inside each product box
    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productBox = button.closest(".product-box");
            const productName = productBox.querySelector(".title").textContent; // Get product name from <h3> with class "title"
            const quantityInput = productBox.querySelector(".qty-input"); // Get the quantity input
            const quantity = parseInt(quantityInput.value, 10);
            
            if (quantity <= 0) {
                alert("Quantity must be at least 1!");
                return;
            }

            if (collectionList[productName]) {
                // Update quantity if product already in collection
                collectionList[productName].quantity += quantity;
            } else {
                // Add new product to collection
                collectionList[productName] = { quantity };
            }
            renderCollectionList();
        });
    });

    // Initialize with the collection section hidden
    collectionSection.style.display = "none";
});
