<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You've Been Blocked!</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background-color: #222; /* Ensure background color fills the screen */
        }

        #blocked-page {
            font-family: 'Rubik', Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            flex-direction: column;
            
        }

        #blocked-page .container {
            max-width: 600px;
        }

        #blocked-page h1 {
            font-size: 1.8rem; /* Slightly smaller heading size */
            margin: 0px; /* Reduce spacing below the heading */
        }

        #blocked-page p {
            font-size: 1rem;
            margin: 0; /* Remove default margins */
            line-height: 1.5; /* Adjust line spacing for readability */
        }

        #blocked-page .countdown {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>

</head>
<body>
    <div class="container" id="blocked-page">
        <h1>Oops! You've been blocked for 24 hours!</h1>
        <p>Don’t worry, Gengar is keeping an eye on you. You can return when the countdown ends!</p>
        <div class="countdown" id="countdown">Loading...</div>
        <div class="image">
            <img src="img/Gengar.png" alt="Gengar">
        </div>
        
    </div>

    <script>
        function startCountdown(durationInSeconds) {
            const countdownElement = document.getElementById('countdown');
            let remainingTime = durationInSeconds;

            function updateCountdown() {
                const hours = Math.floor(remainingTime / 3600);
                const minutes = Math.floor((remainingTime % 3600) / 60);
                const seconds = remainingTime % 60;

                countdownElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

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