<div class="shop-page">
    <div class="container">
        <h1 class="page-title">Наш магазин</h1>
        
        <!-- Фільтри -->
        <div class="shop-filters">
            <button class="filter-btn active" onclick="filterProducts('all')">Всі</button>
            <button class="filter-btn" onclick="filterProducts('indoor')">Кімнатні</button>
            <button class="filter-btn" onclick="filterProducts('cactus')">Кактуси</button>
            <button class="filter-btn" onclick="filterProducts('succulent')">Сукуленти</button>
        </div>

        <!-- Сітка товарів -->
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?php echo $product['category']; ?>">
                <div class="product-card__image">
                    <div class="product-placeholder">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <span class="product-badge">Новинка</span>
                </div>
                <div class="product-card__content">
                    <h3><?php echo $product['name']; ?></h3>
                    <p class="product-description"><?php echo $product['description']; ?></p>
                    <div class="product-card__footer">
                        <span class="product-price"><?php echo $product['price']; ?> грн</span>
                        <div class="product-actions">
                            <a href="index.php?page=product&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-sm btn-primary">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
