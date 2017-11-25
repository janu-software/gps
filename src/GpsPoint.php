<?php declare(strict_types=1);

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
	 * @param \JCode\GPS\Point $point
	 * @param string           $google_api_key
	 *
	 * @return float
	 */
	public function getDistanceTo(Point $point, string $google_api_key) : float
	{
		try {
			$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.str_replace(',', '.', $this->getLat()).','.str_replace(',', '.', $this->getLng()).'&destinations='.str_replace(',', '.', $point->getLat()).','.str_replace(',', '.', $point->getLng()).'&key='.$google_api_key;
			$result = @file_get_contents($url);
			$result = Nette\Utils\Json::decode($result);
			if($result->status === 'OK' && $result->rows[0]->elements[0]->status === 'OK')
				return (float) $result->rows[0]->elements[0]->distance->value;

		} catch (Nette\Utils\JsonException $e) {}

		/**
		 * @author Jakub Vrána
		 * @link   http://php.vrana.cz/vzdalenost-dvou-zemepisnych-bodu.php
		 */
		return acos(
			cos(deg2rad($this->lat))*cos(deg2rad($this->lng))*cos(deg2rad($point->lat))*cos(deg2rad($point->lng))
			+ cos(deg2rad($this->lat))*sin(deg2rad($this->lng))*cos(deg2rad($point->lat))*sin(deg2rad($point->lng))
			+ sin(deg2rad($this->lat))*sin(deg2rad($point->lat)))*Gps::GREAT_CIRCLE_RADIUS*1000;
	}
}