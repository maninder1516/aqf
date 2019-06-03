<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use AppBundle\Entity\User;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
	        // Set the name of the command (the part after "app/console")
	        ->setName('app:create-user')

	        // Set the short description shown while running "php app/console list"
	        ->setDescription('Creates a new user.')

	        // Set the full command description shown when running the command with
	        // the "--help" option
	        ->setHelp('This command allows you to create a user...')

	        // configure an argument
        	->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')

        	->addArgument('password', InputArgument::REQUIRED, 'The password of the user.')

        	->addArgument('role', InputArgument::REQUIRED, 'The role of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
	        'User Creator',
	        '============',
	        '',
	    ]);

        // Retrieve the argument value using getArgument()
	    $username = $input->getArgument('username');
	    $password = $input->getArgument('password');
	    $role = $input->getArgument('role');

	    // Create the User
        $user = new User;
	    $user->setUsername($username);
	    $user->setRole($role);

	    $encoder = $this->getContainer()->get('security.password_encoder');
		$encodedPassword = $encoder->encodePassword($user, $password);
        // $encodedPassword = md5($password);
        $user->setPassword($encodedPassword);

	    // Save the User
	    $em = $this->getContainer()->get('doctrine')->getManager();
	    $em->persist($user);
	    $em->flush();


	    // Outputs the messages 
	    $output->writeln('Username: '.$username);
	    $output->writeln('Password: '.$password);
	    $output->writeln('Role: '.$role);
    }
}