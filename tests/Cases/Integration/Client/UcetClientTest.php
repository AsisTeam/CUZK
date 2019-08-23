<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Integration\Client;

use AsisTeam\CUZK\Client\AbstractCUZKClientFactory;
use AsisTeam\CUZK\Client\UcetClientFactory;
use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class UcetClientTest extends TestCase
{

	public function setUp(): void
	{
		Environment::skip('Integration tests - run it manually please.');
	}

	public function testListCountries(): void
	{
		$cc = (new UcetClientFactory(
			AbstractCUZKClientFactory::TRIAL_USER,
			AbstractCUZKClientFactory::TRIAL_PASS,
			true
		))->create();

		try {
			$res = $cc->changePassword('some1Strong$Pa55w0rD');
		} catch (ResponseException $e) {
			// test user is not allowed to change his password
			Assert::contains('"kod":208', $e->getMessage());
		}
	}

}

(new UcetClientTest())->run();
