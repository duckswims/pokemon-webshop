document.addEventListener("DOMContentLoaded", () => {
    const addToCollectionButton = document.querySelector(".add-to-collection");
    const quantityInput = document.querySelector(".quantity-input"); 
    const iframe = document.querySelector(".collection-list-iframe");

    // Function to send data to iframe
    function sendCollectionToIframe(collectionData) {
        iframe.contentWindow.postMessage({ type: 'updateCollection', collectionData }, '*');
    }

    // Add event listener to the "Add to Collection" button
    addToCollectionButton.addEventListener("click", () => {
        const productName = document.querySelector("h1").textContent;
        const quantity = parseInt(quantityInput.value, 10);
        console.log(quantity)

        if (quantity <= 0) {
            alert("Quantity must be at least 1!");
            return;
        }

        // Get the existing collection data from iframe
        iframe.contentWindow.postMessage({ type: 'getCollection' }, '*');

        // Handle collection data from iframe and update
        window.addEventListener("message", (event) => {
            if (event.origin !== window.origin) return; // Validate the origin
            const { type, collectionData } = event.data;

            if (type === 'collectionData') {
                console.log('--')
                console.log(collectionData[productName])
                // If the product already exists, accumulate the quantity.
                if (collectionData[productName]) {
                    collectionData[productName].quantity += quantity; // Add to existing quantity
                } else {
                    // Otherwise, add the new product with the specified quantity
                    collectionData[productName] = { quantity };
                }

                // Send the updated collection data back to the iframe
                sendCollectionToIframe(collectionData);
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", () => {
    const collectionItemsContainer = document.getElementById("collection-items");
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
                // Send the updated collection to the parent
                window.parent.postMessage({ type: 'updateCollection', collectionData: collectionList }, '*');
            });

            listItem.appendChild(removeButton);
            collectionItemsContainer.appendChild(listItem);
        }
    }

    // Listen for messages from the parent page
    window.addEventListener("message", (event) => {
        if (event.origin !== window.origin) return; // Validate the origin

        const { type, collectionData } = event.data;

        if (type === 'updateCollection') {
            // Update the collection with the data from the parent
            Object.assign(collectionList, collectionData);
            renderCollectionList();
        } else if (type === 'getCollection') {
            // Send the current collection data to the parent
            window.parent.postMessage({ type: 'collectionData', collectionData: collectionList }, '*');
        }
    });

    // Initial render of the collection list (if any data is already there)
    renderCollectionList();
});
