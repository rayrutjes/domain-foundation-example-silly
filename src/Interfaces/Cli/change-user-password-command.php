<?php

use RayRutjes\DomainFoundation\Example\Application\Identity\Command\RegisterUserCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

$silly->command('user:change_password user_id', function ($user_id, InputInterface $input, OutputInterface $output) use ($commandGateway, $questionHelper) {

    // We ask and validate the password.
    $question = new Question('New password: ');
    $question->setHidden(true);
    $question->setHiddenFallback(false);
    $question->setValidator(function ($newPassword) {
        if (strlen($newPassword) < 8) {
            throw new \RuntimeException('Password should contain at least 8 chars.');
        }

        return $newPassword;
    });

    $newPassword = $questionHelper->ask($input, $output, $question);

    // We send the command.
    $commandGateway->send(new RegisterUserCommand($user_id, $newPassword));

    $output->writeln('The user\'s password has been changed.');

})->descriptions('Change a user\'s password', [
    'user_id'   => 'The identifier of the user.'
]);
