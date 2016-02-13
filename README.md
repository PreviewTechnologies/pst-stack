# PRO-BUCKET

##Installation

Just **git clone https://github.com/previewict/pst-stack**

and copy, paste **propel/propel.xml** with your database configuration. But don't change the DB name. If you change the DB name then the whole database thing needs to be re-generate that can brake the entire project. This step is necessary only 
for running propel migrate command if any of your team member update schema.

Now run **sudo chmod a+x propel_migreate.sh && sudo ./propel_migrate.sh** to upgrade or install your database.

Now finally you have to copy, paste the config.php file to configure your project.
 
 After that create the virtual host and you are ready to go.
 
###Migrating schema
`sudo ./propel_migrate.sh`
