# Використовуємо офіційний PHP образ
FROM php:8.2-cli

# Встановлюємо робочу директорію
WORKDIR /app

# Копіюємо всі файли проекту
COPY . /app

# Встановлюємо права доступу
RUN chmod -R 755 /app && \
    mkdir -p /app/config && \
    chmod 777 /app/config

# Відкриваємо порт
EXPOSE ${PORT:-10000}

# Запускаємо PHP сервер
CMD php -S 0.0.0.0:${PORT:-10000} -t /app
