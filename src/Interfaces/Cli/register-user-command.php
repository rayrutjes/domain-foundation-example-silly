<?php

use RayRutjes\DomainFoundation\Example\Application\Identity\Command\RegisterUserCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

// Register a new user.
$silly->command('user:register username', function ($username, InputInterface $input, OutputInterface $output) use ($commandGateway, $questionHelper) {

    // We validate the username.
    if (strlen($username) < 3) {
        throw new \RuntimeException('Username should contain at least 3 chars.');
    }

    // We ask and validate the password.
    $question = new Question('password: ');
    $question->setHidden(true);
    $question->setHiddenFallback(false);
    $question->setValidator(function ($password) {
        if (strlen($password) < 8) {
            throw new \RuntimeException('Password should contain at least 8 chars.');
        }

        return $password;
    });
    $password = $questionHelper->ask($input, $output, $question);

    // We send the command.
    $commandGateway->send(new RegisterUserCommand($username, $password));

    $output->writeln('The user has been registered.');

})->descriptions('Register a new user', [
    'username'   => 'The username for the user. Should contain more than 2 chars.'
]);
