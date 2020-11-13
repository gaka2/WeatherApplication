# Installation

1. Run:
```
git clone <repository_url>
composer install --no-dev --optimize-autoloader
```

2. Run (MySQL CLI or via phpMyAdmin):
```
CREATE DATABASE weather_db;
CREATE USER 'weather_app'@'localhost' IDENTIFIED BY 'ykQELC8Qgn9dQp8fJ';
GRANT ALL PRIVILEGES ON weather_db.* TO 'weather_app'@'localhost';
```

3. Run:
```
php bin/console doctrine:schema:update --force
php bin/console cache:clear
```


# Usage

## Web browser
Go to:
```
localhost
```
