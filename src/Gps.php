<?php
declare(strict_types=1);

namespace JCode\GPS;

use Nette;


class Gps
{
	use Nette\SmartObject;

	public const GREAT_CIRCLE_RADIUS = 6372.795;


	/**
	 * @param array $exif
	 *
	 * @return \JCode\GPS\GpsPoint
	 * @throws \JCode\GPS\GpsExifException
	 */
	public static function exifCoordsToPoint(array $exif): GpsPoint
	{
		if (!isset($exif['GPSLatitude'])) {
			throw new GpsExifException('Missing parameter GPSLatitude.');
		}
		if (!isset($exif['GPSLatitudeRef'])) {
			throw new GpsExifException('Missing parameter GPSLatitudeRef.');
		}
		if (!isset($exif['GPSLongitude'])) {
			throw new GpsExifException('Missing parameter GPSLongitude.');
		}
		if (!isset($exif['GPSLongitudeRef'])) {
			throw new GpsExifException('Missing parameter GPSLongitudeRef.');
		}

		return new GpsPoint(self::getGps($exif['GPSLatitude'], $exif['GPSLatitudeRef']), self::getGps($exif['GPSLongitude'], $exif['GPSLongitudeRef']));
	}


	/**
	 * @param array  $exifCoord
	 * @param string $hemi
	 *
	 * @return float
	 */
	private static function getGps(array $exifCoord, string $hemi): float
	{
		$degrees = count($exifCoord) > 0 ? self::gps2Num($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? self::gps2Num($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? self::gps2Num($exifCoord[2]) : 0;

		$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

		return round($flip * ($degrees + $minutes / 60 + $seconds / 3600), 7);
	}


	/**
	 * @param string $coordPart
	 *
	 * @return float
	 */
	private static function gps2Num(string $coordPart): float
	{
		$parts = explode('/', $coordPart);

		if (count($parts) <= 0) {
			return 0.0;
		}

		if (count($parts) === 1) {
			return (float) ($parts[0]);
		}

		return (float) ($parts[0]) / (float) ($parts[1]);
	}
}
