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
$jsonFile = "users/$username/info.json";

// Check if the JSON file exists for the logged-in user
if (!file_exists($jsonFile)) {
    die('User data not found.');
}

// Retrieve user data from the JSON file
$userData = json_decode(file_get_contents($jsonFile), true);
$firstName = $userData['firstName'] ?? 'N/A';
$lastName = $userData['lastName'] ?? 'N/A';

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
            </div>
        </fieldset>

        <!-- Address -->
        <fieldset class='box'>
            <legend>Address</legend>
            <div class="container">
                <div class="box">
                    <strong>Billing Address</strong>
                </div>
                <div class="box">
                    <strong>Shipping Address</strong>
                </div>
            </div>
        </fieldset>
        <br>

        <!-- Delete Account -->
        <form action="delete.php" method="POST">
            <button type="submit" name="deleteAccount" class="btn-red">Delete Account</button>
        </form>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>