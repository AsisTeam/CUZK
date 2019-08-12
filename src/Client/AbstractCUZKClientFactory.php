<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Client;

use AsisTeam\CUZK\Exception\LogicalException;
use SoapClient;
use SoapFault;
use SoapHeader;
use SoapVar;
use stdClass;

abstract class AbstractCUZKClientFactory
{

	private const WSS_NS = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

	public const TRIAL_USER = 'WSTEST';
	public const TRIAL_PASS = 'WSHESLO';

	//	public const TRIAL_USER_OVEROVATEL = 'WSTESTO';
	//	public const TRIAL_PASS_OVEROVATEL = 'WSHESLOO';
	//	public const TRIAL_USER_BEZUPLATNY = 'WSTESTB';
	//	public const TRIAL_PASS_BEZUPLATNY = 'WSHESLOB';

	private const WSDL_TRIAL_PATH = __DIR__ . '/../../wsdp/trial/';
	private const WSDL_PROD_PATH  = __DIR__ . '/../../wsdp/prod/';

	/** @var bool */
	private $test;

	public function __construct(bool $test = true)
	{
		$this->test = $test;
	}

	public function createSoap(string $wsdl, string $user, string $pass): SoapClient
	{
		try {
			$env  = $this->test ? self::WSDL_TRIAL_PATH : self::WSDL_PROD_PATH;
			$soap = new SoapClient(
				$env . $wsdl,
				[
					'encoding'     => 'UTF-8',
					'exceptions'   => true,
					'trace'        => true,
					'soap_version' => SOAP_1_1,
				]
			);

			$header = $this->createHeader(
				$this->test ? self::TRIAL_USER : $user,
				$this->test ? self::TRIAL_PASS : $pass
			);
			$soap->__setSoapHeaders([$header]);

			return $soap;
		} catch (SoapFault $e) {
			throw new LogicalException('Cannot instantiate LV soap client', $e->getCode(), $e);
		}
	}

	private function createHeader(string $user, string $pass): SoapHeader
	{
		$auth           = new stdClass();
		$auth->Username = new SoapVar($user, XSD_STRING, '', self::WSS_NS, '', self::WSS_NS);
		$auth->Password = new SoapVar($pass, XSD_STRING, '', self::WSS_NS, '', self::WSS_NS);

		$ut                = new stdClass();
		$ut->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, '', self::WSS_NS, 'UsernameToken', self::WSS_NS);

		$security = new SoapVar(
			new SoapVar($ut, SOAP_ENC_OBJECT, '', self::WSS_NS, 'UsernameToken', self::WSS_NS),
			SOAP_ENC_OBJECT,
			'',
			self::WSS_NS,
			'Security',
			self::WSS_NS
		);

		return new SoapHeader(self::WSS_NS, 'Security', $security, true);
	}

}
