<?php
// Перевірка доступу
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Отримання поточної секції
$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

// Статистика
$total_products = count($products);
$total_orders = 0;
$total_users = count($users);
$total_revenue = 0;

foreach ($products as $product) {
    $total_revenue += $product['price'];
}
?>

<div class="admin-page">
    <div class="container">
        <!-- Заголовок -->
        <div class="admin-header">
            <h1>
                <i class="fas fa-shield-alt"></i>
                Панель адміністратора
            </h1>
            <p>Ласкаво просимо, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Статистика -->
        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-icon products">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-label">Всього товарів</div>
                <div class="stat-value"><?php echo $total_products; ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orders">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-label">Замовлень</div>
                <div class="stat-value"><?php echo $total_orders; ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Користувачів</div>
                <div class="stat-value"><?php echo $total_users; ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-label">Загальна вартість</div>
                <div class="stat-value"><?php echo number_format($total_revenue, 0, ',', ' '); ?> грн</div>
            </div>
        </div>

        <!-- Управління товарами -->
        <div class="admin-section" id="products">
            <h2><i class="fas fa-box"></i> Управління товарами</h2>
            <button class="btn btn-add" onclick="openProductModal()">
                <i class="fas fa-plus"></i>
                Додати товар
            </button>

            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Зображення</th>
                            <th>Назва</th>
                            <th>Ціна</th>
                            <th>Категорія</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td>
                                <img src="<?php echo $product['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     class="product-image-small">
                            </td>
                            <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                            <td><?php echo $product['price']; ?> грн</td>
                            <td>
                                <span class="badge"><?php echo $product['category']; ?></span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <button class="btn-sm btn-edit" onclick='openEditProductModal(<?php echo json_encode($product); ?>)'>
                                        <i class="fas fa-edit"></i> Редагувати
                                    </button>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити <?php echo htmlspecialchars($product['name']); ?>?')">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" name="delete_product" class="btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Видалити
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Управління користувачами -->
        <div class="admin-section" id="users">
            <h2><i class="fas fa-users"></i> Управління користувачами</h2>

            <div style="overflow-x: auto;">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Логін</th>
                            <th>Email</th>
                            <th>Ім'я</th>
                            <th>Роль</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td>
                                <span class="badge <?php echo $user['role']; ?>">
                                    <?php echo $user['role'] === 'admin' ? 'Адмін' : 'Користувач'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <button class="btn-sm btn-edit" onclick='openEditUserModal(<?php echo json_encode($user); ?>)'>
                                        <i class="fas fa-edit"></i> Редагувати
                                    </button>
                                    <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити користувача <?php echo htmlspecialchars($user['username']); ?>?')">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" name="delete_user" class="btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Видалити
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Модальне вікно додавання/редагування товару -->
<div id="productModal" class="modal">
    <div class="modal-content modal-large">
        <span class="modal-close" onclick="closeProductModal()">&times;</span>
        <h2 id="productModalTitle">Додати товар</h2>
        
        <form method="POST" class="admin-form" id="productForm">
            <input type="hidden" name="product_id" id="product_id">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product_name">
                        <i class="fas fa-tag"></i> Назва товару *
                    </label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>
                
                <div class="form-group">
                    <label for="product_price">
                        <i class="fas fa-money-bill"></i> Ціна (грн) *
                    </label>
                    <input type="number" id="product_price" name="product_price" step="0.01" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product_category">
                        <i class="fas fa-folder"></i> Категорія *
                    </label>
                    <select id="product_category" name="product_category" required>
                        <option value="Кімнатні">Кімнатні рослини</option>
                        <option value="Садові рослини">Садові рослини</option>
                        <option value="Кактуси">Кактуси</option>
                        <option value="Сукуленти">Сукуленти</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product_image">
                        <i class="fas fa-image"></i> URL зображення *
                    </label>
                    <input type="text" id="product_image" name="product_image" required 
                           placeholder="https://images.unsplash.com/photo-..."
                           oninput="previewImage(this.value)">
                    <small style="color: #666; display: block; margin-top: 0.5rem;">
                        💡 Підказка: Використовуйте безкоштовні зображення з 
                        <a href="https://unsplash.com/s/photos/plant" target="_blank" style="color: var(--primary-color);">Unsplash</a> або 
                        <a href="https://www.pexels.com/search/plant/" target="_blank" style="color: var(--primary-color);">Pexels</a>
                    </small>
                    <div id="imagePreview" style="margin-top: 1rem; display: none;">
                        <img id="previewImg" src="" alt="Попередній перегляд" 
                             style="max-width: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="product_description">
                    <i class="fas fa-align-left"></i> Опис
                </label>
                <textarea id="product_description" name="product_description" rows="4"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeProductModal()">
                    <i class="fas fa-times"></i> Скасувати
                </button>
                <button type="submit" name="add_product" id="productSubmitBtn" class="btn btn-primary">
                    <i class="fas fa-save"></i> Зберегти
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Модальне вікно редагування користувача -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeUserModal()">&times;</span>
        <h2>Редагувати користувача</h2>
        
        <form method="POST" class="admin-form" id="userForm">
            <input type="hidden" name="user_id" id="user_id">
            
            <div class="form-group">
                <label for="user_username">
                    <i class="fas fa-user"></i> Логін *
                </label>
                <input type="text" id="user_username" name="user_username" required>
            </div>
            
            <div class="form-group">
                <label for="user_email">
                    <i class="fas fa-envelope"></i> Email *
                </label>
                <input type="email" id="user_email" name="user_email" required>
            </div>
            
            <div class="form-group">
                <label for="user_name">
                    <i class="fas fa-id-card"></i> Ім'я *
                </label>
                <input type="text" id="user_name" name="user_name" required>
            </div>
            
            <div class="form-group">
                <label for="user_role">
                    <i class="fas fa-shield-alt"></i> Роль *
                </label>
                <select id="user_role" name="user_role" required>
                    <option value="user">Користувач</option>
                    <option value="admin">Адміністратор</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="user_password">
                    <i class="fas fa-lock"></i> Новий пароль (залиште порожнім, щоб не змінювати)
                </label>
                <input type="password" id="user_password" name="user_password" 
                       placeholder="Введіть новий пароль або залиште порожнім">
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeUserModal()">
                    <i class="fas fa-times"></i> Скасувати
                </button>
                <button type="submit" name="edit_user" class="btn btn-primary">
                    <i class="fas fa-save"></i> Зберегти
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Попередній перегляд зображення
function previewImage(url) {
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    
    if (url && url.startsWith('http')) {
        img.src = url;
        preview.style.display = 'block';
        img.onerror = function() {
            preview.style.display = 'none';
        };
    } else {
        preview.style.display = 'none';
    }
}

