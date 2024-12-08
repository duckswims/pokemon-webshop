<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in by checking if the username is set in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Retrieve the username from the session
} else {
    $username = null; // User is not logged in
}

// Destroy all session variables
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store</title>
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
        <?php include ("header.php"); ?>
    </header>

    <main>
        <h1>Sorry to see you go :(</h1>
        <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/dcb3f1a2-7821-444b-8ca8-91b482d4935d/dhwwbhn-b7dc1906-550e-4b1d-925f-40c3d2cb4427.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2RjYjNmMWEyLTc4MjEtNDQ0Yi04Y2E4LTkxYjQ4MmQ0OTM1ZFwvZGh3d2Jobi1iN2RjMTkwNi01NTBlLTRiMWQtOTI1Zi00MGMzZDJjYjQ0MjcucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0._I0cHaa2UQyNoquy8w910S73j8nwpIOYfJ87tRY9nuk"
            alt="" width="300px">
        <p>Your account information has been deleted.</p>
    </main>

    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>