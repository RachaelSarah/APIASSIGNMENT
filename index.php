<?php include 'templates/header.php'; ?>

<div style="background-image: url('https://www.freepik.com/free-photo/flat-lay-colorful-lip-gloss-shades_31589881.htm#fromView=keyword&page=1&position=9&uuid=1ad48937-ac94-4d44-83e4-897ef3743912&new_detail=true&query=Lip+Gloss+Background'); background-size: cover; background-position: center; padding: 50px; color: white;">
    <div class="text-center">
        <h1>Welcome to Summer 21</h1>
        <p>Your destination for premium lip gloss products.</p>
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
            <p>At Summer 21, we believe in empowering individuals to express themselves with confidence. Our lip glosses are crafted with love and designed to shine.</p>
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
</div>

<?php include 'templates/footer.php'; ?>
