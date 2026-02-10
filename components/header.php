<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo SITE_DESCRIPTION; ?></title>
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>main.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>header.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>products.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>cart.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>auth.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>admin.css">
    <!-- Font Awesome для іконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header__content">
                <!-- Лого -->
                <a href="index.php" class="header__logo">
                    <i class="fas fa-leaf"></i>
                    <span><?php echo SITE_NAME; ?></span>
                </a>

                <!-- Навігація -->
                <nav class="header__nav">
                    <ul class="header__menu">
                        <li><a href="index.php?page=home" class="<?php echo $page === 'home' ? 'active' : ''; ?>">Головна</a></li>
                        <li><a href="index.php?page=shop" class="<?php echo $page === 'shop' ? 'active' : ''; ?>">Магазин</a></li>
                        <li><a href="index.php?page=about" class="<?php echo $page === 'about' ? 'active' : ''; ?>">Про нас</a></li>
                        <li><a href="index.php?page=contact" class="<?php echo $page === 'contact' ? 'active' : ''; ?>">Контакти</a></li>
                    </ul>
                </nav>

                <!-- Кошик -->
                <div class="header__actions">
                    <a href="index.php?page=cart" class="header__cart">
                        <i class="fas fa-shopping-cart"></i>
                        <?php 
                        $cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                        if ($cart_count > 0): 
                        ?>
                        <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Користувач авторизований -->
                        <div class="header__user">
                            <span class="user-name">
                                <i class="fas fa-user"></i>
                                <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
                            </span>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <a href="index.php?page=admin" class="btn-admin">
                                    <i class="fas fa-cog"></i> Адмін
                                </a>
                            <?php endif; ?>
                            <form method="POST" style="display: inline;">
                                <button type="submit" name="logout" class="btn-logout">
                                    <i class="fas fa-sign-out-alt"></i> Вихід
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <!-- Кнопка логіну -->
                        <button class="btn-login" onclick="openLoginModal()">
                            <i class="fas fa-user"></i> Увійти
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Бургер меню для мобільних -->
                <button class="header__burger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Модальне вікно авторизації -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeLoginModal()">&times;</span>
            
            <div class="modal-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Вхід</button>
                <button class="tab-btn" onclick="switchTab('register')">Реєстрація</button>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php 
                    echo htmlspecialchars($_SESSION['error']); 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            
            <!-- Форма входу -->
            <div id="loginTab" class="tab-content active">
                <h2>Вхід до системи</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Логін
                        </label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Пароль
                        </label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Увійти
                    </button>
                </form>
                
                <div class="form-footer">
                    <p><strong>Тестові акаунти:</strong></p>
                    <p>Адмін: <code>admin</code> / <code>admin123</code></p>
                    <p>Користувач: <code>user</code> / <code>user123</code></p>
                </div>
            </div>
            
            <!-- Форма реєстрації -->
            <div id="registerTab" class="tab-content">
                <h2>Реєстрація</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="reg_username">
                            <i class="fas fa-user"></i> Логін
                        </label>
                        <input type="text" id="reg_username" name="reg_username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reg_email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="reg_email" name="reg_email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reg_password">
                            <i class="fas fa-lock"></i> Пароль
                        </label>
                        <input type="password" id="reg_password" name="reg_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reg_confirm_password">
                            <i class="fas fa-lock"></i> Підтвердження паролю
                        </label>
                        <input type="password" id="reg_confirm_password" name="reg_confirm_password" required>
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-primary btn-block">
                        <i class="fas fa-user-plus"></i> Зареєструватись
                    </button>
                </form>
            </div>
        </div>
    </div>

    <main class="main-content">
