<?php require_once('../inc/header.php'); ?>

<?php
$cart = $_SESSION['cart'] ?? [];
$totalPrice = 0;
?>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Your Cart</h1>
            <p class="lead fw-normal text-white-50 mb-0">Review and manage your items</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">

        <?php if (empty($cart)) : ?>

            <h3 class="text-center">Your cart is empty</h3>

        <?php else : ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cart as $index => $item) : 
                        $name = htmlspecialchars($item['name']);
                        $price = (float)$item['price'];
                        $qty = 1; 
                        $itemTotal = $price * $qty;
                        $totalPrice += $itemTotal;
                    ?>
                        <tr>
                            <th><?= $index + 1 ?></th>

                            <td>
                                <?= $name ?>
                            </td>

                            <td>$<?= number_format($price, 2) ?></td>

                            <td>
                                <input type="number" class="form-control" value="<?= $qty ?>" min="1" disabled>
                            </td>

                            <td>$<?= number_format($itemTotal, 2) ?></td>

                            <td>
                            <a href="../handlers/delete_item.php?index=<?= $index ?>" class="btn btn-danger btn-sm">
                            Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="2">Total Price</td>
                        <td colspan="3">
                            <h3>$<?= number_format($totalPrice, 2) ?></h3>
                        </td>
                        <td>
                            <a href="checkout.php" class="btn btn-primary">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>

        <?php endif; ?>

    </div>
</section>

<?php require_once('../inc/footer.php'); ?>
