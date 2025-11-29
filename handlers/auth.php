<?php
session_start();
require_once __DIR__ . '/../core/functions.php';

$action = $_POST['action'] ?? '';

if ($action === 'register') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $_SESSION['error'] = 'Invalid input. Password must be at least 6 characters.';
        header('Location: ../views/register.php');
        exit;
    }

    if (findUserByEmail($email)) {
        $_SESSION['error'] = 'This email is already registered.';
        header('Location: ../views/register.php');
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $users = readUsers();

    $users[] = [
        'name' => $name,
        'email' => $email,
        'password' => $hash
    ];

    saveUsers($users);

    $_SESSION['user'] = ['name' => $name, 'email' => $email];
    header('Location: ../views/home.php');
    exit;
}

if ($action === 'login') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = findUserByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Incorrect login credentials.';
        header('Location: ../views/login.php');
        exit;
    }

    $_SESSION['user'] = ['name' => $user['name'], 'email' => $user['email']];
    header('Location: ../views/home.php');
    exit;
}

header('Location: ../views/.php');
exit;
