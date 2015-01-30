# PST-STACK

PST (Propel ORM - Slim Framework - Twig Template Engine) Stack in PHP is the most sophisticated stack to quickly build any kinds of PHP applicaiton. This open source application will let you create your application within maximum 120 seconds (2 minutes) without any hassle.
This stack was first created to quickly build any prototype or any quick but powerful web applicaiton within hour or day and after that I made it open source to make your work more easier.


## Install Composer

If you have not installed Composer, do that now. I prefer to install Composer globally in `/usr/local/bin`, but you may also install Composer locally in your current working directory. For this tutorial, I assume you have installed Composer locally.

<http://getcomposer.org/doc/00-intro.md#installation>

## Install the Application

After you install Composer, run this command from the directory in which you want to install your new Propel-Slim-Twig Application stack.

    sudo composer create-project previewict/pst-stack [your-app-name]

Replace <code>[your-app-name]</code> with the desired directory name for your new application. You'll want to:
* Point your virtual host document root to your new application's `public/` directory.
* create a database
* Need to configure Propel and generate it's ORM classes. For now copy/paste `propel.sample`, `runtime-conf.sample`, `schema.sample` and rename it to `propel.ini`, `runtime-conf.xml`, `schema.xml`
* Replace all `yourdbname` in `propel.ini`, `runtime-conf.xml` and `schema.xml` file with your new database name. Also replace all `yourdbusename` with your database username and `yourdbpassword` with your database password.
* Execute `propel/schema.xml` in your database
* Now need to generate Propel ORM classes by the following command
```bash
# go into your project root (/var/www/yourprojectdirectory)
cd /var/www/yourprojectdirectory
cd propel
sudo ../vendor/propel/propel/bin/propel sql:build
sudo ../vendor/propel/propel/bin/propel model:build
sudo ../vendor/propel/propel/bin/propel config:convert
```
* Again go to your project root and make `/tmp` writable
```bash
cd /var/www/yourprojectdirectory
sudo chmod 777 tmp/ -R
```

That's it! Now go build something cool. Go to your browser and type your application host (according to your virtual host). First it will point you to **http://your-virtual.host/login**. You can signup and login into the application by yourself.

## How to Contribute

### Pull Requests

1. Fork the Propel-Slim-Twig Application Stack
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **develop** branch

It is very important to separate new features or improvements into separate feature branches, and to send a
pull request for each branch. This allows us to review and pull in new features or improvements individually.

### Style Guide

All pull requests must adhere to the [PSR-2 standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).
