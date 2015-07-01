Event Sourcing Example Based On Silly
-------------------------------------

Please discover in this package a very simple application which illustrates the use of 
the [rayrutjes/domain-foundation](https://github.com/RayRutjes/domain-foundation) library.

We will enhance this example along the road, feel free to suggest features that would illustrate
things as best as possible.


Installation
------------

Install via composer
```bash
$ composer require rayrutjes/domain-foundation-example-silly
```

Update your database credentials into RayRutjes\DomainFoundation\Example\Application.
*Actually, we have only tested MySQL*

Create your database.

Set up your event store schema:
```bash
$ php src/Interfaces/Cli/app.php app:install
```

Run Commands
------------

This example is based on the very nice library [Silly](https://github.com/mnapoli/silly) which itself is based on the Symfony console.

To see what commands are available, simply run :
```bash
$ php src/Interfaces/Cli/app.php
```

To run a specific command, you can run :
```bash
$ php src/Interfaces/Cli/app.php user:register barbaz
```
