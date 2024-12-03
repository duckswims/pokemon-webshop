document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    // General form validation logic for all pages
    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            let isValid = true;

            const usernameField = form.querySelector("#uName");
            const passwordField = form.querySelector("#password");
            const repeatPasswordField = form.querySelector("#repeatPassword");

            resetField(usernameField);
            resetField(passwordField);
            if (repeatPasswordField) resetField(repeatPasswordField);

            // Validate Username
            if (!validateUsername(usernameField.value)) {
                highlightField(usernameField, false);
                isValid = false;
            } else {
                highlightField(usernameField, true);
            }

            // Validate Password
            if (!validatePassword(passwordField.value)) {
                highlightField(passwordField, false);
                isValid = false;
            } else {
                highlightField(passwordField, true);
            }

            // Validate Password Repetition
            if (repeatPasswordField && passwordField.value !== repeatPasswordField.value) {
                highlightField(repeatPasswordField, false);
                isValid = false;
            } else if (repeatPasswordField) {
                highlightField(repeatPasswordField, true);
            }

            if (!isValid) e.preventDefault();
        });
    });

    // New: Add validation logic for Customer Profile page
    const profileBox = document.querySelector(".profile-box");

    if (profileBox) {
        const usernameField = profileBox.querySelector("#uName");
        const passwordField = profileBox.querySelector("#password");
        const usernameSubmitButton = profileBox.querySelectorAll("input[type='submit']")[0];
        const passwordSubmitButton = profileBox.querySelectorAll("input[type='submit']")[1];

        // Validate username change
        usernameSubmitButton.addEventListener("click", (e) => {
            resetField(usernameField);
            if (!validateUsername(usernameField.value)) {
                highlightField(usernameField, false);
                e.preventDefault();
            } else {
                highlightField(usernameField, true);
            }
        });

        // Validate password change
        passwordSubmitButton.addEventListener("click", (e) => {
            resetField(passwordField);
            if (!validatePassword(passwordField.value)) {
                highlightField(passwordField, false);
                e.preventDefault();
            } else {
                highlightField(passwordField, true);
            }
        });
    }

    // Helper functions
    function validateUsername(username) {
        const minLength = 5;
        const hasUpperCase = /[A-Z]/.test(username);
        const hasLowerCase = /[a-z]/.test(username);
        return username.length >= minLength && hasUpperCase && hasLowerCase;
    }

    function validatePassword(password) {
        const minLength = 10;
        return password.length >= minLength;
    }

    function highlightField(field, isValid) {
        field.style.borderColor = isValid ? "green" : "red";
    }

    function resetField(field) {
        field.style.borderColor = "";
    }
});
