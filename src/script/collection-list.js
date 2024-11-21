document.addEventListener("DOMContentLoaded", () => {
    const addToCollectionButton = document.querySelector(".add-to-collection");
    const collectionItemsContainer = document.getElementById("collection-items");
    const quantityInput = document.querySelector(".quantity-input");

    const collectionList = {};

    // Function to render the collection list
    function renderCollectionList() {
        collectionItemsContainer.innerHTML = ""; // Clear the list

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

    // Add event listener to the "Add to Collection" button
    addToCollectionButton.addEventListener("click", () => {
        const productName = document.querySelector("h1").textContent;
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
