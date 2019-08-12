<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity;

use AsisTeam\CUZK\Exception\Runtime\ListVlastnictviException;
use DateTime;
use DOMDocument;

final class ListVlastnictvi
{

	public const SCHEMA = 'https://katastr.cuzk.cz/dokumentace/xsd/sestavy/VypisZKatastruNemovitosti.xsd';

	/** @var DOMDocument */
	private $xml;

	public function __construct(string $xml)
	{
		$doc = new DOMDocument();
		$doc->loadXML($xml);

		if (!$doc->schemaValidate(self::SCHEMA)) {
			throw new ListVlastnictviException('Given xml is not valid against LV schema');
		}

		$this->xml = $doc->getElementsByTagName('VypisZKatastruNemovitosti')[0];
	}

	public function getValidity(): DateTime
	{
		return new DateTime($this->xml->getElementsByTagName('PLATNOST')[0]->nodeValue);
	}

	public function getCreatedOn(): DateTime
	{
		return new DateTime($this->xml->getElementsByTagName('VYHOTOVENO')[0]->nodeValue);
	}

}
