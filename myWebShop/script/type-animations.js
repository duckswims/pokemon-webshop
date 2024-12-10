document.addEventListener("DOMContentLoaded", () => {
    const typeButtons = document.querySelectorAll(".product-container .info button"); // Buttons for types

    // Map of Pokémon types to their corresponding emojis
    const typeEmojis = {
        Grass: "🌿",
        Fire: "🔥",
        Water: "🌊",
        Bug: "🪲",
        Electric: "⚡",
        Rock: "🪨",
        Poison: "☠️",
        Flying: "🕊️",
        Psychic: "🔮",
        Fairy: "🍬",
        Ghost: "👻",
        Steel: "⚙️",
        Ice: "❄️",
        Dragon: "🐉",
        Dark: "🌘",
        Ground: "🌍",
        Fighting: "🥋",
        Normal: "😐"
    };

    // Function to create and display emojis
    function displayEmojis(type) {
        const emojiContainer = document.createElement("div");
        emojiContainer.classList.add("emoji-container");
        document.body.appendChild(emojiContainer);

        // Get header and footer heights to calculate the available space
        const headerHeight = document.querySelector("header").offsetHeight || 0;
        const footerHeight = 0;
        const availableHeight = window.innerHeight - headerHeight - footerHeight;

        for (let i = 0; i < 50; i++) {
            const emoji = document.createElement("div");
            emoji.textContent = typeEmojis[type];
            emoji.classList.add("emoji");

            // Randomize position within the allowed area
            emoji.style.left = `${Math.random() * 100}vw`;
            emoji.style.top = `${headerHeight + Math.random() * availableHeight}px`;
            emoji.style.fontSize = `${Math.random() * 3 + 1}rem`; // Sizes vary from 1rem to 4rem
            emoji.style.opacity = "0.5";
            emojiContainer.appendChild(emoji);

            // Remove emoji after a fixed period
            setTimeout(() => {
                emoji.remove();
            }, 2000); // Fixed display time of 2 seconds
        }

        // Remove container after all emojis disappear
        setTimeout(() => {
            emojiContainer.remove();
        }, 2000);
    }

    // Add event listeners to type buttons
    typeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const type = button.className.split(" ").pop(); // Get the type from the button class
            if (typeEmojis[type]) {
                displayEmojis(type);
            }
        });
    });
});
