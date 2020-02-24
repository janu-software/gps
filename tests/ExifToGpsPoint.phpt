<?php

/**
 * This file is part of the GPS
 * Copyright (c) 2019 Stanislav Janů (https://www.lweb.cz)
 */

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use JCode\GPS\Gps;
use JCode\GPS\GpsExifException;
use Tester\Assert;

Assert::exception(function () {
	Gps::exifCoordsToPoint([]);
}, GpsExifException::class);

$array = [
	'GPSLatitudeRef' => "N",
	'GPSLatitude' => [
		"49/1",
		"3/1",
		"663/100",
	],
	'GPSLongitudeRef' => "E",
	'GPSLongitude' => [
		"14/1",
		"25/1",
		"5622/100",
	],
];

$point = Gps::exifCoordsToPoint($array);
Assert::equal(49.0518417, $point->getLat());
Assert::equal(14.4322833, $point->getLng());