# GPS
GPS Point with useful detection and method.

[![Build Status](https://travis-ci.org/stanislav-janu/gps.svg?branch=master)](https://travis-ci.org/stanislav-janu/gps)
[![Latest Stable Version](https://poser.pugx.org/stanislav-janu/gps/v/stable)](https://packagist.org/packages/stanislav-janu/gps)
[![Total Downloads](https://poser.pugx.org/stanislav-janu/gps/downloads)](https://packagist.org/packages/stanislav-janu/gps)
[![Latest Unstable Version](https://poser.pugx.org/stanislav-janu/gps/v/unstable)](https://packagist.org/packages/stanislav-janu/gps)
[![License](https://poser.pugx.org/stanislav-janu/gps/license)](https://packagist.org/packages/stanislav-janu/gps)

## Installation

    composer require stanislav-janu/gps

## Usage

```php
try {
    $point = \JCode\GPS\GpsPoint::from('49°3\'6.630"N, 14°26\'7.763"E');
    echo $point; // 49.0518417, 14.4354897
    echo $point->lat; // 49.0518417
    echo $point->lng; // 14.4354897
} catch (\JCode\GPS\GpsPointException $exception) {
    echo $exception->getMessage();
}
```

### Accepted formats:
* Google maps URL
* Mapy.cz URL
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
$point1 = \JCode\GPS\GpsPoint::from('some coordinates');
$point2 = \JCode\GPS\GpsPoint::from('some coordinates');
$distance =  $point1->distanceTo($point2); // distance in meters
```

### Google Maps Distance Matrix
```php
...
$distance = $point1->distanceTo($point2, 'Google Maps API key'); // distance in meters
```