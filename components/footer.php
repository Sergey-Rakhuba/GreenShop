    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer__content">
                <!-- Колонка 1: Про компанію -->
                <div class="footer__column">
                    <h3><i class="fas fa-leaf"></i> <?php echo SITE_NAME; ?></h3>
                    <p>Найкращі рослини для вашого дому та саду. Доставка по всій Україні.</p>
                    <div class="footer__social">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>

                <!-- Колонка 2: Навігація -->
                <div class="footer__column">
                    <h4>Навігація</h4>
                    <ul>
                        <li><a href="index.php?page=home">Головна</a></li>
                        <li><a href="index.php?page=shop">Магазин</a></li>
                        <li><a href="index.php?page=about">Про нас</a></li>
                        <li><a href="index.php?page=contact">Контакти</a></li>
                    </ul>
                </div>

                <!-- Колонка 3: Контакти -->
                <div class="footer__column">
                    <h4>Контакти</h4>
                    <ul class="footer__contacts">
                        <li><i class="fas fa-phone"></i> +380 (67) 123-45-67</li>
                        <li><i class="fas fa-envelope"></i> info@greenshop.ua</li>
                        <li><i class="fas fa-map-marker-alt"></i> м. Київ, вул. Квіткова, 15</li>
                    </ul>
                </div>

                <!-- Колонка 4: Графік роботи -->
                <div class="footer__column">
                    <h4>Графік роботи</h4>
                    <ul>
                        <li>Пн-Пт: 9:00 - 19:00</li>
                        <li>Сб: 10:00 - 17:00</li>
                        <li>Нд: Вихідний</li>
                    </ul>
                </div>
            </div>

            <div class="footer__bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Всі права захищені, розробник Рахуба Сергій Леонідович rakhubasergey7@gmail.com</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo JS_PATH; ?>main.js"></script>
</body>
</html>
