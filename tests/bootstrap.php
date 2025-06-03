<?php

/**
 * This file is part of the GPS
 * Copyright (c) 2019 Stanislav Janů (https://www.lweb.cz)
 */

declare(strict_types=1);
use Tester\Environment;

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .
if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}

Environment::setup();
