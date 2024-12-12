<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;

// If the user is not logged in or not an admin, display an error
if (!$admin) {
    echo "You must be logged in as an admin to access this page.";
    exit();
}

// Handle the POST request to update the admin status or block/unblock a user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $adminStatus = isset($_POST['admin']) ? $_POST['admin'] : 'false';
    $blockedStatus = isset($_POST['blocked']) ? $_POST['blocked'] : 'false';

    // Validate the username and action (either admin status update or block/unblock)
    if (!empty($username)) {
        $directory = "users"; // Replace with actual path
        $infoFilePath = $directory . '/' . $username . '/info.json';

        // Check if info.json exists and update accordingly
        if (file_exists($infoFilePath)) {
            $info = json_decode(file_get_contents($infoFilePath), true);
            
            // If updating admin status
            if (isset($_POST['admin'])) {
                $info['admin'] = ($adminStatus === 'true');
            }
            
            // If blocking/unblocking a user
            if (isset($_POST['blocked'])) {
                $info['blocked'] = ($blockedStatus === 'true');
            }

            // Save the updated information back to the file
            file_put_contents($infoFilePath, json_encode($info, JSON_PRETTY_PRINT));
        } else {
            echo '<div>User not found.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <script src="script/admin-users.js"></script>
    <style>
    .input-cell {
        align-items: center;
        justify-content: center;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h1>User List</h1>

        <?php
        // Get the list of usernames (directories) if admin
        $directory = "users"; // Replace with actual path

        // Get the list of directories (usernames)
        $usernames = array_filter(scandir($directory), function ($item) use ($directory) {
            return is_dir($directory . '/' . $item) && $item !== '.' && $item !== '..';
        });

        if (count($usernames) > 0) {
            echo "<table border='1'>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Admin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

            foreach ($usernames as $username) {
                $infoFilePath = $directory . '/' . $username . '/info.json';

                // Check if info.json exists and read it
                if (file_exists($infoFilePath)) {
                    $info = json_decode(file_get_contents($infoFilePath), true);
                    
                    // Extract first name, last name, admin status, and blocked status
                    $firstName = isset($info['firstName']) ? $info['firstName'] : 'N/A';
                    $lastName = isset($info['lastName']) ? $info['lastName'] : 'N/A';
                    $isAdmin = isset($info['admin']) && $info['admin'] === true;
                    $isBlocked = isset($info['blocked']) ? $info['blocked'] : false;
                } else {
                    // If no info.json is found, assume the user is not an admin
                    $firstName = 'N/A';
                    $lastName = 'N/A';
                    $isAdmin = false;
                    $isBlocked = false;
                }

                // Check if the logged-in user is the same as the current username
                $isCurrentUser = ($_SESSION['username'] === $username);

                echo "<tr>
                    <td>" . htmlspecialchars($firstName) . " " . htmlspecialchars($lastName) . "</td>
                    <td>" . htmlspecialchars($username) . "</td>
                    <td class='checkbox-cell input-cell'>
                        <input 
                            type='checkbox' 
                            " . ($isAdmin ? 'checked' : '') . " 
                            " . ($isCurrentUser ? 'disabled' : '') . " 
                            onclick='toggleAdmin(\"" . htmlspecialchars($username) . "\", this)'>
                    </td>
                    <td class='table-cell input-cell'>
                        <form method='POST'>
                            <input type='hidden' name='username' value='" . htmlspecialchars($username) . "'>
                            <input type='hidden' name='blocked' value='" . ($isBlocked ? 'false' : 'true') . "'>
                            <button type='submit' class='btn-red'>" . ($isBlocked ? 'Unblock User' : 'Block User') . "</button>
                        </form>
                    </td>
                </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

</body>

</html>