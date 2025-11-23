<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion - Root Flower</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
 <?php include("navigation.php"); ?>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="promotion-page">
                <h1 id="title-1">&#x1F338;Special Promotions </h1>
                <p>Fresh Flowers, Fresh Deals, Just For You!</p>
            </div>
        <hr>

        <!--offers section-->
        <section class="promo-offers" id="promo-offers">
            <div class="offer-card">
                <img src="images/promotion2.jpg" alt="Mother's Day Promotion">
                <h2>Mother's Day Promotion</h2>
                <p><strong>10% off</strong> for early birds before 30 Apirl 2023.</p>
                <a href="product-selection.php" class="btn">Shop Now</a>
            </div>

            <div class="offer-card">
                <img src="images/promotion3.jpg" alt="Valentine's Day Promotion">
                <h2>Valentine's Day Promotion</h2>
                <p><strong>14% off</strong> for early birds order before 30 Jan 2023.</p>
                <a href="product-selection.php" class="btn">Shop Now</a>
            </div>

            <div class="offer-card">
                <img src="images/promotion1.jpg"  alt="Christmas Giveaway">
                <h2>Special Christmas Giveaway</h2>
                <p>3 Lucky Winners for Christmas Floral Workshop.</p>
                <a href="product-selection.php" class="btn">Shop Now</a>  
            </div>
        </section>

        

        <div class="promotion-section" id="promotion-section">
            <h2 class="section-title">How to Get This Promotion</h2>
            <ol class="ordered-list">
                <li><strong>Sign Up for Our <a href="registration.php" target="_blank">Membership</a></strong> - Create a membership to receive exclusive offers and update.</li>
                <li><strong>Visit Our Store</strong> - Come to our physical location or browse our online store to find products you love.</li>
                <li><strong>Add Items to Your Cart</strong> - Select items you want and add them to your shopping cart.</li>
                <li><strong>Complete Your Purchase</strong> - Finalize your order and enjoy your ssavings with our special promotion!</li>
            </ol>       
        </div>

            <div class="ShopNow">
                <a class="info-button" href="product-selection.php">Shop Now</a>
            </div>
        </div>

    </main>

<?php include("footer.php"); ?>