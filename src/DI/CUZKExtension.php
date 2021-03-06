<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\DI;

use AsisTeam\CUZK\Client\CiselnikClientFactory;
use AsisTeam\CUZK\Client\SestavyClientFactory;
use AsisTeam\CUZK\Client\UcetClientFactory;
use Nette\DI\CompilerExtension;

class CUZKExtension extends CompilerExtension
{

	/** @var mixed[] */
	public $defaults = [
		'user' => '',
		'pass' => '',
		'test' => true,
	];

	/**
	 * @inheritDoc
	 */
	public function loadConfiguration(): void
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('client_factories.ciselnik'))
			->setFactory(CiselnikClientFactory::class, [$config['user'], $config['pass'], $config['test']]);

		$builder->addDefinition($this->prefix('client_factories.sestavy'))
			->setFactory(SestavyClientFactory::class, [$config['user'], $config['pass'], $config['test']]);

		$builder->addDefinition($this->prefix('client_factories.ucet'))
			->setFactory(UcetClientFactory::class, [$config['user'], $config['pass'], $config['test']]);
	}

}
