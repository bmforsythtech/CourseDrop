Introduction:
This software is not intended to be a drop in installation.  It will require
customization to fit your environment.

Requires Web Server with:
Apache
MySQL
PHP

Built and Tested on:
CentOS 6.5
Apache 2.2
MySQL 5.1
PHP 5.3

Web App
Developed using the Foundation (ZURB) front-end framework (zurb.com).

Installation

-Copy files from /src to your web root.
-Create MySQL Database.
-Import SQL structure from /mysql/mysql.sql
-Modify config.php to match your environment

Files located in the root directory serve as the Model/Controller.  Files
located in the 'views' folder contain the HTML output.

Customization
Files to modify:
    config.php
    import.php
    views/header.php
    views/footer.php
    stylesheets/app.css

Data Feed
There are 6 files the web application is expecting:
    Users - All active accounts (Employees & Students)
    Instructors - List of courses and assigned instructors
    Students - List of courses and assigned students
    Courses - List of courses
    Divisions - List of courses and assigned divisions
    NoDrops - List of students not eligible to use this web application

Data Import
The file 'import.php' located in the 'cron' folder handles the import process.
This file looks for files in a specified directory, parses each file, and
inserts/updates the database as necessary.

There needs to be a cron job to execute this file hourly.

Database
See the 'MySQL' folder for the database structure.

Emails
All email verbiage is located in the functions/emails.php file.

Cron
The file 'cron/cron.php' is used to send email reminders.  There needs to be a
cron job to execute this file hourly.