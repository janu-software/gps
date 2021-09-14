<?php

/**
 * https://github.com/janu-software/gps
 *
 * Copyright (c) 2019 Stanislav Janů (https://janu.software)
 */

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use JanuSoftware\GPS\GpsPoint;
use Tester\Assert;

$object = GpsPoint::from('https://mapy.cz/zakladni?x=14.4423873&y=49.0505547&z=17&source=base&id=1701560');
Assert::same(49.0505547, $object->lat);
Assert::same(14.4423873, $object->lng);

$object = GpsPoint::from('https://www.google.cz/maps/place/St%C3%A1tn%C3%AD+z%C3%A1mek+Hlubok%C3%A1/@49.0545128,14.433819,16z/data=!4m5!3m4!1s0x4773524ae3e57e19:0xcf9370935230ff40!8m2!3d49.0511241!4d14.441594');
Assert::same(49.0545128, $object->lat);
Assert::same(14.433819, $object->lng);

$array = [
	'49.0506117 14.4420556',
	'49.0506117, 14.4420556',
	'49.0506117N, 14.4420556E',
	'49.0506117N 14.4420556E',
	'N 49°3.03670\', E 14°26.52333\'',
	'N 49°3.03670\' E 14°26.52333\'',
	'49°3\'2.202"N, 14°26\'31.400"E',
	'49°3\'2.202"N 14°26\'31.400"E',
];

foreach ($array as $value) {
	$object = GpsPoint::from($value);
	$diffLat = $object->lat - 49.0506117;
	$diffLng = $object->lng - 14.4420556;

	Assert::true($diffLat <= 0.000001 && $diffLat >= -0.000001);
	Assert::true($diffLng <= 0.000001 && $diffLng >= -0.000001);
}
