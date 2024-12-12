<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You've Been Blocked!</title>
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/blocked.css">
</head>

<body>
    <div class="container" id="blocked-page">
        <h1>Oops! You've been blocked for 24 hours!</h1>
        <p>Don't worry, Gengar is keeping an eye on you. You can return when the countdown ends!</p>
        <div class="countdown" id="countdown">Loading...</div>
        <div class="image">
            <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/094.png" alt="Gengar">
        </div>

        <!-- Button to redirect to contact-form.php -->
        <form action="contact-form.php" method="get">
            <button type="submit" class="btn-red">Contact Us</button>
        </form>
    </div>

    <script>
    function startCountdown(durationInSeconds) {
        const countdownElement = document.getElementById('countdown');
        let remainingTime = durationInSeconds;

        function updateCountdown() {
            const hours = Math.floor(remainingTime / 3600);
            const minutes = Math.floor((remainingTime % 3600) / 60);
            const seconds = remainingTime % 60;

            countdownElement.textContent =
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (remainingTime > 0) {
                remainingTime--;
            } else {
                countdownElement.textContent = "Time's up! You can now return!";
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // Start the countdown for 24 hours
    startCountdown(24 * 60 * 60);
    </script>
    <!-- Footer -->
    <footer>
        <?php include ("footer.php"); ?>
    </footer>
</body>

</html>