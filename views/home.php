<?php require_once('../inc/header.php'); ?>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop homepage</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            $productsFile = __DIR__ . '/../data/products.json';
            $products = [];

            if (file_exists($productsFile)) {
                $json = file_get_contents($productsFile);
                $products = json_decode($json, true);
            }

            if (!empty($products)) {
                foreach ($products as $product) {

                    // Safe values
                    $name  = htmlspecialchars($product['name']);
                    $price = htmlspecialchars($product['price']);
                    $image = !empty($product['image']) ? '../uploads/' . $product['image'] : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
            ?>

                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image -->
                            <img class="card-img-top" src="<?= $image ?>" alt="<?= $name ?>" />

                            <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name -->
                                    <h5 class="fw-bolder"><?= $name ?></h5>

                                    <!-- Product price -->
                                    $<?= $price ?>
                                </div>
                            </div>

                            <!-- Product actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <form method="POST" action="../handlers/add_to_cart.php">
                                        <input type="hidden" name="name" value="<?= $name ?>">
                                        <input type="hidden" name="price" value="<?= $price ?>">
                                        <input type="hidden" name="image" value="<?= $product['image'] ?>">

                                        <button class="btn btn-outline-dark mt-auto" type="submit">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<p class='text-center'>No products found.</p>";
            }
            ?>

        </div>
    </div>
</section>

<?php require_once('../inc/footer.php'); ?>