<?php require_once('../inc/header.php'); ?>
<?php $cart = $_SESSION['cart'] ?? [];
$totalPrice = 0; ?>
<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shop in style</h1>
            <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-4">
                <div class="border p-2">
                    <div class="products">
                        <ul class="list-unstyled">

                            <?php
                            foreach ($cart as $index => $item) :
                                $name  = htmlspecialchars($item['name']);
                                $price = (float) $item['price'];
                                $qty   = isset($item['qty']) ? (int)$item['qty'] : 1; // default 1
                                $itemTotal = $price * $qty;
                                $totalPrice += $itemTotal;
                            ?>

                                <li class="border p-2 my-1 d-flex justify-content-between">
                                    <span><?= $name ?></span>
                                    <span class="text-success bold">
                                        <?= $qty ?> x <?= $price ?>$
                                    </span>
                                </li>

                            <?php endforeach; ?>

                        </ul>
                    </div>

                    <h3>Total : <?= $totalPrice ?> $</h3>
                </div>

            </div>
            <div class="col-8">
                <form action="../handlers/save_order.php" method="POST" class="form border my-2 p-3">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Address</label>
                            <input type="text" name="address" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Phone</label>
                            <input type="number" name="phone" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="">Notes</label>
                            <input type="text" name="notes" id="" class="form-control">
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Send" id="" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once('../inc/footer.php'); ?>