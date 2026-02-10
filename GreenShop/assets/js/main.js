// === GREENSHOP JAVASCRIPT ===

// Модальне вікно авторизації
function openLoginModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function switchTab(tabName) {
    // Приховати всі таби
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Показати обраний таб
    document.getElementById(tabName + 'Tab').classList.add('active');
    event.target.classList.add('active');
}

// Закриття модалки по кліку поза нею
window.onclick = function(event) {
    const modal = document.getElementById('loginModal');
    if (event.target === modal) {
        closeLoginModal();
    }
}

// Автоматичне відкриття модалки якщо є помилка
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.alert-error')) {
        openLoginModal();
    }
});

// Фільтрація товарів
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Оновлення активної кнопки
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Показ/приховання товарів
    products.forEach(product => {
        const productCategory = product.getAttribute('data-category');
        
        if (category === 'all' || productCategory === category) {
            product.style.display = 'block';
            product.style.animation = 'fadeSlideIn 0.5s ease-out';
        } else {
            product.style.display = 'none';
        }
    });
}

// Додавання товару в кошик (AJAX версія для майбутнього)
function addToCart(productId) {
    // Створюємо форму та відправляємо
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?page=cart';
    
    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'product_id';
    idInput.value = productId;
    
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = 'add';
    
    form.appendChild(idInput);
    form.appendChild(actionInput);
    document.body.appendChild(form);
    form.submit();
}

// Toggle бургер меню
function toggleMenu() {
    const nav = document.querySelector('.header__nav');
    const burger = document.querySelector('.header__burger');
    
    if (nav) {
        nav.classList.toggle('mobile-open');
        burger.classList.toggle('active');
    }
}

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Анімація при скролі
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeSlideIn 0.6s ease-out';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Спостереження за елементами
document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.feature-card, .category-card, .product-card');
    elements.forEach(el => observer.observe(el));
});

// Підтвердження видалення з кошика
document.querySelectorAll('.cart-item__remove form').forEach(form => {
    form.addEventListener('submit', (e) => {
        if (!confirm('Ви впевнені, що хочете видалити цей товар з кошика?')) {
            e.preventDefault();
        }
    });
});

console.log('🌱 GreenShop loaded successfully!');
