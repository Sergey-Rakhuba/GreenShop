<?php
// GreenShop - Інтернет-магазин рослин
session_start();

// Підключення конфігурації
require_once 'config/config.php';
require_once 'config/users.php';
require_once 'config/storage.php';

// Обробка авторизації та реєстрації
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Логін
    if (isset($_POST['login'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        
        $user = authenticateUser($username, $password, $users);
        
        if ($user) {
            $_SESSION['user'] = $user;
            
            // Редирект в залежності від ролі
            if ($user['role'] === 'admin') {
                header('Location: index.php?page=admin');
            } else {
                header('Location: index.php?page=shop');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Невірний логін або пароль';
            header('Location: index.php');
            exit;
        }
    }
    
    // Реєстрація
    if (isset($_POST['register'])) {
        $username = trim($_POST['reg_username']);
        $email = trim($_POST['reg_email']);
        $password = $_POST['reg_password'];
        $confirm_password = $_POST['reg_confirm_password'];
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Паролі не співпадають';
            header('Location: index.php');
            exit;
        }
        
        $result = registerUser($username, $email, $password, $users);
        
        if ($result['success']) {
            $_SESSION['user'] = $result['user'];
            header('Location: index.php?page=shop');
            exit;
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: index.php');
            exit;
        }
    }
    
    // Вихід
    if (isset($_POST['logout'])) {
        unset($_SESSION['user']);
        header('Location: index.php');
        exit;
    }
}

// Обробка адмін-дій
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
    
    // Додавання товару
    if (isset($_POST['add_product'])) {
        $new_product = [
            'id' => count($products) + 1,
            'name' => trim($_POST['product_name']),
            'price' => floatval($_POST['product_price']),
            'description' => trim($_POST['product_description']),
            'image' => $_POST['product_image'],
            'category' => $_POST['product_category']
        ];
        
        $products[] = $new_product;
        saveData($products, $users);
        
        $_SESSION['success'] = 'Товар успішно додано!';
        header('Location: index.php?page=admin&section=products');
        exit;
    }
    
    // Редагування товару
    if (isset($_POST['edit_product'])) {
        $product_id = intval($_POST['product_id']);
        
        foreach ($products as $key => $product) {
            if ($product['id'] == $product_id) {
                $products[$key] = [
                    'id' => $product_id,
                    'name' => trim($_POST['product_name']),
                    'price' => floatval($_POST['product_price']),
                    'description' => trim($_POST['product_description']),
                    'image' => $_POST['product_image'],
                    'category' => $_POST['product_category']
                ];
                break;
            }
        }
        
        saveData($products, $users);
        $_SESSION['success'] = 'Товар успішно оновлено!';
        header('Location: index.php?page=admin&section=products');
        exit;
    }
    
    // Видалення товару
    if (isset($_POST['delete_product'])) {
        $product_id = intval($_POST['product_id']);
        
        $products = array_values(array_filter($products, function($product) use ($product_id) {
            return $product['id'] != $product_id;
        }));
        
        saveData($products, $users);
        $_SESSION['success'] = 'Товар успішно видалено!';
        header('Location: index.php?page=admin&section=products');
        exit;
    }
    
    // Редагування користувача
    if (isset($_POST['edit_user'])) {
        $user_id = intval($_POST['user_id']);
        
        foreach ($users as $key => $user) {
            if ($user['id'] == $user_id) {
                $users[$key]['username'] = trim($_POST['user_username']);
                $users[$key]['email'] = trim($_POST['user_email']);
                $users[$key]['name'] = trim($_POST['user_name']);
                $users[$key]['role'] = $_POST['user_role'];
                
                if (!empty($_POST['user_password'])) {
                    $users[$key]['password'] = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
                }
                break;
            }
        }
        
        saveData($products, $users);
        $_SESSION['success'] = 'Користувача успішно оновлено!';
        header('Location: index.php?page=admin&section=users');
        exit;
    }
    
    // Видалення користувача
    if (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);
        
        if ($user_id === $_SESSION['user']['id']) {
            $_SESSION['error'] = 'Не можна видалити самого себе!';
            header('Location: index.php?page=admin&section=users');
            exit;
        }
        
        $users = array_values(array_filter($users, function($user) use ($user_id) {
            return $user['id'] != $user_id;
        }));
        
        saveData($products, $users);
        $_SESSION['success'] = 'Користувача успішно видалено!';
        header('Location: index.php?page=admin&section=users');
        exit;
    }
}

// Обробка POST-запитів для кошика
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        
        if ($_POST['action'] === 'add') {
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 0;
            }
            $_SESSION['cart'][$product_id]++;
        } elseif ($_POST['action'] === 'remove') {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        } elseif ($_POST['action'] === 'delete') {
            unset($_SESSION['cart'][$product_id]);
        }
        
        header('Location: index.php?page=cart');
        exit;
    }
}

// Отримання поточної сторінки
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Валідація сторінки
$allowed_pages = ['home', 'shop', 'about', 'contact', 'cart', 'product', 'admin'];
if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

// Перевірка доступу до адмін-панелі
if ($page === 'admin' && (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin')) {
    header('Location: index.php');
    exit;
}

// Підключення header
include 'components/header.php';

// Підключення контенту сторінки
$page_file = "pages/{$page}.php";
if (file_exists($page_file)) {
    include $page_file;
} else {
    include 'pages/404.php';
}

// Підключення footer
include 'components/footer.php';
?>
