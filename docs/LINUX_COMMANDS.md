# Linux commands for PHP and ILIAS-style administration

## Files and permissions

```bash
pwd
ls -la
find src -name '*.php'
mkdir -p storage/logs
chmod -R u+rwX storage
chown -R www-data:www-data storage
```

## PHP and Composer

```bash
php -v
php -m
php --ini
php -l src/Services/CourseService.php
composer install
composer dump-autoload
composer test
```

## Web server and processes

```bash
ps aux | grep php
ss -ltnp
systemctl status apache2
systemctl status nginx
systemctl status php8.4-fpm
journalctl -u apache2 -n 100
```

Use the exact PHP-FPM service name installed on the machine.

## Logs

```bash
tail -f storage/logs/app.log
tail -f /var/log/apache2/error.log
grep -R "Course created" storage/logs
```

## MySQL

```bash
systemctl status mysql
mysql -u root -p
mysqldump -u root -p mini_ilias > backup.sql
mysql -u root -p mini_ilias < backup.sql
```

## Search a large codebase

```bash
grep -R "class CourseController" -n src
grep -R "function apiSearch" -n .
grep -R "CREATE TABLE" -n database
rg "getPluginName|ilPlugin|component.repository" components public
```
