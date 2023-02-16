php artisan db:wipe
rm -rf /mnt/c/laragon/www/zikmu/storage/app/public/files
php artisan migrate
php artisan db:seed SongSeeder