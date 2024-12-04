document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.querySelector(".mode-button");  // Correct the class name here
    const toggleImage = toggleButton.querySelector(".mode-img");
    const parentDoc = window.parent.document; // Access the parent document
    const parentBody = parentDoc.body;
    const childBody = document.body; // Current iframe's body

    // Function to set the mode based on the saved value
    const setMode = (mode) => {
        const loginBox = parentDoc.querySelector('.login-box');
        const registerBox = parentDoc.querySelector('.register-box');

        if (mode === "dark") {
            parentBody.classList.add("dark-mode");
            childBody.classList.add("dark-mode");
            loginBox?.classList.add("dark-mode");  // Optional: Prevent errors if elements don't exist
            registerBox?.classList.add("dark-mode");
            toggleImage.src = "img/mode/dark.png";
        } else {
            parentBody.classList.remove("dark-mode");
            childBody.classList.remove("dark-mode");
            loginBox?.classList.remove("dark-mode");
            registerBox?.classList.remove("dark-mode");
            toggleImage.src = "img/mode/light.png";
        }
    };

    // Get the saved mode from localStorage
    const savedMode = localStorage.getItem("colorMode");
    setMode(savedMode || "light"); // Default to light mode

    // Add click event listener to toggle the mode
    toggleButton.addEventListener("click", () => {
        const isDarkMode = parentBody.classList.contains("dark-mode");

        if (isDarkMode) {
            setMode("light");  // Switch to light mode
            localStorage.setItem("colorMode", "light");
        } else {
            setMode("dark");  // Switch to dark mode
            localStorage.setItem("colorMode", "dark");
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const navLinks = document.querySelector('.nav-links');

    hamburgerBtn.addEventListener('click', () => {
        // Toggle the visibility of the navigation links
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
    });
});
