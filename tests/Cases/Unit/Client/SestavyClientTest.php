<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Unit\Client;

use AsisTeam\CUZK\Client\SestavyClient;
use AsisTeam\CUZK\Entity\Report;
use DateTime;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class SestavyClientTest extends TestCase
{

	public function testGenerateByLvId(): void
	{
		$sc = new SestavyClient(
			SoapMockTestHelper::createSoapMock(
				'generujLV',
				[
					0 => [
						'format' => 'pdf',
						'lvId'   => '807841306',
					],
				],
				'generujLV.json'
			)
		);

		$reports = $sc->generateByLvId('807841306');
		Assert::count(1, $reports);
		$r = $reports[0];

		Assert::equal(85901972011, $r->getId());
		Assert::equal('Výpis z katastru', $r->getName());
		Assert::equal('čeká', $r->getStatus());
		Assert::equal(Report::FORMAT_PDF, $r->getFormat());
		Assert::equal('2019-08-09', $r->getDateRequested()->format('Y-m-d'));
		Assert::equal('2019-08-09', $r->getDateStarted()->format('Y-m-d'));
		Assert::null($r->getMasterId());
		Assert::null($r->getSubId());
	}

	public function testGenerateByLvIdAppendedXml(): void
	{
		$sc = new SestavyClient(
			SoapMockTestHelper::createSoapMock(
				'generujLV',
				[
					0 => [
						'format'      => 'pdf',
						'lvId'        => '807841306',
						'datumK'      => '2019-08-09T00:00:00+02:00',
						'pripojitXML' => 'a',
					],
				],
				'generujLV_appendXml.json'
			)
		);

		$reports = $sc->generateByLvId('807841306', new DateTime('2019-08-09'), true);
		Assert::count(2, $reports);

		$pdf = $reports[0];
		Assert::equal(85901973011, $pdf->getId());
		Assert::equal('Výpis z katastru', $pdf->getName());
		Assert::equal('čeká', $pdf->getStatus());
		Assert::equal(Report::FORMAT_PDF, $pdf->getFormat());
		Assert::equal(85901974011, $pdf->getSubId());
		Assert::null($pdf->getMasterId());

		$xml = $reports[1];
		Assert::equal(85901974011, $xml->getId());
		Assert::equal('Výpis z katastru', $xml->getName());
		Assert::equal('čeká', $xml->getStatus());
		Assert::equal(Report::FORMAT_XML, $xml->getFormat());
		Assert::equal(85901973011, $xml->getMasterId());
		Assert::null($xml->getSubId());
	}

	public function testGenerateByCodeAndLvNo(): void
	{
		$sc = new SestavyClient(
			SoapMockTestHelper::createSoapMock(
				'generujLVZjednodusene',
				[
					0 => [
						'format'          => 'pdf',
						'katastrUzemiKod' => '123456',
						'lvCislo'         => '987',
					],
				],
				'generujLV.json'
			)
		);

		$reports = $sc->generateByCodeAndLvNo('123456', '987');
		Assert::count(1, $reports);
	}

	public function testGenerateByCodeAndOsId(): void
	{
		$sc = new SestavyClient(
			SoapMockTestHelper::createSoapMock(
				'generujLVPresOS',
				[
					0 => [
						'format'          => 'pdf',
						'katastrUzemiKod' => '123456',
						'osId'            => '987',
					],
				],
				'generujLV.json'
			)
		);

		$reports = $sc->generateByCodeAndOsId('123456', '987');
		Assert::count(1, $reports);
	}

}

(new SestavyClientTest())->run();
