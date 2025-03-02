<?php include 'templates/header.php'; ?>

<!-- Hero Section -->
<div class="text-center" style="margin-top: 50px;">
    <h1 style="font-size: 48px; color: #ff69b4;">Welcome to Summer 21</h1>
    <p style="font-size: 20px; color: #666;">Your destination for premium lip care and beauty products.</p>
    <a href="shop.php" class="btn btn-custom btn-lg" style="background-color: #ff69b4; color: white; padding: 15px 30px; border-radius: 5px; font-size: 18px; text-decoration: none; margin-top: 20px;">
        Shop Now <i class="fas fa-arrow-right"></i>
    </a>
</div>

<!-- Lip Gloss Collection -->
<div class="row mt-5" style="display: flex; align-items: center;">
    <div class="col-md-6">
        <img src="images/colorful-lip-gloss-shades-arrangement.jpg" alt="Lip Gloss Collection" class="img-fluid rounded" style="max-width: 100%; height: auto; border: 2px solid #ff69b4; border-radius: 10px;">
    </div>
    <div class="col-md-6" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #ff69b4; margin-bottom: 20px;">Why Choose Us?</h2>
        <ul style="list-style-type: disc; padding-left: 20px; color: #333;">
            <li>High-quality, cruelty-free products</li>
            <li>Wide range of colors and finishes</li>
            <li>Affordable prices</li>
        </ul>
        <p style="font-size: 16px; color: #666; line-height: 1.6;">
            At Summer 21, we believe in empowering individuals to express themselves with confidence. Our lip products are crafted with love and designed to shine.
        </p>
    </div>
</div>

<!-- Featured Products -->
<div class="mt-5 text-center" style="margin-top: 50px;">
    <h2 style="color: #ff69b4; font-size: 36px; margin-bottom: 20px;">Featured Products</h2>
</div>
<div class="row mt-4" style="justify-content: center;">
    <?php
    require 'includes/db.php';
    $stmt = $conn->query("SELECT * FROM products LIMIT 3");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product): ?>
        <div class="col-md-4 mb-4" style="max-width: 350px; margin: 0 auto;">
            <div class="card" style="border: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 10px; overflow: hidden;">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="card-img-top" style="max-width: 100%; max-height: 250px; object-fit: cover;">
                <div class="card-body" style="padding: 20px; background-color: #fff; text-align: center;">
                    <h5 class="card-title" style="font-size: 20px; color: #333; margin-bottom: 10px;"><?= htmlspecialchars($product['name']) ?></h5>
                    <p class="card-text" style="font-size: 14px; color: #666; margin-bottom: 10px;"><?= htmlspecialchars($product['description']) ?></p>
                    <p class="card-text" style="font-size: 18px; color: #ff69b4; font-weight: bold; margin-bottom: 20px;">$<?= number_format((float)$product['price'], 2) ?></p>
                    <a href="#" class="btn btn-custom" style="background-color: #ff69b4; color: white; padding: 10px 20px; border-radius: 5px; font-size: 16px; text-decoration: none; transition: background-color 0.3s;">
                        Buy Now <i class="fas fa-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Lip Scrubs Section -->
<div class="mt-5 text-center" style="margin-top: 50px;">
    <h2 style="color: #ff69b4; font-size: 36px; margin-bottom: 20px;">Lip Scrubs</h2>
    <p style="font-size: 18px; color: #666; margin-bottom: 20px;">Gently exfoliate your lips with our nourishing lip scrubs, leaving them soft and smooth.</p>
</div>
<div class="row mt-4" style="display: flex; align-items: center;">
    <div class="col-md-6" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <img src="https://m.media-amazon.com/images/I/812u9ugj4RL._SL1500_.jpg" alt="Lip Scrub" class="img-fluid rounded" style="max-width: 100%; max-height: 300px; object-fit: cover; border: 2px solid #ff69b4; border-radius: 10px;">
    </div>
    <div class="col-md-6" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #ff69b4; font-size: 24px; margin-bottom: 20px;">Why Use a Lip Scrub?</h3>
        <ul style="list-style-type: disc; padding-left: 20px; color: #333;">
            <li>Removes dry, flaky skin</li>
            <li>Enhances lip hydration</li>
            <li>Prepares lips for smooth lipstick application</li>
        </ul>
        <p style="font-size: 16px; color: #666; line-height: 1.6;">
            Our lip scrubs are made with natural ingredients like sugar, honey, and essential oils to keep your lips healthy and hydrated.
        </p>
    </div>
</div>

<!-- Lip Masks Section -->
<div class="mt-5 text-center" style="margin-top: 50px;">
    <h2 style="color: #ff69b4; font-size: 36px; margin-bottom: 20px;">Lip Masks</h2>
    <p style="font-size: 18px; color: #666; margin-bottom: 20px;">Hydrate and repair your lips overnight with our ultra-moisturizing lip masks.</p>
</div>
<div class="row mt-4" style="display: flex; align-items: center;">
    <div class="col-md-6" style="padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #ff69b4; font-size: 24px; margin-bottom: 20px;">Benefits of Lip Masks</h3>
        <ul style="list-style-type: disc; padding-left: 20px; color: #333;">
            <li>Deeply nourishes and repairs dry lips</li>
            <li>Locks in moisture overnight</li>
            <li>Leaves lips feeling soft and plump</li>
        </ul>
        <p style="font-size: 16px; color: #666; line-height: 1.6;">
            Infused with natural butters and essential oils, our lip masks provide intense hydration for a perfect pout.
        </p>
    </div>
    <div class="col-md-6" style="padding: 20px;">
        <img src="https://m.media-amazon.com/images/I/61zu2FHiygL._SL1000_.jpg" alt="Lip Mask" class="img-fluid rounded" style="max-width: 100%; max-height: 300px; object-fit: cover; border: 2px solid #ff69b4; border-radius: 10px;">
    </div>
</div>
<?php include 'templates/footer.php'; ?>