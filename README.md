# 750words

This project is based on Julia Cameron's _Morning Pages_, as she proposed it in her The Artist's Way book. The project born as an exercise to learn about NoSQL databases  (MongoDB) while developing something simple and useful. From I liked what I built, I wish to keep it open at [750palabras.alvaroremesal.com](http://750palabras.alvaroremesal.com) and keep the source code open for anyone who wants to learn about NoSQL from PHP.

## Framework

750words use the [CodeIgniter framework](http://codeigniter.com/). It's a small and lightweight PHP5 framework, all of its code is within the project.You need PHP5.3 or above to run 750words.

## Language

Since I'm spanish, all layout texts are written in spanish. I'll add multilanguage support as soon as posible. All code has been written in english.

## Installation

### Getting project

You can download the project using Git or with direct download. Put it in any path accesible from Apache (or your favorite webserver) and config a VirtualHost for it, poiting it to `/public` directory. For example, a VirtualHost for Apache:

    <VirtualHost *:80>
        ServerName 750words.example.com

        DirectoryIndex index.php index.html index.htm

        DocumentRoot /var/www/vhosts/750words/public

        <Directory /var/www/vhosts/750words/public/>
           Options ExecCGI +FollowSymLinks
           AllowOverride All
           order allow,deny
           allow from all
           AddHandler php5-script .php
           AddHandler fcgid-script .fcgi
        </Directory>

    </VirtualHost>

And then reload Apache. 

### Installing MongoDB

You must have installed MongoDB in your system. It has binary packages for a wide number of OS, so you probably you'll can install it easily. Once installed, start the server, by example:

    sudo service mongodb start

MongoDB creates data structure automagically, so there is no data sources or scripts to run. Just install and start the server.

### Setup config files

There are just two config files to setup:

1. `/application/config/mongo.php`: write your server (probably `localhost`) and the name of database.
2. `/application/config/email.php`: you must setup all of the basic email configuration: SMTP host, port, user and password.
