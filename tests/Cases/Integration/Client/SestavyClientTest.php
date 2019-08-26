<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Integration\Client;

use AsisTeam\CUZK\Client\AbstractCUZKClientFactory;
use AsisTeam\CUZK\Client\SestavyClient;
use AsisTeam\CUZK\Client\SestavyClientFactory;
use AsisTeam\CUZK\Entity\Report;
use DateTime;
use Tester\Assert;
use Tester\Environment;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class SestavyClientTest extends TestCase
{

	/** @var SestavyClient */
	private $client;

	/** @var int */
	private $generated = 0;

	public function setUp(): void
	{
		Environment::skip('Integration tests - run it manually please.');

		$this->client = (new SestavyClientFactory(
			AbstractCUZKClientFactory::TRIAL_USER,
			AbstractCUZKClientFactory::TRIAL_PASS,
			true
		))->create();
	}

	public function testGenerateByLvId(): void
	{
		$reports = $this->client->generateByLvId('807841306');
		Assert::count(1, $reports);
		$this->generated = $reports[0]->getId();
	}

	public function testGenerateByLvIdAppendXml(): void
	{
		$reports = $this->client->generateByLvId('807841306', Report::FORMAT_PDF, new DateTime('2019-01-01'), true);
		Assert::count(2, $reports);
	}

	public function testGenerateByCodeAndLvNo(): void
	{
		$reports = $this->client->generateByCodeAndLvNo('727181', '7046');
		// Dont know any valid combination of kodKU and LvNo
		Assert::count(0, $reports);
	}

	public function testGenerateByCodeAndOsId(): void
	{
		$reports = $this->client->generateByCodeAndOsId('727181', '123456');
		// Dont know any valid combination of kodKU and osId
		Assert::count(0, $reports);
	}

	public function testGetReport(): void
	{
		if ($this->generated === 0) {
			Environment::skip('testGetReportById: Cannot get, nothing previously generated');
		}

		// zZzZz - wait some time for the proper end of async generate call
		sleep(15);

		$r = $this->client->getReport($this->generated);
		Assert::equal($this->generated, $r->getId());
		Assert::equal('zaúčtován', $r->getStatus());
		Assert::notEqual('', $r->getContent());
	}

	public function testGetReports(): void
	{
		$rs = $this->client->getReports();
		Assert::true(count($rs) > 0);

		$found = false;
		foreach ($rs as $r) {
			if ($r->getId() === $this->generated) {
				$found = true;
			}
		}
		Assert::true($found);
	}

	public function testDeleteReport(): void
	{
		$this->client->deleteReport($this->generated);
		Assert::true(true); // app didnt crashed before
	}

}

(new SestavyClientTest())->run();
