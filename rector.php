<?php

declare(strict_types=1);

use Rector\Core\ValueObject\PhpVersion;
use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


return static function (ContainerConfigurator $containerConfigurator): void {
	// get parameters
	$parameters = $containerConfigurator->parameters();

	$parameters->set(Option::PATHS, [
		__DIR__ . '/src',
	]);

	$parameters->set(Option::AUTO_IMPORT_NAMES, true);
	$parameters->set(Option::ENABLE_CACHE, true);
	$parameters->set(Option::CACHE_DIR, __DIR__ . '/temp/rector');

	// Define what rule sets will be applied
	$parameters->set(Option::SETS, [
		SetList::PHP_80,
		SetList::CODE_QUALITY,
		SetList::NETTE_CODE_QUALITY,
		SetList::NETTE_UTILS_CODE_QUALITY,
		SetList::NETTE_RETURN_TYPES,
		SetList::NETTE_PARAM_TYPES,
		SetList::NETTE_30,
	]);

	$parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_80);

	$services = $containerConfigurator->services();
	$services->set(ReturnTypeDeclarationRector::class);
};