// Товари
function openProductModal() {
    document.getElementById('productModalTitle').textContent = 'Додати товар';
    document.getElementById('productForm').reset();
    document.getElementById('product_id').value = '';
    document.getElementById('productSubmitBtn').name = 'add_product';
    document.getElementById('productSubmitBtn').innerHTML = '<i class="fas fa-plus"></i> Додати товар';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('productModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function openEditProductModal(product) {
    document.getElementById('productModalTitle').textContent = 'Редагувати товар';
    document.getElementById('product_id').value = product.id;
    document.getElementById('product_name').value = product.name;
    document.getElementById('product_price').value = product.price;
    document.getElementById('product_category').value = product.category;
    document.getElementById('product_image').value = product.image;
    document.getElementById('product_description').value = product.description || '';
    document.getElementById('productSubmitBtn').name = 'edit_product';
    document.getElementById('productSubmitBtn').innerHTML = '<i class="fas fa-save"></i> Зберегти зміни';
    previewImage(product.image);
    document.getElementById('productModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    document.getElementById('productModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Користувачі
function openEditUserModal(user) {
    document.getElementById('user_id').value = user.id;
    document.getElementById('user_username').value = user.username;
    document.getElementById('user_email').value = user.email;
    document.getElementById('user_name').value = user.name;
    document.getElementById('user_role').value = user.role;
    document.getElementById('user_password').value = '';
    document.getElementById('userModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeUserModal() {
    document.getElementById('userModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Закриття модалки по кліку поза нею
window.onclick = function(event) {
    const productModal = document.getElementById('productModal');
    const userModal = document.getElementById('userModal');
    
    if (event.target === productModal) {
        closeProductModal();
    }
    if (event.target === userModal) {
        closeUserModal();
    }
}

function scrollToSection(sectionId) {
    document.getElementById(sectionId).scrollIntoView({ 
        behavior: 'smooth',
        block: 'start'
    });
}
</script>
