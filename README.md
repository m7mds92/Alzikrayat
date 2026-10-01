## Project name: Alzikrayat 

## Description:
Alzikrayat is a custom-engineered photo-sharing web application built from scratch without relying on external web frameworks. It provides a secure platform where users can register, upload and manage photo galleries, post comments, and toggle dynamic grid layouts while enforcing strict MVC architecture and defense-in-depth security.

## Technologies:
* **Language & Architecture:** PHP 8.x 
* **Database:** MySQL (PDO Singleon)
* **Frontend:** HTML5, CSS3, JavaScript (ES6), Bootstrap 5
* **Server Environment:** Apache with `mod_rewrite` (XAMPP)

## How to Run:

   ### Prerequisites
      * [XAMPP](https://www.apachefriends.org/)
      * PHP 8.0 or higher
   
   ### Setup Steps
      Place the project folder inside the web server's root directory:
       `C:/xampp/htdocs/alzikrayat`
   
   1. **Database Setup:**
      * Open **phpMyAdmin** (`http://localhost/phpmyadmin/`).
      * Create a new database named `alzikrayat_db`.
      * Select the database and import the `schema.sql` file provided in the repository root.
   
   2. **Configure Database Connection:**
        ```
            define('DB_HOST', 'localhost');
            define('DB_NAME', 'alzikrayat_db');
            define('DB_USER', 'root');
            define('DB_PASS', '');
        ```
   
   3. **Run Application:**
      * Start Apache and MySQL in XAMPP Control Panel.
      * Open the browser and navigate to:
        `http://localhost/alzikrayat/public/`

## Student: Mohamed Sharaf El-din