<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Entity\Report;
use AsisTeam\CUZK\Exception\Runtime\RequestException;
use AsisTeam\CUZK\Exception\Runtime\ResponseException;
use DateTime;
use SoapClient;
use stdClass;

final class SestavyClient extends AbstractCUZKClient
{

	private const REPORT_FIND_BY_ID = 'vratSestavu';
	private const REPORT_FIND_ALL   = 'seznamSestav';
	private const REPORT_DELETE     = 'smazSestavu';

	private const LIST_VLASTNICTVI_GENERATE_BY_LV_ID              = 'generujLV';
	private const LIST_VLASTNICTVI_GENERATE_BY_CODE_AND_LV_NUMBER = 'generujLVZjednodusene';
	private const LIST_VLASTNICTVI_GENERATE_BY_CODE_AND_ID_OS     = 'generujLVPresOS';

	private const PARAM_LV_ID   = 'ID LV, které se má vygenerovat';
	private const PARAM_CODE_KU = 'Kód k.ú. (šestimístný)';
	private const PARAM_LV_NO   = 'Číslo listu vlastnictví';
	private const PARAM_OS_ID   = 'ID oprávněného subjektu (nebo master tohoto OS)';
	private const PARAM_DATE    = 'Datum, ke kterému bude sestava vygenerována.';

	private const ENUM_TRUE = 'a';

	public function __construct(SoapClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return Report[]
	 */
	public function getReports(): array
	{
		$resp    = $this->call(self::REPORT_FIND_ALL, []);

		return $this->extractReports($resp);
	}

	public function getReport(int $id): Report
	{
		$resp    = $this->call(self::REPORT_FIND_BY_ID, ['idSestavy' => $id]);
		$reports = $this->extractReports($resp);

		if (count($reports) !== 1) {
			throw new ResponseException(sprintf('Expected 1 report. Got %d.', count($reports)));
		}

		return $reports[0];
	}

	public function deleteReport(int $id): void
	{
		$this->call(self::REPORT_DELETE, ['idSestavy' => $id]);
	}

	/**
	 * @return Report[]
	 */
	public function generateByLvId(string $lvId, ?DateTime $date = null, bool $appendXml = false): array
	{
		$this->assertNonEmpty($lvId, self::PARAM_LV_ID);

		$resp = $this->call(
			self::LIST_VLASTNICTVI_GENERATE_BY_LV_ID,
			array_merge(
				[
					'format' => Report::FORMAT_PDF,
					'lvId'   => $lvId,
				],
				$this->getOptionalParams($date, $appendXml)
			)
		);

		return $this->extractReports($resp);
	}

	/**
	 * @return Report[]
	 */
	public function generateByCodeAndLvNo(
		string $codeKU,
		string $lvNo,
		?DateTime $date = null,
		bool $appendXml = false
	): array
	{
		$this->assertCodeKu($codeKU);
		$this->assertNonEmpty($lvNo, self::PARAM_LV_NO);

		$resp = $this->call(
			self::LIST_VLASTNICTVI_GENERATE_BY_CODE_AND_LV_NUMBER,
			array_merge(
				[
					'format'          => Report::FORMAT_PDF,
					'katastrUzemiKod' => $codeKU,
					'lvCislo'         => $lvNo,
				],
				$this->getOptionalParams($date, $appendXml)
			)
		);

		return $this->extractReports($resp);
	}

	/**
	 * @return Report[]
	 */
	public function generateByCodeAndOsId(
		string $codeKU,
		string $osId,
		?DateTime $date = null,
		bool $appendXml = false
	): array
	{
		$this->assertCodeKu($codeKU);
		$this->assertNonEmpty($osId, self::PARAM_OS_ID);

		$resp = $this->call(
			self::LIST_VLASTNICTVI_GENERATE_BY_CODE_AND_ID_OS,
			array_merge(
				[
					'format'          => Report::FORMAT_PDF,
					'katastrUzemiKod' => $codeKU,
					'osId'            => $osId,
				],
				$this->getOptionalParams($date, $appendXml)
			)
		);

		return $this->extractReports($resp);
	}

	private function assertNonEmpty(string $str, string $paramName): void
	{
		if (strlen($str) <= 0) {
			throw new RequestException(sprintf('Param "%s" must not be empty', $paramName));
		}
	}

	private function assertCodeKu(string $codeKU): void
	{
		if (strlen($codeKU) !== 6) {
			throw new RequestException(sprintf('Param $codeKU (%s) must contain 6 characters', self::PARAM_CODE_KU));
		}
	}

	private function assertDate(DateTime $date): void
	{
		$now = new DateTime('now', $date->getTimezone());
		if ($date->getTimestamp() > $now->getTimestamp()) {
			throw new RequestException(sprintf('Param $date (%s) must not be in future', self::PARAM_DATE));
		}
	}

	/**
	 * @return mixed[]
	 */
	private function getOptionalParams(?DateTime $date = null, bool $appendXml = false): array
	{
		$params = [];

		if ($date !== null) {
			$this->assertDate($date);
			$params['datumK'] = $date->format(DATE_RFC3339);
		}

		if ($appendXml) {
			$params['pripojitXML'] = self::ENUM_TRUE;
		}

		return $params;
	}

	/**
	 * @return Report[]
	 */
	private function extractReports(stdClass $resp): array
	{
		$reports = [];
		if (!property_exists($resp, 'reportList') || !property_exists($resp->reportList, 'report')) {
			return $reports;
		}

		if (is_array($resp->reportList->report)) {
			foreach ($resp->reportList->report as $r) {
				$reports[] = Report::extract($r);
			}
		} else {
			$reports[] = Report::extract($resp->reportList->report);
		}

		return $reports;
	}

}
