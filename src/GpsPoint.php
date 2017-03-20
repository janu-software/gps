<?php
declare(strict_types=1);

namespace JCode\GPS;

use Nette;

class Point
{
	use Nette\SmartObject;

	/** @var float */
	private $lat;

	/** @var float */
	private $lng;

	/** @var string|null */
	private $address;

	const GREAT_CIRCLE_RADIUS = 6372.795;

	/**
	 * @param float|float[]
	 * @param float|string|null
	 * @param string|null
	 */
	public function __construct($lat, $lng = NULL, $address = NULL)
	{
		if (is_array($lat))
		{
			$address = $lng;
			$lng = $lat[0];
			$lat = $lat[1];
		}
		$this->lat = (float) $lat;
		$this->lng = (float) $lng;
		$this->address = empty($address) ? null : $address;
	}

	/**
	 * @return float
	 */
	public function getLat() : float
	{
		return $this->lat;
	}

	/**
	 * @return float
	 */
	public function getLng() : float
	{
		return $this->lng;
	}

	/**
	 * @return null|string
	 */
	public function getAddress() : string
	{
		return $this->address;
	}

	/**
	 * Calculates distance of two GPS coordinates
	 *
	 * @author Jakub Vrána
	 * @link   http://php.vrana.cz/vzdalenost-dvou-zemepisnych-bodu.php
	 *
	 * @param  Point
	 * @return float distance in metres
	 */
	public function getDistanceTo(Point $point)
	{
		return acos(
			cos(deg2rad($this->lat))*cos(deg2rad($this->lng))*cos(deg2rad($point->lat))*cos(deg2rad($point->lng))
			+ cos(deg2rad($this->lat))*sin(deg2rad($this->lng))*cos(deg2rad($point->lat))*sin(deg2rad($point->lng))
			+ sin(deg2rad($this->lat))*sin(deg2rad($point->lat))) * self::GREAT_CIRCLE_RADIUS * 1000;
	}
}