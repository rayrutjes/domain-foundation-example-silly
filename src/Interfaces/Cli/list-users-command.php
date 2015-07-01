<?php

use Symfony\Component\Console\Output\OutputInterface;

$silly->command('user:list', function (OutputInterface $output) use ($commandGateway) {


})->descriptions(
    'List all users'
);

