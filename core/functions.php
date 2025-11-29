<?php

function getUsersFilePath() {
    return __DIR__ . '/../data/users.json';
}

function readUsers() {
    $path = getUsersFilePath();
    if (!file_exists($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function saveUsers(array $users) {
    $path = getUsersFilePath();
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // atomic write with LOCK_EX
    file_put_contents($path, $json, LOCK_EX);
}

function findUserByEmail($email) {
    $users = readUsers();
    foreach ($users as $user) {
        if (isset($user['email']) && $user['email'] === $email) {
            return $user;
        }
    }
    return null;
}
