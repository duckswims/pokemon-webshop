// document.addEventListener("DOMContentLoaded", () => {
//     const collectionItemsContainer = document.getElementById("collection-items");
//     const collectionSection = document.querySelector(".collection-list"); // Get the section element
//     const addToCartButtons = document.querySelectorAll(".add-cart");
//     window.collectionList = {};

//     // Function to render the collection list
//     function renderCollectionList() {
//         collectionItemsContainer.innerHTML = ""; // Clear the list

//         if (Object.keys(collectionList).length === 0) {
//             // If the collection is empty, hide the section
//             collectionSection.style.display = "none";
//         } else {
//             // If the collection has items, display the section
//             collectionSection.style.display = "block";

//             // Sort the collectionList alphabetically by product name
//             const sortedEntries = Object.entries(collectionList).sort(([nameA], [nameB]) => {
//                 return nameA.localeCompare(nameB); // Sort alphabetically by product name
//             });

//             // Render the sorted collection list
//             sortedEntries.forEach(([productName, productData]) => {
//                 const listItem = document.createElement("li");
//                 listItem.textContent = `${productName} - Quantity: ${productData.quantity}`;
                
//                 const removeButton = document.createElement("button");
//                 removeButton.textContent = "Remove";
//                 removeButton.style.marginLeft = "10px";
//                 removeButton.addEventListener("click", () => {
//                     delete collectionList[productName];
//                     renderCollectionList();
//                     // Update the cart icon when an item is removed
//                     updateCartIcon();
//                 });
//                 listItem.appendChild(removeButton);
//                 collectionItemsContainer.appendChild(listItem);
//             });
//         }
//     }

//     // Add event listener to the "Add to Collection" button inside each product box
//     addToCartButtons.forEach(button => {
//         button.addEventListener("click", () => {
//             const productBox = button.closest(".product-box");
//             const productName = productBox.querySelector(".title").textContent; // Get product name from <h3> with class "title"
//             const quantityInput = productBox.querySelector(".qty-input"); // Get the quantity input
//             const quantity = parseInt(quantityInput.value, 10);
            
//             if (quantity <= 0) {
//                 alert("Quantity must be at least 1!");
//                 return;
//             }

//             if (collectionList[productName]) {
//                 // Update quantity if product already in collection
//                 collectionList[productName].quantity += quantity;
//             } else {
//                 // Add new product to collection
//                 collectionList[productName] = { quantity };
//             }
//             renderCollectionList();
//             renderCollectionList();
//             updateCartIcon(); // Update the cart icon when an item is added
//         });
//     });

//     // Initialize with the collection section hidden
//     collectionSection.style.display = "none";
// });


document.addEventListener("DOMContentLoaded", () => {
    // Add event listener to all "Add to cart" buttons
    document.querySelectorAll(".add-cart").forEach(button => {
        button.addEventListener("click", (event) => {
            const productBox = event.target.closest(".product-box");
            const pid = productBox.getAttribute("data-pid");
            const quantity = productBox.querySelector(".qty-input").value;

            // Prepare data to send
            const cartData = { pid: pid, quantity: parseInt(quantity) };

            // Send data to PHP
            fetch("all-products.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(cartData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Item added to cart successfully!");
                } else {
                    alert("Failed to add item to cart: " + data.error);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
});
