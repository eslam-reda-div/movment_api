#!/bin/bash

# التوجه إلى مجلد المشروع
cd /path/to/your/project

# تحديث الملفات
sudo git reset --hard
sudo git pull origin main

# تثبيت الاعتماديات
sudo composer install --no-dev --optimize-autoloader

# تحديث التعديلات على قواعد البيانات
sudo php artisan migrate --force

# تنظيف الكاش
sudo php artisan cache:clear
sudo php artisan config:cache
sudo php artisan route:cache

# ضبط صلاحيات الملفات
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
