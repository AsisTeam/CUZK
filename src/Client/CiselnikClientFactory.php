<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

final class CiselnikClientFactory extends AbstractCUZKClientFactory
{

	private const WSDL = 'ciselnik_v28.wsdl';

	/** @var string */
	private $user;

	/** @var string */
	private $pass;

	public function __construct(string $user, string $pass, bool $test = true)
	{
		$this->user = $user;
		$this->pass = $pass;

		parent::__construct($test);
	}

	public function create(): CiselnikClient
	{
		return new CiselnikClient(
			$this->createSoap(self::WSDL, $this->user, $this->pass)
		);
	}

}
