<?php
session_start();

$name  = $_POST['name'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_POST['image'] ?? '';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = [
    "name"  => $name,
    "price" => $price,
    "image" => $image
];

header("Location: ../views/home.php");
    exit;
