<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;


return static function (RectorConfig $rectorConfig): void {
	$rectorConfig->paths([
		__DIR__ . '/src',
	]);

	$rectorConfig->importNames();
	$rectorConfig->parallel();
	$rectorConfig->cacheDirectory(__DIR__ . '/temp/rector');

	// Define what rule sets will be applied
	$rectorConfig->import(LevelSetList::UP_TO_PHP_83);
	$rectorConfig->import(SetList::CODE_QUALITY);
	$rectorConfig->import(SetList::CODING_STYLE);
	$rectorConfig->import(SetList::TYPE_DECLARATION);
	$rectorConfig->import(SetList::STRICT_BOOLEANS);
};
