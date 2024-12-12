<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;

// If the user is not logged in or not an admin, redirect to error.php
if (!$admin) {
    // Redirect to error page with a query parameter for the error message
    header("Location: error.php?error=You must be logged in as an admin to access this page.");
    exit();
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
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <main>
        <h1>User Control</h1>

        <?php
        // Get the list of usernames (directories) if admin
        $directory = "users"; // Replace with actual path

        // Get the list of directories (usernames)
        $usernames = array_filter(scandir($directory), function ($item) use ($directory) {
            return is_dir($directory . '/' . $item) && $item !== '.' && $item !== '..';
        });

        if (count($usernames) > 0) {
            echo "<h2>User List:</h2>";
            echo "<table border='1'>
                    <thead>
                        <tr>
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
                    
                    // Default admin status is false
                    $isAdmin = isset($info['admin']) && $info['admin'] === true;
                } else {
                    // If no info.json is found, assume the user is not an admin
                    $isAdmin = false;
                }

                echo "<tr>
                        <td>" . htmlspecialchars($username) . "</td>
                        <td><input type='checkbox' " . ($isAdmin ? 'checked' : '') . " disabled></td>
                        <td><button class='btn-red' onclick='blockUser(\"" . htmlspecialchars($username) . "\")'>Block</button></td>
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

    <script>
    // Block user function (you can expand this to implement real functionality)
    function blockUser(username) {
        if (confirm("Are you sure you want to block " + username + "?")) {
            // Add code here to block the user (e.g., make an AJAX call or redirect to block action)
            alert(username + " has been blocked.");
        }
    }
    </script>
</body>

</html>