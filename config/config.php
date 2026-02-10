<?php
// Конфігурація GreenShop

// Налаштування сайту
define('SITE_NAME', 'GreenShop');
define('SITE_URL', 'http://localhost:8000');
define('SITE_DESCRIPTION', 'Інтернет-магазин рослин та квітів');

// Налаштування бази даних (для майбутнього використання)
define('DB_HOST', 'localhost');
define('DB_NAME', 'greenshop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Шлях до assets
define('CSS_PATH', '/assets/css/');
define('JS_PATH', '/assets/js/');
define('IMG_PATH', '/assets/images/');

// Налаштування кошика
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Масив товарів (тимчасово, потім буде з БД)
$products = [
    [
        'id' => 1,
        'name' => 'Монстера Делікатесна',
        'price' => 450,
        'description' => 'Тропічна рослина з великими листями',
        'image' => 'monstera.jpg',
        'category' => 'Кімнатні'
    ],
    [
        'id' => 2,
        'name' => 'Фікус Еластика',
        'price' => 350,
        'description' => 'Каучукове дерево для дому',
        'image' => 'ficus.jpg',
        'category' => 'Кімнатні'
    ],
    [
        'id' => 3,
        'name' => 'Сансевієрія',
        'price' => 250,
        'description' => 'Невибаглива рослина "Тещин язик"',
        'image' => 'sansevieria.jpg',
        'category' => 'Кімнатні'
    ],
    [
        'id' => 4,
        'name' => 'Кактус Мікс',
        'price' => 150,
        'description' => 'Набір мініатюрних кактусів',
        'image' => 'cactus.jpg',
        'category' => 'Кактуси'
    ],
    [
        'id' => 5,
        'name' => 'Алое Вера',
        'price' => 200,
        'description' => 'Лікувальна рослина для дому',
        'image' => 'aloe.jpg',
        'category' => 'Сукуленти'
    ],
    [
        'id' => 6,
        'name' => 'Спатифілум',
        'price' => 300,
        'description' => 'Рослина "Жіноче щастя"',
        'image' => 'spathiphyllum.jpg',
        'category' => 'Кімнатні'
    ],
    [
        'id' => 7,
        'name' => 'Троянда садова',
        'price' => 350,
        'description' => 'Красива троянда для вашого саду',
        'image' => '',
        'category' => 'Садові рослини'
    ],
    [
        'id' => 8,
        'name' => 'Лаванда',
        'price' => 180,
        'description' => 'Ароматна рослина для саду',
        'image' => '',
        'category' => 'Садові рослини'
    ],
    [
        'id' => 9,
        'name' => 'Хоста',
        'price' => 220,
        'description' => 'Декоративна рослина для тіні',
        'image' => '',
        'category' => 'Садові рослини'
    ]
];
?>
