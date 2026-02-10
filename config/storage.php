<?php
// Шлях до файлу даних
define('DATA_FILE', __DIR__ . '/data.json');

// Функція для завантаження даних
function loadData() {
    if (file_exists(DATA_FILE)) {
        $json = file_get_contents(DATA_FILE);
        return json_decode($json, true);
    }
    return null;
}

// Функція для збереження даних
function saveData($products, $users) {
    $data = [
        'products' => $products,
        'users' => $users,
        'updated' => date('Y-m-d H:i:s')
    ];
    
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(DATA_FILE, $json);
}

// Завантаження даних при ініціалізації
$savedData = loadData();
if ($savedData) {
    if (isset($savedData['products'])) {
        $products = $savedData['products'];
    }
    if (isset($savedData['users'])) {
        $users = $savedData['users'];
    }
}
?>
