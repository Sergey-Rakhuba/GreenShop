<?php
// Підрахунок загальної суми
$total = 0;
$cart_items = [];

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        foreach ($products as $product) {
            if ($product['id'] == $product_id) {
                $cart_items[] = array_merge($product, ['quantity' => $quantity]);
                $total += $product['price'] * $quantity;
                break;
            }
        }
    }
}
?>

<div class="cart-page">
    <div class="container">
        <h1 class="page-title">Кошик</h1>

        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h2>Ваш кошик порожній</h2>
                <p>Додайте товари до кошика, щоб продовжити покупки</p>
                <a href="index.php?page=shop" class="btn btn-primary">Перейти до магазину</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item__image">
                            <div class="product-placeholder-small">
                                <i class="fas fa-seedling"></i>
                            </div>
                        </div>
                        <div class="cart-item__details">
                            <h3><?php echo $item['name']; ?></h3>
                            <p><?php echo $item['description']; ?></p>
                            <span class="cart-item__price"><?php echo $item['price']; ?> грн</span>
                        </div>
                        <div class="cart-item__quantity">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="quantity-btn">-</button>
                            </form>
                            <span><?php echo $item['quantity']; ?></span>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="quantity-btn">+</button>
                            </form>
                        </div>
                        <div class="cart-item__total">
                            <?php echo $item['price'] * $item['quantity']; ?> грн
                        </div>
                        <form method="POST" class="cart-item__remove">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn-remove">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h3>Підсумок замовлення</h3>
                    <div class="summary-row">
                        <span>Товарів:</span>
                        <span><?php echo array_sum($_SESSION['cart']); ?> шт</span>
                    </div>
                    <div class="summary-row">
                        <span>Сума:</span>
                        <span><?php echo $total; ?> грн</span>
                    </div>
                    <div class="summary-row">
                        <span>Доставка:</span>
                        <span>Безкоштовно</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-row summary-total">
                        <span>Разом:</span>
                        <span><?php echo $total; ?> грн</span>
                    </div>
                    <button class="btn btn-primary btn-block">Оформити замовлення</button>
                    <a href="index.php?page=shop" class="btn btn-secondary btn-block">Продовжити покупки</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
