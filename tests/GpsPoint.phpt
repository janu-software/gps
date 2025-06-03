<?php

/**
 * https://github.com/janu-software/gps
 *
 * Copyright (c) 2019 Stanislav Janů (https://janu.software)
 */

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use JanuSoftware\GPS\GpsExifException;
use JanuSoftware\GPS\GpsPoint;
use JanuSoftware\GPS\GpsPointException;
use Tester\Assert;

$object = GpsPoint::from('https://mapy.cz/zakladni?x=14.4423873&y=49.0505547&z=17&source=base&id=1701560');
Assert::same(49.0505547, $object->lat);
Assert::same(14.4423873, $object->lng);

$object = GpsPoint::from('https://mapy.com/cs/zakladni?source=firm&id=2432424&x=14.4423873&y=49.0505547&z=17');
Assert::same(49.0505547, $object->lat);
Assert::same(14.4423873, $object->lng);

$object = GpsPoint::from('https://www.google.cz/maps/place/St%C3%A1tn%C3%AD+z%C3%A1mek+Hlubok%C3%A1/@49.0545128,14.433819,16z/data=!4m5!3m4!1s0x4773524ae3e57e19:0xcf9370935230ff40!8m2!3d49.0511241!4d14.441594');
Assert::same(49.0545128, $object->lat);
Assert::same(14.433819, $object->lng);

$object = GpsPoint::from('https://www.openstreetmap.org/search?lat=49.050850&lon=14.441512&zoom=18#map=18/49.050901/14.441534');
Assert::same(49.050850, $object->lat);
Assert::same(14.441512, $object->lng);

$object = GpsPoint::from('https://www.openstreetmap.org/relation/444348#map=18/49.050897/14.441507');
Assert::same(49.050897, $object->lat);
Assert::same(14.441507, $object->lng);

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

Assert::exception(function () {
	GpsPoint::from('abc');
}, GpsPointException::class, 'Nothing detected in abc');

Assert::same('49.0506117,14.4420556', (string) GpsPoint::from('49.0506117 14.4420556'));

Assert::same(824.802139174179, GpsPoint::from('49.0506117 14.4420556')->distanceTo(GpsPoint::from('49.04347409974172, 14.445124035085259')));
Assert::same(824.802139174179, GpsPoint::from('49.0506117 14.4420556')->distanceTo(GpsPoint::from('49.04347409974172, 14.445124035085259'), 'WRONG_API_KEY'));

$object = GpsPoint::fromExifCoords([
	'GPSLatitudeRef' => 'N',
	'GPSLatitude' => [
		'49/1',
		'36991/1000',
		'0/1',
	],
	'GPSLongitudeRef' => 'E',
	'GPSLongitude' => [
		'14/1',
		'88376/10000',
		'0/1',
	],
	'GPSAltitude' => '566/1',
]);
Assert::same(49.6165167, $object->lat);
Assert::same(14.1472933, $object->lng);

$object = GpsPoint::fromExifCoords([
	'GPSLatitudeRef' => 'N',
	'GPSLatitude' => [
		'49',
		'36991/1000',
	],
	'GPSLongitudeRef' => 'E',
	'GPSLongitude' => [
		'14',
		'88376/10000',
	],
	'GPSAltitude' => '566/1',
]);
Assert::same(49.6165167, $object->lat);
Assert::same(14.1472933, $object->lng);

$object = GpsPoint::fromExifCoords([
	'GPSLatitudeRef' => 'N',
	'GPSLatitude' => 49.6165167,
	'GPSLongitudeRef' => 'E',
	'GPSLongitude' => 14.1472933,
	'GPSAltitude' => '566/1',
]);
Assert::same(49.6165167, $object->lat);
Assert::same(14.1472933, $object->lng);

Assert::exception(function () {
	GpsPoint::fromExifCoords([
		'GPSLatitude' => [
			'49/1',
			'36991/1000',
			'0/1',
		],
		'GPSLongitudeRef' => 'E',
		'GPSLongitude' => [
			'14/1',
			'88376/10000',
			'0/1',
		],
		'GPSAltitude' => '566/1',
	]);
}, GpsExifException::class, 'Missing parameter GPSLatitudeRef.');

Assert::exception(function () {
	GpsPoint::fromExifCoords([
		'GPSLatitudeRef' => 'N',
		'GPSLongitudeRef' => 'E',
		'GPSLongitude' => [
			'14/1',
			'88376/10000',
			'0/1',
		],
		'GPSAltitude' => '566/1',
	]);
}, GpsExifException::class, 'Missing parameter GPSLatitude.');

Assert::exception(function () {
	GpsPoint::fromExifCoords([
		'GPSLatitudeRef' => 'N',
		'GPSLatitude' => [
			'49/1',
			'36991/1000',
			'0/1',
		],
		'GPSLongitude' => [
			'14/1',
			'88376/10000',
			'0/1',
		],
		'GPSAltitude' => '566/1',
	]);
}, GpsExifException::class, 'Missing parameter GPSLongitudeRef.');

Assert::exception(function () {
	GpsPoint::fromExifCoords([
		'GPSLatitudeRef' => 'N',
		'GPSLatitude' => [
			'49/1',
			'36991/1000',
			'0/1',
		],
		'GPSLongitudeRef' => 'E',
		'GPSAltitude' => '566/1',
	]);
}, GpsExifException::class, 'Missing parameter GPSLongitude.');
