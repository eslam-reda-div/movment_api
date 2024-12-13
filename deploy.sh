#!/bin/bash

set -e

# Log the deployment process
LOG_FILE="/var/log/deploy.log"
exec > >(tee -i $LOG_FILE) 2>&1
echo "Deployment started at $(date)"

# التوجه إلى مجلد المشروع
cd /var/www/html/movment_api

# تحديث الملفات
sudo git reset --hard
sudo git clean -fd
sudo git pull origin main

# تثبيت الاعتماديات
sudo composer install --no-dev --optimize-autoloader

sudo cp .env.production .env

# تحديث التعديلات على قواعد البيانات
sudo php artisan migrate --force

sudo php artisan project:update

# تنظيف الكاش
sudo php artisan cache:clear
sudo php artisan config:cache
sudo php artisan route:cache

sudo npm install
sudo npm run build

sudo php artisan icon:cache

# ضبط صلاحيات الملفات
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

echo "Deployment completed successfully at $(date)"
