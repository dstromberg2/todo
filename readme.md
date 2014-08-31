## TODO app

[![Demo](http://labs.weberish.com/todo/)](http://labs.weberish.com/todo/)

A simple TODO application example

Utilizes Laravel framework and MySQL database on backend, and Twitter Bootstrap and jQuery frameworks on frontend



### Setup

To setup the application, follow the following steps:

1. Checkout git source to the appropriate server directory
2. Run "composer update" within root folder to install all vendor code (Composer must be installed for this, see guides elsewhere)
3. Create a MySQL database, and set up a user with permissions on this db
4. Rename "app/config/sample.database.php" to "app/confing/database.php", then update with appropriate MySQL credentials
5. Run "php artisan migrate" from the root folder to create the database structure
6. Update "app/config/app.php" with appropriate variables
7. Set up a symbolic link from your server's publically accessible web directory, pointed to this project's "public" directory
8. Set permissions on the app/storage directory (recursive) to allow read-write access for the web server
