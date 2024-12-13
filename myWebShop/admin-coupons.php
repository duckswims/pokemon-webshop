<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: error.php?error=" . urlencode("You must be logged in as an admin to access this page."));
    exit();
}

// Load coupon data from json/coupon.json
$couponData = json_decode(file_get_contents("json/coupon.json"), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading coupon data.</p>";
    exit;
}

// Get the list of all coupons
$allCoupons = $couponData;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupons</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/coupons.css">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <h1>Coupons</h1>

        <div class="coupon-list container">
            <?php foreach ($allCoupons as $coupon) { ?>
            <div class="coupon-item box">
                <p><strong>Code:</strong> <?php echo htmlspecialchars($coupon['code']); ?></p>
                <p>
                    <strong>Discount:</strong>
                    <?php 
                    if (isset($coupon['percentage'])) {
                        echo htmlspecialchars($coupon['percentage']*100) . "% off";
                    } elseif (isset($coupon['value'])) {
                        echo htmlspecialchars($coupon['value']) . "€";
                    }
                    ?>
                </p>
                <p>
                    <strong>Expiration Date:</strong>
                    <?php 
                    echo isset($coupon['expiration_date']) ? htmlspecialchars($coupon['expiration_date']) : "None";
                    ?>
                </p>
                <!-- Status and validity button -->
                <p>
                    <strong>Status:</strong>
                    <?php 
                    echo $coupon['valid'] ? "Valid" : "Invalid";
                    ?>
                </p>
                <?php 
                if (isset($coupon['valid']) && $coupon['valid']) {
                ?>
                <form method="POST">
                    <input type="hidden" name="coupon_code" value="<?php echo htmlspecialchars($coupon['code']); ?>">
                    <button type="submit" class="btn-red">Invalidate</button>
                </form>
                <?php } else { ?>
                <form method="POST">
                    <input type="hidden" name="coupon_code" value="<?php echo htmlspecialchars($coupon['code']); ?>">
                    <button type="submit" class="btn-green">Validate</button>
                </form>
                <?php
                }
                ?>
                </p>
            </div>
            <?php } ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>