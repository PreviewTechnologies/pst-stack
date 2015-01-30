# PST-STACK

PST (Propel ORM - Slim Framework - Twig Template Engine) Stack in PHP is the most sophisticated stack to quickly build any kinds of PHP applicaiton. This open source application will let you create your application within maximum 120 seconds (2 minutes) without any hassle.
This stack was first created to quickly build any prototype or any quick but powerful web applicaiton within hour or day and after that I made it open source to make your work more easier.


## Install Composer

If you have not installed Composer, do that now. I prefer to install Composer globally in `/usr/local/bin`, but you may also install Composer locally in your current working directory. For this tutorial, I assume you have installed Composer locally.

<http://getcomposer.org/doc/00-intro.md#installation>

## Install the Application

After you install Composer, run this command from the directory in which you want to install your new Propel-Slim-Twig Application stack.

    php composer.phar create-project previewict/pst-stack [your-app-name]

Replace <code>[your-app-name]</code> with the desired directory name for your new application. You'll want to:
* Point your virtual host document root to your new application's `public/` directory.
* Create a new directory 'tmp' in the root of your application and make it writable.

## Propel Configure
* Create a database (yourdbname) and run the default schema from **propel/generated-sql/schema.sql**.
* Now copy/paste **generated-conf/config.sample** and rename it to config.php and then change your mysql database credentials. And replace all `yourdbname` to your `databasename`.

If you want to change your database structure or configuration just you have to work with prople/schema.xml, build.properties, runtime-conf.xml

In schema.xml file go to line #2 and change `database name = "databasename"`
In build.properties file go to line #1 change `propel.project = "databasename"`
In runtime-conf.xml file go to line #4 and #5 and change `<datasources default="databasename"><datasource id="databasename">`

now run the following command

```bash
cd /var/www/html/yourprojectdirectory
cd propel
sudo ../vendor/propel/propel/bin/propel sql:build
sudo ../vendor/propel/propel/bin/propel model:build
```

That's it! Now go build something cool. Go to your browser and type your application host (according to your virtual host). First it will point you to **http://your-virtual.host/login**

## How to Contribute

### Pull Requests

1. Fork the Propel-Slim-Twig Application Stack
2. Create a new branch for each feature or improvement
3. Send a pull request from each feature branch to the **develop** branch

It is very important to separate new features or improvements into separate feature branches, and to send a
pull request for each branch. This allows us to review and pull in new features or improvements individually.

### Style Guide

All pull requests must adhere to the [PSR-2 standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).
