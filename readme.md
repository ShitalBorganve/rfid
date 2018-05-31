## BUILT WITH: Codeigniter
GITHUB REPOSITORY: https://github.com/jpgulayan460103/rfid.git

## REQUIREMENTS
- git
- php 5.6
- xampp/wamp/php server

## INSTALLATION
1. clone github repo:
```
git clone https://github.com/jpgulayan460103/rfid.git
```

2. copy .htaccess file
```
copy .htaccess.ex .htaccess
```
3. copy configuration files (application/config)
```
copy config.ex.php config.php
copy database.ex.php database.php
```
4. Import rfid.sql file

5. Update the client_name, apicode and school_year columns in app_config table

## DEFAULT ADMIN ACCOUNT (http://domain.com/admin)
username: admin<br>
password: admin

## DEFAULT GATE PASSWORD (http://domain.com/gate)
password: admin<br>

## DEFAULT JBTECH ACCOUNT (http://domain.com/gate)
username: admin<br>
password: admin<br>
***JBTECH ACCOUNT is for information of students and teachers for ID**<br>

## SWITCHING SCHOOL YEAR (NEW DATABASE) FEATURE
1. Create new database
2. Copy the old database to the new
3. Truncate all tables except:
    - admins
    - app_config
    - jbtech
4. Update school_year column in app_config
5. Add new database group in application/config/database.php (see codeigniter docs)
6. Insert the new database group as value of databases key in settings/database.json
7. Update the value of **$db['database_group']['school_year']** of the new database group
