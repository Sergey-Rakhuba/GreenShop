<?php
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_product = null;

foreach ($products as $product) {
    if ($product['id'] === $product_id) {
        $current_product = $product;
        break;
    }
}

if (!$current_product) {
    header('Location: index.php?page=404');
    exit;
}
?>

<div class="product-page">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Головна</a> / 
            <a href="index.php?page=shop">Магазин</a> / 
            <span><?php echo $current_product['name']; ?></span>
        </nav>

        <div class="product-details">
            <div class="product-details__image">
                <?php if (!empty($current_product['image'])): ?>
                    <img src="<?php echo $current_product['image']; ?>" alt="<?php echo $current_product['name']; ?>">
                <?php else: ?>
                    <div class="product-placeholder-large">
                        <i class="fas fa-seedling"></i>
                    </div>
                <?php endif; ?>
            </div>

            <div class="product-details__info">
                <h1><?php echo $current_product['name']; ?></h1>
                <div class="product-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>(4.5 / 24 відгуки)</span>
                </div>
                <div class="product-price-large"><?php echo $current_product['price']; ?> грн</div>
                <p class="product-description-full"><?php echo $current_product['description']; ?></p>
                
                <div class="product-features">
                    <h3>Характеристики:</h3>
                    <ul>
                        <li><strong>Категорія:</strong> <?php echo ucfirst($current_product['category']); ?></li>
                        <li><strong>Освітлення:</strong> Помірне</li>
                        <li><strong>Полив:</strong> 1-2 рази на тиждень</li>
                        <li><strong>Температура:</strong> 18-25°C</li>
                    </ul>
                </div>

                <div class="product-actions-block">
                    <form method="POST" action="index.php?page=cart">
                        <input type="hidden" name="product_id" value="<?php echo $current_product['id']; ?>">
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-cart"></i> Додати в кошик
                        </button>
                    </form>
                </div>

                <div class="product-info-tabs">
                    <h3>Опис та догляд</h3>
                    <p>Ця рослина ідеально підходить для дому чи офісу. Невибаглива в догляді, потребує помірного поливу та розсіяного світла. Добре очищає повітря та створює затишну атмосферу.</p>
                </div>
            </div>
        </div>

        <!-- Схожі товари -->
        <section class="related-products">
            <h2 class="section-title">Схожі товари</h2>
            <div class="products-grid">
                <?php
                $related = array_filter($products, function($p) use ($current_product) {
                    return $p['id'] !== $current_product['id'] && $p['category'] === $current_product['category'];
                });
                $related = array_slice($related, 0, 3);
                foreach ($related as $product):
                ?>
                <div class="product-card">
                    <div class="product-card__image">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        <?php else: ?>
                            <div class="product-placeholder">
                                <i class="fas fa-seedling"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="product-card__content">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                        <div class="product-card__footer">
                            <span class="product-price"><?php echo $product['price']; ?> грн</span>
                            <a href="index.php?page=product&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Детальніше</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>
