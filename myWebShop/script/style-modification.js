document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.querySelector(".mode-button");  // Correct the class name here
    const toggleImage = toggleButton.querySelector(".mode-img");
    const UserImg = document.querySelector(".user-img");
    const CartImg = document.getElementById("cart-icon");
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
            toggleImage.src = "/myWebShop/img/mode/light_sun.png";
            UserImg.src = "/myWebShop/img/user_dark_mode.png";
            CartImg.src = "/myWebShop/img/cart_dark_mode.png";
        } else {
            parentBody.classList.remove("dark-mode");
            childBody.classList.remove("dark-mode");
            loginBox?.classList.remove("dark-mode");
            registerBox?.classList.remove("dark-mode");
            toggleImage.src = "/myWebShop/img/mode/dark_moon.png";
            UserImg.src = "/myWebShop/img/user.png";
            CartImg.src = "/myWebShop/img/cart.png";
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
    const mediaQuery = window.matchMedia('(max-width: 756px)');
    const navContainer = document.querySelector('.nav-container'); // Assuming your nav links are inside a container

    // Function to toggle the display of the nav links based on screen size
    const toggleNavLinks = () => {
        if (mediaQuery.matches) {
            // If on a small screen, use the hamburger menu to toggle nav links visibility
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        } else {
            // If on a larger screen, show the nav links normally
            navLinks.style.display = 'flex';
        }
    };

    // Initial check for screen size
    toggleNavLinks();

    // Toggle the navigation links visibility when hamburger button is clicked
    hamburgerBtn.addEventListener('click', (e) => {
        // Prevent clicking on the hamburger button from triggering the event listener to close the menu
        e.stopPropagation();
        if (mediaQuery.matches) {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        }
    });

    // Close the navigation menu if clicked outside
    document.addEventListener('click', (e) => {
        if (mediaQuery.matches && !navContainer.contains(e.target) && !hamburgerBtn.contains(e.target)) {
            navLinks.style.display = 'none';
        }
    });

    // Watch for window resize and adjust nav links display
    mediaQuery.addEventListener('change', () => {
        toggleNavLinks();
    });
});
