<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Unit\Client;

use Mockery;
use Mockery\MockInterface;
use SoapClient;

final class SoapMockTestHelper
{

	/**
	 * @param mixed[] $expectedData
	 * @return SoapClient|MockInterface
	 */
	public static function createSoapMock(string $expectedMethod, array $expectedData, string $outputFile)
	{
		return Mockery::mock(SoapClient::class)
			->shouldReceive('__soapCall')
			->withArgs(function (string $method, array $data) use ($expectedMethod, $expectedData) {
				if ($method !== $expectedMethod) {
					return false;
				}

				// compare both arrays
				if ($expectedData !== [] && serialize($data) !== serialize($expectedData)) {
					return false;
				}

				return true;
			})
			->andReturn(json_decode(file_get_contents(sprintf('%s/data/%s', __DIR__, $outputFile))))
			->getMock();
	}

}
