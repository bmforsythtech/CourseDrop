<h1>CourseDrop</h1>

Requires Web Server with:
<ul>
<li>Apache (or equivalent)</li>
<li>MySQL</li>
<li>PHP</li>
</ul>

Built and Tested on:
<ul>
<li>CentOS 6.5</li>
<li>Apache 2.2</li>
<li>MySQL 5.1</li>
<li>PHP 5.3</li>
</ul>

<h3>Web App</h3>

Developed using the Foundation (ZURB) front-end framework (http://foundation.zurb.com).

<h3>Installation</h3>

<ul>
<li>Navigate to your web root directory.
<li>Extract files or clone from git
    <ul>
    <li>$ git clone https://github.com/bmforsythtech/CourseDrop</li>
    </ul>
<li>Create MySQL database (Ex. coursedrop).
<li>Import the table structure from the file install/mysql.sql to your database.
    <ul>
    <li>$ mysql -u username -p -h localhost DATA-BASE-NAME &lt; install/mysql.sql</li>
    </ul>
<li>Copy <b>config.example.php</b> to <b>config.php</b>.</li>
<li>Modify <b>config.php</b> to your environment. Be sure to add your Active Directory account to the admin list.</li>
<li>Open up browser window and navigate to your web server and path where you installed (Ex. www.yourschool.edu/CourseDrop)</li>
<li>Attempt to log in using an Active Directory login.  This will allow you to test the LDAP integration.</li>
<li>After successful login, run the import script to load sample data into the database.</li>
    <ul>
    <li>$ php cron/import.php</li>
    </ul>
<li>In the web interface, click on the "Admin" link in the header menu.</li>
<li>Type in <b>0000006</b> in the switch to user text box and click <b>Switch User</b>.  This allows you to emulate your session as another user.  By doing this, you are now viewing the course drop system as if you were the student with the id of 0000006.  Because of the sample data, you should now see the drop form as if you were the student, and one enrollment listed, <b>ACA-085-800B</b>.  You can test the drop process via this method.</li>
<li>You will now need to customize the code to fit your environment.</li>
</ul>

<h3>Customization</h3>

Files to modify:
<ul>
<li>config.php</li>
<li>views/*</li>
<li>stylesheets/app.css</li>
<li>functions/email.php</li>
</ul>

Files located in the root directory serve as the Model/Controller.  Files
located in the views folder contain the HTML output.

<h3>Data Feed</h3>

There are 6 files the web application is expecting:
<ul>
<li>Users - All active accounts (Employees & Students)</li>
<li>Instructors - List of courses and assigned instructors</li>
<li>Students - List of courses and assigned students</li>
<li>Courses - List of courses</li>
<li>Divisions - List of courses and assigned divisions</li>
<li>NoDrops - List of students not eligible to use this web application</li>
</ul>

Example data is included in the import folder.

Idealy you would want these files to be updated frequently.

<h3>Data Import</h3>

The file 'import.php' located in the 'cron' folder handles the import process.
This file looks for files in a specified directory, parses each file, and
inserts/updates the database as necessary.

There needs to be a cron job to execute this file hourly.

<h3>Database</h3>

See the 'install/mysql.sql' file for the database structure.

<h3>Emails</h3>

All email verbiage is located in the functions/emails.php file.

<h3>Maintenance</h3>

The file 'cron/cron.php' is used to send email reminders.  There needs to be a
cron job to execute this file hourly.

<h3>Support</h3>

Support is not provided.  Use at your own risk.
