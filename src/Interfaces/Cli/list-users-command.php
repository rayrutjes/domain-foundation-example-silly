<?php

use RayRutjes\DomainFoundation\Example\Application\Identity\Query\FindClaimedUsernames;
use Symfony\Component\Console\Output\OutputInterface;

$silly->command('user:list', function (OutputInterface $output) use ($commandGateway, $app) {

    $query = new FindClaimedUsernames($app->pdo());
    $users = $query->execute();
    foreach ($users as $user) {
        $output->writeln($user['username']);
    }

})->descriptions(
    'List all usernames'
);

