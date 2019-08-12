<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Unit\Client;

use AsisTeam\CUZK\Client\CiselnikClient;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class CiselnikClientTest extends TestCase
{

	public function testListCountries(): void
	{
		$cc = new CiselnikClient(SoapMockTestHelper::createSoapMock('seznamStatu', [], 'seznamStatu.json'));
		Assert::count(249, $cc->listCountries());
	}

}

(new CiselnikClientTest())->run();
