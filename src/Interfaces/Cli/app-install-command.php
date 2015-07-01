<?php

use Symfony\Component\Console\Output\OutputInterface;

$silly->command('app:install', function (OutputInterface $output) use ($commandGateway, $app) {

    $app->install();

    $output->writeln('The database tables were created.');

})->descriptions(
    'Create the database tables'
);

