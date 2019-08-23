<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Exception\Runtime\RequestException;
use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use SoapClient;

final class UcetClient extends AbstractCUZKClient
{

	private const PASSWORD_CHANGE = 'zmenHeslo';

	public function __construct(SoapClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function changePassword(string $newPassword): array
	{
		if (strlen($newPassword) <= 12) {
			throw new RequestException('New password must be at least 12 characters long');
		}

		$data = $this->call(self::PASSWORD_CHANGE, ['noveHeslo' => $newPassword]);

		if (!$data->vysledek || !is_array($data->vysledek)) {
			throw new ResponseException('Field "vysledek" missing.');
		}

		return $this->toArray($data->vysledek);
	}

}
