<?php include 'templates/header.php'; ?> 
<div class="text-center">
    <h1>Welcome to Summer 21</h1>
    <p>Your destination for premium lip care and beauty products.</p>
    <a href="shop.php" class="btn btn-custom btn-lg">Shop Now</a>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <img src="images/colorful-lip-gloss-shades-arrangement.jpg" alt="Lip Gloss Collection" class="img-fluid rounded">
    </div>
    <div class="col-md-6">
        <h2>Why Choose Us?</h2>
        <ul>
            <li>High-quality, cruelty-free products</li>
            <li>Wide range of colors and finishes</li>
            <li>Affordable prices</li>
        </ul>
        <p>At Summer 21, we believe in empowering individuals to express themselves with confidence. Our lip products are crafted with love and designed to shine.</p>
    </div>
</div>

<div class="mt-5 text-center">
    <h2>Featured Products</h2>
</div>

<div class="row mt-4">
    <?php
    require 'includes/db.php';
    $stmt = $conn->query("SELECT * FROM products LIMIT 3");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?= $product['image_url'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong>$<?= $product['price'] ?></strong></p>
                    <a href="#" class="btn btn-custom">Buy Now</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Lip Scrubs Section -->
<div class="mt-5 text-center">
    <h2>Lip Scrubs</h2>
    <p>Gently exfoliate your lips with our nourishing lip scrubs, leaving them soft and smooth.</p>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <img src="https://m.media-amazon.com/images/I/812u9ugj4RL._SL1500_.jpg" alt="Lip Scrub" class="img-fluid rounded">
    </div>
    <div class="col-md-6">
        <h3>Why Use a Lip Scrub?</h3>
        <ul>
            <li>Removes dry, flaky skin</li>
            <li>Enhances lip hydration</li>
            <li>Prepares lips for smooth lipstick application</li>
        </ul>
        <p>Our lip scrubs are made with natural ingredients like sugar, honey, and essential oils to keep your lips healthy and hydrated.</p>
    </div>
</div>

<!-- Lip Masks Section -->
<div class="mt-5 text-center">
    <h2>Lip Masks</h2>
    <p>Hydrate and repair your lips overnight with our ultra-moisturizing lip masks.</p>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <h3>Benefits of Lip Masks</h3>
        <ul>
            <li>Deeply nourishes and repairs dry lips</li>
            <li>Locks in moisture overnight</li>
            <li>Leaves lips feeling soft and plump</li>
        </ul>
        <p>Infused with natural butters and essential oils, our lip masks provide intense hydration for a perfect pout.</p>
    </div>
    <div class="col-md-6">
        <img src="https://m.media-amazon.com/images/I/61zu2FHiygL._SL1000_.jpg" alt="Lip Mask" class="img-fluid rounded">
    </div>
</div>

<?php include 'templates/footer.php'; ?>
