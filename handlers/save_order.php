<?php
session_start();

require_once __DIR__ . '/../core/functions.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    $_SESSION['error'] = "Your cart is empty!";
    header("Location: ../views/checkout.php");
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$notes = trim($_POST['notes'] ?? '');

if ($name === '' || $email === '' || $address === '' || $phone === '') {
    $_SESSION['error'] = "All fields are required!";
    header("Location: ../views/checkout.php");
    exit;
}

$orders = readOrders();

$order = [
    'id' => uniqid(),
    'name' => $name,
    'email' => $email,
    'address' => $address,
    'phone' => $phone,
    'notes' => $notes,
    'cart' => $cart,
    'created_at' => date('Y-m-d H:i:s')
];

$orders[] = $order;

saveOrders($orders);
unset($_SESSION['cart']);

$_SESSION['success'] = "Your order has been placed successfully!";
header("Location: ../views/checkout.php");
exit;


// Helpers 

function readOrders()
{
    $path = getOrdersFile();
    if (!file_exists($path)) return [];
    
    $json = file_get_contents($path);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function getOrdersFile()
{
    return __DIR__ . '/../data/orders.json';
}

function saveOrders(array $orders)
{
    $path = getOrdersFile();
    $dir = dirname($path);

    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $json = json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    file_put_contents($path, $json, LOCK_EX);
}
