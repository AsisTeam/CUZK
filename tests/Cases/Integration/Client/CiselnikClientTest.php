<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Integration\Client;

use AsisTeam\CUZK\Client\CiselnikClientFactory;
use AsisTeam\CUZK\Client\SestavyClientFactory;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class CiselnikClientTest extends TestCase
{

	public function testTrue(): void
	{
		$cc = (new CiselnikClientFactory(SestavyClientFactory::TRIAL_USER, SestavyClientFactory::TRIAL_PASS, true))->create();
		$countries = $cc->listCountries();
		Assert::true(count($countries) > 240); // on 8.8.219 there was 249 countries in the World
	}

}

(new CiselnikClientTest())->run();
