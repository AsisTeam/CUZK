<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

final class UcetClientFactory extends AbstractCUZKClientFactory
{

	private const WSDL = 'ucet_v28.wsdl';

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

	public function create(): UcetClient
	{
		return new UcetClient($this->createSoap(self::WSDL, $this->user, $this->pass));
	}

}
