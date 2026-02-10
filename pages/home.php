<div class="home-page">
    <!-- Hero секція -->
    <section class="hero">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title">Живі рослини для вашого дому</h1>
                <p class="hero__description">Створіть затишок та гармонію з нашою колекцією кімнатних рослин</p>
                <div class="hero__buttons">
                    <a href="index.php?page=shop" class="btn btn-primary">Перейти до магазину</a>
                    <a href="index.php?page=about" class="btn btn-secondary">Дізнатися більше</a>
                </div>
            </div>
            <div class="hero__image">
                <i class="fas fa-seedling hero__icon"></i>
            </div>
        </div>
    </section>

    <!-- Переваги -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Чому обирають нас</h2>
            <div class="features__grid">
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3>Якісні рослини</h3>
                    <p>Тільки здорові та красиві рослини від перевірених постачальників</p>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Швидка доставка</h3>
                    <p>Доставка по Києву за 1-2 дні, по Україні - 2-5 днів</p>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Підтримка 24/7</h3>
                    <p>Консультації по догляду та вирощуванню рослин</p>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Гарантія якості</h3>
                    <p>7 днів гарантії на всі рослини</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Популярні товари -->
    <section class="popular-products">
        <div class="container">
            <h2 class="section-title">Популярні рослини</h2>
            <div class="products-grid">
                <?php
                // Показуємо тільки перші 3 товари
                $featured_products = array_slice($products, 0, 3);
                foreach ($featured_products as $product):
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
            <div class="text-center" style="margin-top: 2rem;">
                <a href="index.php?page=shop" class="btn btn-primary">Дивитись всі товари</a>
            </div>
        </div>
    </section>

    <!-- Категорії -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Категорії рослин</h2>
            <div class="categories__grid">
                <div class="category-card">
                    <i class="fas fa-home"></i>
                    <h3>Кімнатні рослини</h3>
                    <p>Для затишку в домі</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-spa"></i>
                    <h3>Сукуленти</h3>
                    <p>Невибагливі красені</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-apple-alt"></i>
                    <h3>Кактуси</h3>
                    <p>Екзотика для вас</p>
                </div>
                <div class="category-card">
                    <i class="fas fa-tree"></i>
                    <h3>Садові рослини</h3>
                    <p>Для вашого саду</p>
                </div>
            </div>
        </div>
    </section>
</div>
