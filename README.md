# Basic PHP App

This project is a basic web application, built with PHP and MySQL.

## Requirements

- A local web server environment such as [XAMPP](https://www.apachefriends.org/index.html) or [WampServer](http://www.wampserver.com/en/)
- Web browser
- Git

## Installation

### 1. Installing a Local Web Server

You can use either XAMPP or WampServer to set up your local environment. Below are the instructions for both.

#### XAMPP

1. **Download XAMPP:**
   Visit the [XAMPP download page](https://www.apachefriends.org/index.html) and download the version for your operating system.

2. **Install XAMPP:**
   Follow the installation instructions to complete the setup.

3. **Start XAMPP:**
   Open the XAMPP Control Panel and start the `Apache` and `MySQL` services.

#### WampServer

1. **Download WampServer:**
   Visit the [WampServer download page](http://www.wampserver.com/en/) and download the version for your operating system.

2. **Install WampServer:**
   Follow the installation instructions to complete the setup.

3. **Start WampServer:**
   Open the WampServer control panel and start the `Apache` and `MySQL` services.

### 2. Database Setup

1. **Access phpMyAdmin:**
   Open your web browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).

2. **Create a new database:**
   - Click on `New` in the left-hand menu.
   - Enter the name `flota` for the database.
   - Select `utf8_general_ci` as the collation.
   - Click `Create`.

3. **Import the database schema:**
   - Select the `flota` database in the left-hand menu.
   - Go to the `Import` tab.
   - Click `Choose file` and select the `flota.sql` file that contains the database schema.
   - Click `Go` to import the schema.

### 3. Clone the Repository

Open a terminal and run the following commands:

```sh
$ git clone https://github.com/javilopezleza/basic-php-template.git
$ cd basic-php-template
```
### 4. Project setup

1. Move files to your web server directory:
  - For XAMPP: Copy all project files to the htdocs directory of XAMPP. For example:
```sh
cp -r * /path/to/xampp/htdocs/basic-php-template
```
Or manually

Note: Make sure to replace /path/to/xampp with the correct path to your XAMPP installation.

  - For WampServer: Copy all project files to the www directory of WampServer. For example:
```sh
$ cp -r * /path/to/wamp/www/basic-php-template
```
Or manually
Note: Make sure to replace /path/to/wamp with the correct path to your WampServer installation.

2. Configure database connection:
Open the functions.php file and ensure the database connection settings are correct:

```php
function conexion(){
    try {
        $conexion = new PDO(
            'mysql:host=localhost;dbname=flota', // host and database name
            'root', // username
            '', // password
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $conexion;
}
```

### 5. Run the Application

1. Open the application in the browser:

 - For XAMPP: Go to http://localhost/basic-php-template in your web browser.
 - For WampServer: Go to http://localhost/basic-php-template in your web browser.

2. Interact with the application:
You should now see the application's user interface and be able to manage vehicles from there.


### Notes

 - Ensure the Apache and MySQL services are running in XAMPP or WampServer before accessing the application.
 - If you encounter database connection issues, verify the settings in functions.php and ensure the credentials and database name are correct.

### License
This project is licensed under the MIT License.

```sql
This `README.md` provides instructions for setting up the local environment using either XAMPP or WampServer, creating a MySQL database, and running the PHP application. Adjust paths and configurations as needed for your specific setup.
```
