Symfony - AQP Application
========================

What's inside?
--------------
The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * An AQFBundle used containing the CRUD operation for the mission entity;

  * CreateUserCommand to generate the user from the command line.

  * Twig as the configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.


For using this project follow the given instruction as below:

1. Clone the code to your system.
"git clone https://github.com/maninder1516/aqf.git"

2. Go to project directory using terminal or command prompt.

3. Run "composer install" to download the dependencies.

4. Run application with "php app/console server:run" or create virtual host or run simply by placing in localhost folder.

5. Run "php app/console doctrine:schema:update --force" to gerate the database tables

6. Create Users and clients using running below commands in project root directory
"php app/console app:create-user admin@aqf.com test 1"
"php app/console app:create-user client1@aqf.com test 2"
"php app/console app:create-user client2@aqf.com test 2"

7. Login with login details and create missions for each.