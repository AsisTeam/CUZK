<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use SoapClient;

final class SestavyClient extends AbstractCUZKClient
{

	private const LIST_VLASTNICTVI_FIND_BY_LV_ID              = 'generujLV';
	private const LIST_VLASTNICTVI_FIND_BY_CODE_AND_LV_NUMBER = 'generujLVZjednodusene';
	private const LIST_VLASTNICTVI_FIND_BY_CODE_AND_ID_OS     = 'generujLVPresOS';
	private const LIST_VLASTNICTVI_FIND_BY_OBJECTS            = 'generujLVPresObjekty';

	public function __construct(SoapClient $client)
	{
		parent::__construct($client);
	}

	public function findById(string $id): void
	{
		$this->call(self::LIST_VLASTNICTVI_FIND_BY_LV_ID, []);
	}

	public function findByCodeAndLvNo(string $code, string $lvNo): void
	{
		$this->call(self::LIST_VLASTNICTVI_FIND_BY_CODE_AND_LV_NUMBER, []);
	}

	public function findByCodeAndOsId(string $code, string $osId): void
	{
		$this->call(self::LIST_VLASTNICTVI_FIND_BY_CODE_AND_ID_OS, []);
	}

	/**
	 * @param mixed[] $objects
	 */
	public function findByObjects(array $objects): void
	{
		$this->call(self::LIST_VLASTNICTVI_FIND_BY_OBJECTS, []);
	}

}
