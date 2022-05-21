# Errors

## PHP file not auto-loaded
When accessing `localhost:80`, you see black text on plain white background, that says:
```
Warning: require(/var/www/html/vendor/composer/../../app/Helpers/paths.php): Failed to open stream: No such file or directory in /var/www/html/vendor/composer/autoload_real.php on line 78

Fatal error: Uncaught Error: Failed opening required '/var/www/html/vendor/composer/../../app/Helpers/paths.php' (include_path='.:/usr/local/lib/php') in /var/www/html/vendor/composer/autoload_real.php:78 Stack trace: #0 /var/www/html/vendor/composer/autoload_real.php(61): composerRequire8f7a6d8d2f1c0a8aeae36c27cc37399c('60a1cc465c72e1a...', '/var/www/html/v...') #1 /var/www/html/vendor/autoload.php(7): ComposerAutoloaderInit8f7a6d8d2f1c0a8aeae36c27cc37399c::getLoader() #2 /var/www/html/public/index.php(34): require('/var/www/html/v...') #3 {main} thrown in /var/www/html/vendor/composer/autoload_real.php on line 78
```
Solution:
```bash
# Go to php-fpm container:
cd .docker && docker-compose exec php-fpm sh
# In container:
cd html && composer dump-autoload
```