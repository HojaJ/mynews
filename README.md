## MyNews - Новостной портал
- Проект новостного портала с возможностью авторизации, добавления новостей и админ-панелью.

## Требования
- PHP 8.3+
- MySQL 5.7+

## Установка
1.Клонировать репозиторий:
git clone https://github.com/HojaJ/mynews.git

2.Установить зависимости:
composer install

3.Настроить базу данных:
cp .env.example .env

4.Запустить миграции:
php artisan migrate --seed

5.Запустить сервер:
php artisan serve   


## Учетные записи для тестирования

- Администратор: admin@example.com / password
- Контент-менеджер: manager@example.com / password
- Пользователь: user@example.com / password
