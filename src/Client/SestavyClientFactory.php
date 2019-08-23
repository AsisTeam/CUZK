<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

final class SestavyClientFactory extends AbstractCUZKClientFactory
{

	private const WSDL = 'sestavy_v28.wsdl';

	/** @var string */
	private $user;

	/** @var string */
	private $pass;

	public function __construct(string $user, string $pass = '', bool $test = true)
	{
		$this->user = $user;
		$this->pass = $pass;

		parent::__construct($test);
	}

	public function create(): SestavyClient
	{
		return new SestavyClient(
			$this->createSoap(self::WSDL, $this->user, $this->pass)
		);
	}

}
