<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use SoapClient;

final class CiselnikClient extends AbstractCUZKClient
{

	private const SEZNAM_STATU = 'seznamStatu';

	public function __construct(SoapClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function listCountries(): array
	{
		$data = $this->call(self::SEZNAM_STATU, []);

		if (!$data->stat || !is_array($data->stat)) {
			throw new ResponseException('Field containing the list of countries "stat" missing.');
		}

		return $this->toArray($data->stat);
	}

}
