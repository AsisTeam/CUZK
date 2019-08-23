<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Integration\Client;

use AsisTeam\CUZK\Client\AbstractCUZKClientFactory;
use AsisTeam\CUZK\Client\CiselnikClientFactory;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class CiselnikClientTest extends TestCase
{

	public function setUp(): void
	{
		Environment::skip('Integration tests - run it manually please.');
	}

	public function testListCountries(): void
	{
		$cc = (new CiselnikClientFactory(
			AbstractCUZKClientFactory::TRIAL_USER,
			AbstractCUZKClientFactory::TRIAL_PASS,
			true
		))->create();

		$countries = $cc->listCountries();
		Assert::true(count($countries) > 240); // on 8.8.219 there was 249 countries in the World
	}

	public function testListCountriesProductionCredentials(): void
	{
		$cc = (new CiselnikClientFactory('', '', false))->create();
		// you may set credentials by passing it to factory, or setting it like below
		$prodUser = 'user'; // fill your own production username
		$prodPass = 'pass'; // fill your own production password
		$cc->setCredentials($prodUser, $prodPass);

		$countries = $cc->listCountries();
		Assert::true(count($countries) > 240); // on 8.8.219 there was 249 countries in the World
	}

}

(new CiselnikClientTest())->run();
