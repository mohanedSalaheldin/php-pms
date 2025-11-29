<?php
session_start();
require_once __DIR__ . '/../core/functions.php';

// $action = $_POST['action'] ?? '';

// if ($action === 'send_msg') {
    

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = $_POST['msg'] ?? '';

    $msgs = readMsgs();

    $msgs[] = [
        'name' => $name,
        'email' => $email,
        'msg' => $msg
    ];

    saveMsg($msgs);

    $_SESSION['success'] = "Your message has been sent successfully!";
    header('Location: ../views/contact.php');
    exit;
// }

// $_SESSION['error'] = "Invalid action.";
// header('Location: ../views/contact.php');
// exit;


function readMsgs()
{
    $path = getMessagesFile();
    if (!file_exists($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}


function getMessagesFile()
{
    return __DIR__ . '/../data/msgs.json';
}


function saveMsg(array $msgs)
{
    $path = getMessagesFile();
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $json = json_encode($msgs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // atomic write with LOCK_EX
    file_put_contents($path, $json, LOCK_EX);
}
