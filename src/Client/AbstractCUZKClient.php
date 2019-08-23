<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Exception\Runtime\RequestException;
use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use SoapClient;
use SoapFault;
use stdClass;

abstract class AbstractCUZKClient
{

	private const SUCCESS_CODE = 0;
	private const LEVEL_INFO = 'INFORMACE';

	/** @var SoapClient */
	protected $client;

	public function __construct(SoapClient $client)
	{
		$this->client = $client;
	}

	public function setCredentials(string $user, string $pass): void
	{
		$header = AbstractCUZKClientFactory::createHeader($user, $pass);
		$this->client->__setSoapHeaders([$header]);
	}

	/**
	 * @param mixed[] $params
	 */
	protected function call(string $method, array $params): stdClass
	{
		try {
			$response = $this->client->__soapCall($method, [$params]);
		} catch (SoapFault $e) {
			throw new RequestException($e->getMessage(), 0, $e);
		}

		if (!$response->vysledek || !$response->vysledek->zprava) {
			throw new ResponseException('Invalid response received. The "vysledek" field not present');
		}

		if (is_array($response->vysledek->zprava)) {
			foreach ($response->vysledek->zprava as $msg) {
				$this->assertResult($msg);
			}
		} else {
			$this->assertResult($response->vysledek->zprava);
		}

		return $response;
	}

	private function assertResult(stdClass $msg): void
	{
		if (!property_exists($msg, 'kod') || !property_exists($msg, 'uroven')) {
			throw new ResponseException(
				sprintf('Malformed response received. "kod" and/or "uroven" fields are missing: %s', json_encode($msg))
			);
		}

		if ($msg->kod !== self::SUCCESS_CODE && $msg->uroven !== self::LEVEL_INFO) {
			throw new ResponseException(
				sprintf('Failure response received. "vysledek" field = %s', json_encode($msg))
			);
		}
	}

	/**
	 * @param mixed[] $data
	 * @return mixed[]
	 */
	protected function toArray(array $data): array
	{
		/** @var string $str */
		$str = json_encode($data);
		$arr = json_decode($str, true);

		if ($arr === null) {
			throw new ResponseException(sprintf('Could not convert response data to json. Error: %s', json_last_error_msg()));
		}

		return $arr;
	}

}
