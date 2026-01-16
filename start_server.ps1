$env:Path = "D:\xampp\php;" + $env:Path
php artisan key:generate
php artisan package:discover
php artisan serve
