<?php

use RayRutjes\DomainFoundation\Example\Application\Identity\Command\ChangeUsernameCommand;
use Symfony\Component\Console\Output\OutputInterface;

// Register a new user.
$silly->command('user:change_username user_id new_username', function ($user_id, $new_username, OutputInterface $output) use ($commandGateway) {

    // We validate the username.
    if (strlen($new_username) < 3) {
        throw new \RuntimeException('Username should contain at least 3 chars.');
    }
    // We send the command.
    $commandGateway->send(new ChangeUsernameCommand($user_id, $new_username));

    $output->writeln('The username was changed.');

})->descriptions(
    'Change a user\'s username',
    [
        'user_id'      => 'The user identifier.',
        'new_username' => 'The new username for the user.',
    ]
);

