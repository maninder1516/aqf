Symfony - AQP Application
========================

Instruction for the Project are as follows:
1. Clone the code to your system.
git clone https://github.com/maninder1516/aqf.git

2. Go to project directory using terminal or command prompt.

3. Run "composer install" to download the dependencies.

4. Run application with "php app/console server:run" or create virtual host or run simply by placing in localhost folder.

5. Run "php app/console doctrine:schema:update --force" to gerate the database tables

6. Create Users and clients using running below commands in project root directory
php app/console app:create-user admin@aqf.com test 1
php app/console app:create-user client1@aqf.com test 2
php app/console app:create-user client2@aqf.com test 2

7. Login with login details and create missions for each.