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
                alert("Username should be at least 5 characters, and contain at least 1 capital letter and 1 lower case letter.");
                isValid = false;
            }

            // Validate Password
            if (!validatePassword(passwordField.value)) {
                alert("Password should have at least 10 characters.");
                isValid = false;
            }

            // Validate Password Repetition
            if (repeatPasswordField && passwordField.value !== repeatPasswordField.value) {
                alert("Passwords do not match. Please ensure both passwords are identical.");
                isValid = false;
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
                alert("Username should be at least 5 characters, and contain at least 1 capital letter and 1 lower case letter.");
                isValid = false;
            }
        });

        // Validate password change
        passwordSubmitButton.addEventListener("click", (e) => {
            resetField(passwordField);
            if (!validatePassword(passwordField.value)) {
                alert("Password should have at least 10 characters.");
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const usernameForm = document.getElementById("usernameForm");
    const passwordForm = document.getElementById("passwordForm");

    usernameForm.addEventListener("submit", (e) => {
        const usernameField = document.getElementById("uName");
        const validationPassedField = document.getElementById("usernameValidationPassed");
        validationPassedField.value = "false"; // Reset value

        if (!validateUsername(usernameField.value)) {
            alert("Username should be at least 5 characters long, and contain both uppercase and lowercase letters.");
            e.preventDefault();
        } else {
            validationPassedField.value = "true"; // Indicate validation passed
        }
    });

    passwordForm.addEventListener("submit", (e) => {
        const passwordField = document.getElementById("password");
        const validationPassedField = document.getElementById("passwordValidationPassed");
        validationPassedField.value = "false"; // Reset value

        if (!validatePassword(passwordField.value)) {
            alert("Password must be at least 10 characters long.");
            e.preventDefault();
        } else {
            validationPassedField.value = "true"; // Indicate validation passed
        }
    });
});


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


// Button changes for customer.php
document.addEventListener("DOMContentLoaded", () => {
    // Toggle Name Button
    document.getElementById('changeNameButton').addEventListener('click', function () {
        let originalElements = document.querySelectorAll('.nameOriginal');
        let editElements = document.querySelectorAll('.nameEdit');
        let nameInputs = document.getElementById("#nameInputs");
        
        originalElements.forEach(function(element) {
            element.style.display = 'none';
        });
        
        editElements.forEach(function(element) {
            element.style.display = 'table-cell';
        });
    });

    // Toggle Username Button
    document.getElementById('changeUsernameButton').addEventListener('click', function () {
        let originalElements = document.querySelectorAll('.usernameOriginal');
        let editElements = document.querySelectorAll('.usernameEdit');
        
        originalElements.forEach(function(element) {
            element.style.display = 'none';
        });
        
        editElements.forEach(function(element) {
            element.style.display = 'table-cell';
        });
    });

    // Toggle Password Button
    document.getElementById('changePasswordButton').addEventListener('click', function () {
        let originalElements = document.querySelectorAll('.passwordOriginal');
        let editElements = document.querySelectorAll('.passwordEdit');
        
        originalElements.forEach(function(element) {
            element.style.display = 'none';
        });
        
        editElements.forEach(function(element) {
            element.style.display = 'table-cell';
        });
    });
});



// Handles address for customer.php
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("billingAddressButton").addEventListener("click", function() {
        let button = document.getElementById("billingAddressButton");
        let form = document.getElementById("billingAddressForm");
        let disp = document.getElementById("billingAddressDisplay");
    
        // Toggle the visibility of the form
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block"; // Show the form
            disp.style.display = "none";  // Hide the billing address display
            button.style.display = "none"; // Hide the "Add Address" button
        } else {
            form.style.display = "none"; // Hide the form
            disp.style.display = "block"; // Show the billing address display again
            button.style.display = "block"; // Show the "Add Address" button again
        }
    });

    document.getElementById("shippingAddressButton").addEventListener("click", function() {
        let button = document.getElementById("shippingAddressButton");
        let form = document.getElementById("shippingAddressForm");
        let disp = document.getElementById("shippingAddressDisplay");
    
        // Toggle the visibility of the form
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block"; // Show the form
            disp.style.display = "none";  // Hide the shipping address display
            button.style.display = "none"; // Hide the "Add Address" button
        } else {
            form.style.display = "none"; // Hide the form
            disp.style.display = "block"; // Show the shipping address display again
            button.style.display = "block"; // Show the "Add Address" button again
        }
    });
});
