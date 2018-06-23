# To do list - installation guide

## Technological requirements

To run application correctly, you have to use technologies listed below.

+ MySQL
+ PHP 7.1 >=
+ Apache (becouse of .htaccess)

## Migrations

In your phpmyadmin, run sql's from migration.sql file to build database structure.

## Configuration

### MySQL

To setup database connection, please pass your credentials to App.php file (line 31), like in example

```
$handler = mysqli_connect("127.0.0.1", "root", "", "flightfox");
```

### Apache web root

To run application successfully, you need to point your apache host directory, to web directory.

```
    DocumentRoot "{full_path_to_app}/web"
    <Directory "{full_path_to_app}/web">
            AllowOverride all
            Require all granted
    </Directory>
```


## Application is ready to use.
