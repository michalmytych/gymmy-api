# Setup
___
### Running project on Windows
The easiest way to set up this project is to use XAMPP - a popular package which contains Apache WWW server, MariaDB and PHP language.
You can download it from [here](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.17/). Second thing which will be needed is Composer, a package manager for PHP language. 
[Here](https://thecodedeveloper.com/install-composer-windows-xampp/) you can find tutorial on how to install it to make it work
with XAMPP. You should use [Composer 2](https://getcomposer.org/download/).
<div></div>
After you're done installing XAMPP and composer, you should check if Composer is available to you as CLI:

```bash
composer --version
```
Output of this command should look similarly to this:
```bash
Composer version 2.2.7 2022-02-25 11:12:27
```
Now you can set up this project on your local machine:

* Clone repository to XAMPP DocumentRoot directory (by default it's C:\xampp\htdocs\)
* Go to project root directory:
```bash 
cd gymmy
```
* Install project PHP dependencies using Composer:
```bash
composer install 
```
* After installation is finished it's time to configure application.
* All environment-related configuration variables in Laravel applications are stored in .env file, which isn't included
in code repository. To be able to fully configure application, you need to copy file `.env.example` and fill it with proper
values.

WIP