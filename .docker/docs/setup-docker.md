# App set up with Docker & docker-compose

In `.docker` directory:
```bash
$ docker-compose -up
```
After containers build, you can check if the're running:
```bash
$ docker stats
# Output should like smth like this:
CONTAINER ID   NAME                CPU %     MEM USAGE / LIMIT     MEM %     NET I/O           ...
de8757813339   gymmy-api_nginx     0.00%     4.355MiB / 3.841GiB   0.11%     6.19kB / 4.32kB   ...
6946f3920122   gymmy-api_php-fpm   0.01%     16.99MiB / 3.841GiB   0.43%     2.79kB / 2.33kB   ...
934e8042947c   gymmy-api_mariadb   0.02%     60.88MiB / 3.841GiB   1.55%     1.66kB / 0B       ...
1586f9fda18d   gymmy-api_redis     0.27%     2.121MiB / 3.841GiB   0.05%     1.66kB / 0B       ...
```
You can also check if containers are running in Docker Desktop app. There you can access shells of each container. Select shell icon of `gymmy-api_mariadb` to acces it's command prompt. Then:
```bash
$ mysql -p
Type password:
```
Use password `secret`.
After you enter mariadb server, you can create new database:
```bash
MariaDB [(none)]> create database gymmy_dev;
Query OK, 1 row affected (0.002 sec)
```
Now, when database is created, you can leave mariadb container shell.
Head to projects root directory, and there, copy contents of `.env.example` file to new one, and call it `.env`.
Next, update database related values:
```bash
DB_CONNECTION=mysql
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=gymmy_dev
DB_USERNAME=root
DB_PASSWORD=secret
```
Save changes and move to Docker Desktop app, then run `gymmy-api_php-fpm` container's command prompt:
```bash
# Refresh cached app config - should be executed after every change to .env file
php artisan config:cache
# Generate secret app key, used as encryption "seed"
php artisan key:generate
# Migrate database structure
php artisan migrate
# Run database seeders (filling with fake generated data)
php artisan db:seed
# Run tests to make sure app is fully functional in current environment
```
Seeders will create api user, which can be used in postman.
Go to `/Auth/Login` request, and fill body with raw JSON:
```json
{
    "email": "test@gmail.com",
    "password": "password"
}
```
Returned token should be automatically set as `Bearer token` for current requests collection,
if not, hit the "eye" icon on the right and set current value of `api_token` to received token.
Now, you should be able to access other api resources through protected endpoints.
