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

// Update coupon validity if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coupon_code'])) {
    $couponCode = $_POST['coupon_code'];
    
    // Find and toggle the 'valid' field without affecting the order
    foreach ($couponData['coupons'] as &$coupon) {
        if ($coupon['code'] === $couponCode) {
            // Flip the current validity status
            $coupon['valid'] = !$coupon['valid'];  // Toggle the 'valid' field
            // break;
        }
    }

    // Save the updated data back to the JSON file
    file_put_contents('json/coupon.json', json_encode($couponData, JSON_PRETTY_PRINT));
}

// Sort the coupons by 'code' in alphabetical order
usort($couponData['coupons'], function($a, $b) {
    return strcmp($a['code'], $b['code']);
});

// Get the list of all coupons
$allCoupons = $couponData['coupons'];
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
                    // Accessing the 'discount' field
                    if (isset($coupon['discount']['type'])) {
                        if ($coupon['discount']['type'] === 'percentage') {
                            echo htmlspecialchars($coupon['discount']['value']) . "% off";
                        } elseif ($coupon['discount']['type'] === 'value') {
                            echo htmlspecialchars($coupon['discount']['value']) . "€";
                        } else {
                            echo "No discount";
                        }
                    }
                    ?>
                </p>
                <p>
                    <strong>Status:</strong>
                    <?php 
                    echo '<span style="color: ' . ($coupon['valid'] ? 'green' : 'red') . ';">' . ($coupon['valid'] ? "Valid" : "Invalid") . '</span>';
                    ?>
                </p>
                <br>
                <!-- Form to update coupon validity -->
                <form method="POST">
                    <input type="hidden" name="coupon_code" value="<?php echo htmlspecialchars($coupon['code']); ?>">
                    <?php if ($coupon['valid']) { ?>
                    <button type="submit" class="btn-red">Invalidate</button>
                    <?php } else { ?>
                    <button type="submit" class="btn-green">Validate</button>
                    <?php } ?>
                </form>
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