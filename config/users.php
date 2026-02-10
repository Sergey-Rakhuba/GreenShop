<?php
// База користувачів (в реальному проекті використовуйте БД)
$users = [
    [
        'id' => 1,
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'email' => 'admin@greenshop.ua',
        'role' => 'admin',
        'name' => 'Адміністратор'
    ],
    [
        'id' => 2,
        'username' => 'user',
        'password' => password_hash('user123', PASSWORD_DEFAULT),
        'email' => 'user@example.com',
        'role' => 'user',
        'name' => 'Звичайний користувач'
    ]
];

// Функція для перевірки логіну
function authenticateUser($username, $password, $users) {
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

// Функція для реєстрації нового користувача
function registerUser($username, $email, $password, &$users) {
    // Перевірка чи існує користувач
    foreach ($users as $user) {
        if ($user['username'] === $username || $user['email'] === $email) {
            return ['success' => false, 'message' => 'Користувач з таким логіном або email вже існує'];
        }
    }
    
    // Створення нового користувача
    $new_user = [
        'id' => count($users) + 1,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'email' => $email,
        'role' => 'user',
        'name' => $username
    ];
    
    $users[] = $new_user;
    return ['success' => true, 'user' => $new_user];
}
?>
