<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Exception\Runtime\RequestException;
use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use SoapClient;
use SoapFault;
use stdClass;

abstract class AbstractCUZKClient
{

	/** @var SoapClient */
	protected $client;

	public function __construct(SoapClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param mixed[] $data
	 *
	 * @return mixed
	 */
	protected function call(string $method, array $data): stdClass
	{
		$json = json_encode($data);

		if ($json === false) {
			throw new RequestException(sprintf('Could not convert request input data to json. Error: %s',
				json_last_error_msg()));
		}

		try {
			$response = $this->client->__soapCall($method, [$json]);
			// TODO - remove (used for logging responses)
			// echo(json_encode($response)); die();
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
		if (!property_exists($msg, 'kod') || $msg->kod !== 0) {
			throw new ResponseException(
				sprintf('Failure response received. "vysledek" field = %s', json_encode($msg))
			);
		}
	}

	/**
	 * @param mixed $data
	 *
	 * @return mixed[]
	 */
	protected function toArray($data): array {
		$arr = json_decode(json_encode($data), true);

		if ($arr === null) {
			throw new ResponseException(sprintf('Could not convert response data to json. Error: %s', json_last_error_msg()));
		}

		return $arr;
	}

}
