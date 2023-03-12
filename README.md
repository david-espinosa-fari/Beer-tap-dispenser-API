# Beer-tap-dispenser-API
Beer tap dispenser API

# Getting Started
The app live under folder webServer/App so If you want to use your own web server copy this folder(webServer/App) and point your server to /var/www/public in your configuration.
This file is an example of virtual host `webServer/config/apache/vhosts/pvportal.conf`. Under webServer/App do `composer install` to install 3rd party software dependencies. you will [need composer](https://getcomposer.org/download/)

1.	Software dependencies
      * [install](https://docs.docker.com/install/) docker
      * [install](https://docs.docker.com/compose/install/) docker-compose
2.	How to use
      * Clone project

            git clone 
            cp .env.dist .env
      
## Coverage Statistic
![img_1.png](img/img_1.png)
![img.png](img/img.png)
You can find the entire stadistics in 
    
    webServer/App/public/cover/index.html
## How to run test
enter in the container

    docker exec -i app php vendor/bin/phpunit --testdox

