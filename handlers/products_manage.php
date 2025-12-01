<?php
session_start();

$action = $_POST['action'] ?? '';

/* =========================================
   CREATE PRODUCT
========================================= */
if ($action === 'create') {

    $name  = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? 0;
    $image = $_FILES['image'] ?? '';

    $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $newName = uniqid("product_", true) . "." . $ext;
    $uploadPath = __DIR__ . '/../uploads/' . $newName;

    if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
        $_SESSION['error'] = "Failed to upload image.";
        header("Location: ../views/manage-product.php");
        exit;
    }

    $products = readProducts();

    $products[] = [
        'id'    => uniqid(),
        'name'  => $name,
        'price' => $price,
        'image' => $newName
    ];

    saveProducts($products);

    $_SESSION['success'] = "Product created successfully!";
    header("Location: ../views/manage-product.php");
    exit;
}




/* =========================================
   UPDATE PRODUCT
========================================= */
elseif ($action === 'update') {

    $id    = $_POST['id'] ?? '';
    $name  = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($id === '' || $name === '' || $price === '') {
        $_SESSION['error'] = "All fields are required!";
        header("Location: ../views/manage-product.php");
        exit;
    }

    $products = readProducts();
    $found = false;

    foreach ($products as &$product) {
        if ($product['id'] === $id) {

            $product['name']  = $name;
            $product['price'] = $price;

            if ($image && $image['error'] === 0) {

                $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                $allowed_ext = ['jpg', 'jpeg', 'png'];

                if (in_array($ext, $allowed_ext)) {

                    $newName = uniqid("product_", true) . "." . $ext;
                    $uploadPath = __DIR__ . '/../uploads/' . $newName;

                    if (move_uploaded_file($image['tmp_name'], $uploadPath)) {

                        if (file_exists(__DIR__ . '/../uploads/' . $product['image'])) {
                            unlink(__DIR__ . '/../uploads/' . $product['image']);
                        }

                        $product['image'] = $newName;
                    }
                }
            }

            $found = true;
            break;
        }
    }

    if ($found) {
        saveProducts($products);
        $_SESSION['success'] = "Product updated successfully!";
    } else {
        $_SESSION['error'] = "Product not found!";
    }

    header("Location: ../views/manage-product.php");
    exit;
}




/* =======================DELETE PRODUCT========================================= */
elseif ($action === 'delete') {

    $id = $_POST['id'] ?? '';

    if ($id === '') {
        $_SESSION['error'] = "Invalid product ID!";
        header("Location: ../views/manage-product.php");
        exit;
    }

    $products = readProducts();
    $updatedProducts = [];

    $deleted = false;

    foreach ($products as $product) {
        if ($product['id'] === $id) {
            $imgPath = __DIR__ . '/../uploads/' . $product['image'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
            $deleted = true;
            continue; 
        }

        $updatedProducts[] = $product;
    }

    if ($deleted) {
        saveProducts($updatedProducts);
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Product not found!";
    }

    header("Location: ../views/manage-product.php");
    exit;
}





/* =========================================
   HELPERS (read + save)
========================================= */
function getProductsFile() {
    return __DIR__ . '/../data/products.json';
}

function readProducts() {
    $path = getProductsFile();

    if (!file_exists($path)) {
        return [];
    }

    $json = file_get_contents($path);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function saveProducts(array $products) {
    $path = getProductsFile();
    $dir = dirname($path);

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $json = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($path, $json, LOCK_EX);
}

?>
