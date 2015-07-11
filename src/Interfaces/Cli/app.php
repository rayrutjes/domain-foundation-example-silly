<?php

require_once __DIR__.'/../bootstrap.php';

$commandGateway = $app->commandGateway();

$silly = new Silly\Application();
$helpers = $silly->getHelperSet();

$questionHelper = $helpers->get('question');

require_once 'app-install-command.php';
require_once 'register-user-command.php';
require_once 'change-username-command.php';
require_once 'change-user-password-command.php';
require_once 'list-users-command.php';


$silly->run();
