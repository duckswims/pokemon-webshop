<?php
// Start the session to access session variables
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Retrieve the username from the session
$username = $_SESSION['username'];
$firstNameLive = $_SESSION['firstName'];
$jsonFile = "users/$username/info.json";

// Check if the JSON file exists for the logged-in user
if (!file_exists($jsonFile)) {
    die('User data not found.');
}

// Retrieve user data from the JSON file
$userData = json_decode(file_get_contents($jsonFile), true);
$firstName = $userData['firstName'] ?? 'N/A';
$lastName = $userData['lastName'] ?? 'N/A';
$addresses = $userData['address'] ? $userData['address'] : [
    'billingAddress' => null,
    'shippingAddress' => null,
];

// Initialize success and error messages
$successMessage = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Change name
    if (isset($_POST['firstName'], $_POST['lastName'])) {
        $newFirstName = trim($_POST['firstName']);
        $newLastName = trim($_POST['lastName']);

        // Validate inputs
        if (empty($newFirstName) || empty($newLastName)) {
            $errorMessage = 'First and Last Name cannot be empty.';
        } else {
            // Update the JSON file with the new names
            $userData['firstName'] = $newFirstName;
            $userData['lastName'] = $newLastName;
            $firstNameLive = $newFirstName;

            // Save updated data to the JSON file
            file_put_contents($jsonFile, json_encode($userData, JSON_PRETTY_PRINT));

            // Dynamically update name in page
            $firstName = $newFirstName;
            $lastName = $newLastName;

            $successMessage = 'Name successfully updated!';
        }
    }

    // Change username 
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        // Check if JavaScript validation passed
        if ($_POST['validationPassed'] !== 'true') {
            $errorMessage = 'JavaScript validation failed. Please correct errors before submitting.';
        } else {
            $newUsername = $_POST['username'];

            // Check if the new username already exists
            $newPath = "users/$newUsername";
            if (file_exists($newPath)) {
                $errorMessage = 'Username already exists. Please choose another.';
            } else {
                // Rename the user's directory and update the JSON file
                rename("users/$username", $newPath);
                $userData['username'] = $newUsername;
                file_put_contents("$newPath/info.json", json_encode($userData, JSON_PRETTY_PRINT));
                $_SESSION['username'] = $newUsername; // Update session with new username
                $username = $newUsername; // Update local username variable
                $successMessage = 'Username successfully changed.';
            }
        }
    }

    // Change password 
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        // Check if JavaScript validation passed
        if ($_POST['validationPassed'] !== 'true') {
            $errorMessage = 'JavaScript validation failed. Please correct errors before submitting.';
        } else {
            $newPassword = $_POST['password'];

            // Ensure server-side validation as a backup
            if (strlen($newPassword) < 10) {
                $errorMessage = "Password must be at least 10 characters long.";
            } else {
                // Update the user's password
                $userData['password'] = password_hash($newPassword, PASSWORD_BCRYPT); // Hash the password for security
                file_put_contents($jsonFile, json_encode($userData, JSON_PRETTY_PRINT));
                $successMessage = "Password successfully updated!";
            }
        }
    }

    // Handle addresses
    if (isset($_POST['addressType']) && in_array($_POST['addressType'], ['billing', 'shipping'])) {
        $addressType = $_POST['addressType'];  // 'billing' or 'shipping'
        
        // Create address data from the form submission
        $address = [
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'street' => $_POST['street'],
            'houseNumber' => $_POST['houseNumber'],
            'additional' => $_POST['additional'],
            'city' => $_POST['city'],
            'postalCode' => $_POST['postalCode'],
            'country' => $_POST['country'],
        ];

        // Update the respective address
        if ($addressType === 'billing') {
            $addresses['billingAddress'] = $address;
        } 
        if ($addressType === 'shipping') {
            $addresses['shippingAddress'] = $address;
        }

        // Save the updated addresses to the JSON file
        $userData['address'] = $addresses;
        file_put_contents($jsonFile, json_encode($userData, JSON_PRETTY_PRINT));
    } 
    

    // Handle account deletion
    if (isset($_POST['deleteAccount'])) {
        // Delete the user's directory and all its contents
        $userDirectory = "users/$username";
        if (is_dir($userDirectory)) {
            // Delete the user folder and all its contents
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($userDirectory, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }
            rmdir($userDirectory); // Remove the now empty directory
        }

        // Redirect to the delete page
        header("Location: delete.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/customer.css">
    <script src="script/form-validation.js" defer></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h1>Profile</h1>
        <!-- <div class="box"> -->
        <fieldset class="box">
            <legend>User Information</legend>
            <table>
                <!-- Name -->
                <form id="nameForm" method="POST">
                    <tr>
                        <td class="table-header td1">Name</td>
                        <td class="nameOriginal td2">
                            <?php echo htmlspecialchars($firstName) . " " . htmlspecialchars($lastName); ?>
                        </td>
                        <td class="nameOriginal td3">
                            <button type="button" id="changeNameButton">Change</button>
                        </td>
                        <td class="nameEdit edit td2" id="nameInputs">
                            <input type="text" name="firstName" id="firstNameInput"
                                placeholder="<?php echo htmlspecialchars($firstName); ?>" required>
                            <input type="text" name="lastName" id="lastNameInput"
                                placeholder="<?php echo htmlspecialchars($lastName); ?>" required>
                        </td>
                        <td class="nameEdit edit td3">
                            <input type="submit" class="btn-blue" value="Save">
                        </td>
                    </tr>
                </form>
                <!-- Username -->
                <form id="usernameForm" method="POST">
                    <tr>
                        <td class="table-header td1">Username</td>
                        <td class="usernameOriginal td2">
                            <?php echo htmlspecialchars($username); ?>
                        </td>
                        <td class="usernameOriginal td3">
                            <button type="button" id="changeUsernameButton">Change</button>
                        </td>
                        <td class="usernameEdit edit td2">
                            <input type="text" name="username" id="uName"
                                placeholder="<?php echo htmlspecialchars($username); ?>" required>
                            <input type="hidden" name="validationPassed" id="usernameValidationPassed" value="false">
                        </td>
                        <td class="usernameEdit edit td3">
                            <input type="submit" class="btn-blue" value="Save">
                        </td>
                    </tr>
                </form>
                <!-- Password -->
                <form id="passwordForm" method="POST">
                    <tr>
                        <td class="table-header td1">Password</td>
                        <td class="passwordOriginal td2">
                            <?php echo str_repeat("*", 10); ?>
                        </td>
                        <td class="passwordOriginal td3">
                            <button type="button" id="changePasswordButton">Change</button>
                        </td>
                        <td class="passwordEdit edit td2">
                            <input type="password" name="password" id="password" placeholder="********" required>
                            <input type="hidden" name="validationPassed" id="passwordValidationPassed" value="false">
                        </td>
                        <td class="passwordEdit edit td3">
                            <input type="submit" class="btn-blue" value="Save">
                        </td>
                    </tr>
                </form>
            </table>

            <div class="message">
                <?php if (!empty($errorMessage)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>

                <?php if (!empty($successMessage)): ?>
                <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
                <?php endif; ?>

                <?php echo htmlspecialchars($firstNameLive); ?>
            </div>
        </fieldset>

        <!-- Address -->
        <fieldset class="box">
            <legend>Address</legend>
            <div class="container">
                <!-- Billing Address Section -->
                <div class="box">
                    <strong>Billing Address</strong>
                    <ddiv id="billingAddressDisplay">
                        <?php if ($addresses['billingAddress']): ?>
                        <div class="address-display">

                            <!-- Name -->
                            <p>
                                <strong>
                                    <?php echo htmlspecialchars($addresses['billingAddress']['firstName']) . " " . htmlspecialchars($addresses['billingAddress']['lastName']); ?>
                                </strong>
                            </p>
                            <!-- Street name and house number -->
                            <p>
                                <?php echo htmlspecialchars($addresses['billingAddress']['street']) . " " . htmlspecialchars($addresses['billingAddress']['houseNumber']); ?>
                            </p>
                            <!-- Additional address (optional) -->
                            <?php if (!empty($addresses['billingAddress']['additional'])): ?>
                            <p>
                                <?php echo htmlspecialchars($addresses['billingAddress']['additional']); ?>
                            </p>
                            <?php endif; ?>
                            <!-- City and postal code -->
                            <p>
                                <?php echo htmlspecialchars($addresses['billingAddress']['city']) . " " . htmlspecialchars($addresses['billingAddress']['postalCode']); ?>
                            </p>
                            <!-- Country -->
                            <p>
                                <?php echo htmlspecialchars($addresses['billingAddress']['country']); ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Buttons -->
                        <div class="button-php">
                            <?php if ($addresses['billingAddress']): ?>
                            <button type="button" id="billingAddressButton" class="btn-green">Edit Address</button>
                            <?php else: ?>
                            <button type="button" id="billingAddressButton" class="btn-blue">Add Address</button>
                            <?php endif; ?>
                        </div>
                    </ddiv>

                    <div id="billingAddressForm" style="display:none;">
                        <form id="billingAddressFormFields" method="POST">
                            <!-- Hidden input to specify the address type (billing) -->
                            <input type="hidden" name="addressType" value="billing">

                            <div class="form-group">
                                <label for="billingFirstName">First Name:</label>
                                <input type="text" id="billingFirstName" name="firstName" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['billingAddress']['firstName']) ? htmlspecialchars($addresses['billingAddress']['firstName']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingLastName">Last Name:</label>
                                <input type="text" id="billingLastName" name="lastName" placeholder="required" required
                                    value="<?php echo isset($addresses['billingAddress']['lastName']) ? htmlspecialchars($addresses['billingAddress']['lastName']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingStreet">Street Name:</label>
                                <input type="text" id="billingStreet" name="street" placeholder="required" required
                                    value="<?php echo isset($addresses['billingAddress']['street']) ? htmlspecialchars($addresses['billingAddress']['street']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingHouseNumber">House Number:</label>
                                <input type="text" id="billingHouseNumber" name="houseNumber" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['billingAddress']['houseNumber']) ? htmlspecialchars($addresses['billingAddress']['houseNumber']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingAdditional">Additional Address Line:</label>
                                <input type="text" id="billingAdditional" name="additional" placeholder="(optional)"
                                    value="<?php echo isset($addresses['billingAddress']['additional']) ? htmlspecialchars($addresses['billingAddress']['additional']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingCity">City:</label>
                                <input type="text" id="billingCity" name="city" placeholder="required" required
                                    value="<?php echo isset($addresses['billingAddress']['city']) ? htmlspecialchars($addresses['billingAddress']['city']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingPostalCode">Postal Code:</label>
                                <input type="text" id="billingPostalCode" name="postalCode" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['billingAddress']['postalCode']) ? htmlspecialchars($addresses['billingAddress']['postalCode']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingCountry">Country:</label>
                                <input type="text" id="billingCountry" name="country" placeholder="required" required
                                    value="<?php echo isset($addresses['billingAddress']['country']) ? htmlspecialchars($addresses['billingAddress']['country']) : ''; ?>">
                            </div>

                            <input type="submit" value="Save Address">
                        </form>
                    </div>
                </div>


                <!-- Shipping Address Section -->
                <div class="box">
                    <strong>Shipping Address</strong>
                    <ddiv id="shippingAddressDisplay">
                        <?php if ($addresses['shippingAddress']): ?>
                        <div class="address-display">
                            <!-- Name -->
                            <p>
                                <strong>
                                    <?php echo htmlspecialchars($addresses['shippingAddress']['firstName']) . " " . htmlspecialchars($addresses['shippingAddress']['lastName']); ?>
                                </strong>
                            </p>
                            <!-- Street name and house number -->
                            <p>
                                <?php echo htmlspecialchars($addresses['shippingAddress']['street']) . " " . htmlspecialchars($addresses['shippingAddress']['houseNumber']); ?>
                            </p>
                            <!-- Additional address (optional) -->
                            <?php if (!empty($addresses['shippingAddress']['additional'])): ?>
                            <p>
                                <?php echo htmlspecialchars($addresses['shippingAddress']['additional']); ?>
                            </p>
                            <?php endif; ?>
                            <!-- City and postal code -->
                            <p>
                                <?php echo htmlspecialchars($addresses['shippingAddress']['city']) . " " . htmlspecialchars($addresses['shippingAddress']['postalCode']); ?>
                            </p>
                            <!-- Country -->
                            <p>
                                <?php echo htmlspecialchars($addresses['shippingAddress']['country']); ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Buttons -->
                        <div class="button-php">
                            <?php if ($addresses['shippingAddress']): ?>
                            <button type="button" id="shippingAddressButton" class="btn-green">Edit Address</button>
                            <?php else: ?>
                            <button type="button" id="shippingAddressButton" class="btn-blue">Add Address</button>
                            <?php endif; ?>
                        </div>
                    </ddiv>

                    <div id="shippingAddressForm" style="display:none;">
                        <form id="shippingAddressFormFields" method="POST">
                            <!-- Hidden input to specify the address type (billing) -->
                            <input type="hidden" name="addressType" value="shipping">

                            <div class="form-group">
                                <label for="shippingFirstName">First Name:</label>
                                <input type="text" id="shippingFirstName" name="firstName" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['shippingAddress']['firstName']) ? htmlspecialchars($addresses['shippingAddress']['firstName']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingLastName">Last Name:</label>
                                <input type="text" id="shippingLastName" name="lastName" placeholder="required" required
                                    value="<?php echo isset($addresses['shippingAddress']['lastName']) ? htmlspecialchars($addresses['shippingAddress']['lastName']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingStreet">Street Name:</label>
                                <input type="text" id="shippingStreet" name="street" placeholder="required" required
                                    value="<?php echo isset($addresses['shippingAddress']['street']) ? htmlspecialchars($addresses['shippingAddress']['street']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingHouseNumber">House Number:</label>
                                <input type="text" id="shippingHouseNumber" name="houseNumber" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['shippingAddress']['houseNumber']) ? htmlspecialchars($addresses['shippingAddress']['houseNumber']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingAdditional">Additional Address Line:</label>
                                <input type="text" id="shippingAdditional" name="additional" placeholder="(optional)"
                                    value="<?php echo isset($addresses['shippingAddress']['additional']) ? htmlspecialchars($addresses['shippingAddress']['additional']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="billingCity">City:</label>
                                <input type="text" id="billingCity" name="city" placeholder="required" required
                                    value="<?php echo isset($addresses['shippingAddress']['city']) ? htmlspecialchars($addresses['shippingAddress']['city']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingPostalCode">Postal Code:</label>
                                <input type="text" id="shippingPostalCode" name="postalCode" placeholder="required"
                                    required
                                    value="<?php echo isset($addresses['shippingAddress']['postalCode']) ? htmlspecialchars($addresses['shippingAddress']['postalCode']) : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="shippingCountry">Country:</label>
                                <input type="text" id="shippingCountry" name="country" placeholder="required" required
                                    value="<?php echo isset($addresses['shippingAddress']['country']) ? htmlspecialchars($addresses['shippingAddress']['country']) : ''; ?>">
                            </div>

                            <input type="submit" value="Save Address">
                        </form>
                    </div>
                </div>

            </div>
        </fieldset>


        <!-- Delete Account -->
        <form action="" method="POST">
            <button type="submit" name="deleteAccount" class="btn-red">Delete Account</button>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>