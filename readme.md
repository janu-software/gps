# GPS
GPS Point with useful detection and method.

[![Composer](https://github.com/janu-software/gps/actions/workflows/composer.yml/badge.svg)](https://github.com/janu-software/gps/actions/workflows/composer.yml)
[![Code style](https://github.com/janu-software/gps/actions/workflows/code_style.yml/badge.svg)](https://github.com/janu-software/gps/actions/workflows/code_style.yml)
[![Tester](https://github.com/janu-software/gps/actions/workflows/tester.yml/badge.svg)](https://github.com/janu-software/gps/actions/workflows/tester.yml)
[![PhpStan](https://github.com/janu-software/gps/actions/workflows/static_analysis.yml/badge.svg)](https://github.com/janu-software/gps/actions/workflows/static_analysis.yml)

[![Latest Stable Version](https://poser.pugx.org/stanislav-janu/gps/v/stable)](https://packagist.org/packages/stanislav-janu/gps)
[![Total Downloads](https://poser.pugx.org/stanislav-janu/gps/downloads)](https://packagist.org/packages/stanislav-janu/gps)
[![License](https://poser.pugx.org/stanislav-janu/gps/license)](https://packagist.org/packages/stanislav-janu/gps)
[![Coverage Status](https://coveralls.io/repos/github/janu-software/gps/badge.svg?branch=master)](https://coveralls.io/github/janu-software/gps?branch=master)

## Installation

    composer require stanislav-janu/gps

## Compatibility

| Version | PHP  | Nette Utils |
|---------|------|-------------|
| 4.0     | ^8.3 | ^4.0        |
| 3.0     | ^8.0 | ^4.0        |
| 2.1     | ^8.0 | ^3.2        |
| 2.0     | ^8.0 | ^3.0        |
| 1.1     | ^7.1 | ^2.4 ^3.0   |
| 1.0     | ^7.0 | ^2.4        |

## Usage

```php
use JanuSoftware\GPS\GpsPoint;
use JanuSoftware\GPS\GpsPointException;

try {
    $point = GpsPoint::from('49°3\'6.630"N, 14°26\'7.763"E');
    echo $point; // 49.0518417, 14.4354897
    echo $point->lat; // 49.0518417
    echo $point->lng; // 14.4354897
} catch (GpsPointException $exception) {
    echo $exception->getMessage();
}
```

### Accepted formats:
* OpenStreetMap URL
* Google Maps URL
* Mapy.com URL
* 49°3'6.630"N, 14°26'7.763"E
* N 49°3.11050', E 14°26.12938'
* 49.0518417N, 14.4354897E
* 49.0518417N,14.4354897E
* 49.0518417, 14.4354897
* 49.0518417,14.4354897
* 49.0518417 14.4354897
* -47.338388,-0.990228
* -47.338388 -0.990228

### Distance
```php
$point1 = GpsPoint::from('some coordinates');
$point2 = GpsPoint::from('some coordinates');
$distance =  $point1->distanceTo($point2); // distance in meters
```

### Google Maps Distance Matrix
```php
...
$distance = $point1->distanceTo($point2, 'Google Maps API key'); // distance in meters
```
