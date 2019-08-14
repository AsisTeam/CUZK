<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity;

use AsisTeam\CUZK\Entity\LV\NemovistostiBezLV;
use AsisTeam\CUZK\Entity\LV\Text;
use AsisTeam\CUZK\Entity\LV\Zapati;
use AsisTeam\CUZK\Exception\Runtime\ListVlastnictviException;
use DateTime;
use DOMDocument;
use DOMElement;

final class ListVlastnictvi
{

	// or use remote https://katastr.cuzk.cz/dokumentace/xsd/sestavy/VypisZKatastruNemovitosti.xsd
	public const SCHEMA = __DIR__ . '/../../wsdp/common/VypisZKatastruNemovitosti.xsd';

	/** @var DOMElement */
	private $root;

	public function __construct(string $xml)
	{
		$doc = new DOMDocument();
		$doc->loadXML($xml);

		if (!$doc->schemaValidate(self::SCHEMA)) {
			throw new ListVlastnictviException('Given xml is not valid against LV schema');
		}

		$this->root = $doc->getElementsByTagName('VypisZKatastruNemovitosti')[0];
	}

	public function platnost(): DateTime
	{
		return new DateTime($this->root->getElementsByTagName('PLATNOST')[0]->textContent);
	}

	public function bezplatnyPristup(): string
	{
		return $this->root->getElementsByTagName('BEZPL_PRISTUP')[0]->textContent;
	}

	public function vytvoreno(): DateTime
	{
		return new DateTime($this->root->getElementsByTagName('VYHOTOVENO')[0]->textContent);
	}

	public function infoVystup(): string
	{
		return $this->root->getElementsByTagName('INFO_VYSTUP')[0]->textContent;
	}

	public function nemovistostiBezLv(): ?NemovistostiBezLV
	{
		$nemBezLV = $this->root->getElementsByTagName('NEM_BEZ_LV');
		if ($nemBezLV->length === 0 || $this->isEmpty($nemBezLV[0])) {
			return null;
		}

		return new NemovistostiBezLV($nemBezLV[0]);
	}

	/**
	 * @return Text[]
	 */
	public function texty(): array
	{
		/** @var DOMElement $texts */
		$texts = $this->root->getElementsByTagName('LIST_TEXT')[0];

		$out = [];
		foreach ($texts->getElementsByTagName('TEXTY') as $t) {
			$out[] = new Text($t);
		}
		return $out;
	}

	public function zapati(): ?Zapati
	{
		$z = $this->root->getElementsByTagName('LIST_ZAPATI_LV');
		if ($z->length === 0 || $this->isEmpty($z[0])) {
			return null;
		}

		return new Zapati($z[0]);
	}

	private function isEmpty(DOMElement $el): bool
	{
		if ($el->textContent === '' || $el->textContent === "\t\n" || $el->textContent === "\n\t") {
			return true;
		}

		return false;
	}

}
