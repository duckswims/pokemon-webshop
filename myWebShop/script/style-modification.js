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


document.addEventListener("DOMContentLoaded", () => {
    // Get the orientation button and the image element
    const oriButton = document.querySelector('.ori-button');
    const oriImg = document.querySelector('.ori-img');
    const parentDoc = window.parent.document; // Access the parent document

    // Retrieve the saved orientation state from localStorage
    const savedOrientation = localStorage.getItem('orientation') || 'landscape';

    // Set the initial orientation based on saved state
    if (savedOrientation === 'portrait') {
        parentDoc.body.style.width = '400px';  // Set the width to simulate portrait mode
        oriImg.src = 'img/orientation/toHorizontal.png'; // Set image to "horizontal" when in portrait mode
    } else {
        parentDoc.body.style.width = '2000px';  // Set the width to simulate landscape mode
        oriImg.src = 'img/orientation/toPortrait.png'; // Set image to "portrait" when in landscape mode
    }

    // Function to toggle between portrait and landscape
    let isPortrait = savedOrientation === 'portrait';  // Initialize based on saved state

    oriButton.addEventListener('click', () => {
        if (isPortrait) {
            // If the screen is in portrait mode, change to landscape
            parentDoc.body.style.width = '2000px'; // Set to landscape width
            oriImg.src = 'img/orientation/toPortrait.png';
            localStorage.setItem('orientation', 'landscape');
        } else {
            // If the screen is in landscape mode, change to portrait
            parentDoc.body.style.width = '400px'; // Set to portrait width
            oriImg.src = 'img/orientation/toHorizontal.png';
            localStorage.setItem('orientation', 'portrait');
        }
        isPortrait = !isPortrait; // Toggle the state
    });
});
