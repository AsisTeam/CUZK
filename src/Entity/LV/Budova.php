<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Budova
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): ?string
	{
		return $this->el->getElementsByTagName('ID')[0]->textContent ?? null;
	}

	public function plomba(): string
	{
		return $this->el->getElementsByTagName('PLOMBA_BUDOVY')[0]->textContent ?? '';
	}

	public function kod(): string
	{
		return $this->el->getElementsByTagName('KOD')[0]->textContent ?? '';
	}

	public function cisloDomovni(): Stavba
	{
		return new Stavba($this->el->getElementsByTagName('CISLO_DOMOVNI')[0]);
	}

	public function zpusobVyuziti(): ?string
	{
		return $this->el->getElementsByTagName('ZP_VYUZITI')[0]->textContent ?? null;
	}

	/**
	 * @return string[]
	 */
	public function zpusobOchrany(): array
	{
		$zpochr = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('ZP_OCHRANY') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('zpochr') as $p) {
				$zpochr[] = $p->textContent;
			}
		}

		return $zpochr;
	}

	public function docasnaStavba(): ?string
	{
		return $this->el->getElementsByTagName('DOCASNA_STAVBA')[0]->textContent ?? null;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function parcely(): array
	{
		$parcels = [];

		/** @var DOMElement $pNode */
		$pNode = $this->el->getElementsByTagName('PARCELY')[0];

		/** @var DOMElement $item */
		foreach ($pNode->getElementsByTagName('PAR_IDENT') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('parcela') as $p) {
				$parcels[] = new ParcelaIdentifikace($p);
			}
		}

		return $parcels;
	}

	/**
	 * @return Jednotka[]
	 */
	public function jendotky(): array
	{
		$units = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('JEDNOTKY') as $item) {
			/** @var DOMElement $u */
			foreach ($item->getElementsByTagName('JEDNOTKA') as $u) {
				$units[] = new Jednotka($u);
			}
		}

		return $units;
	}

}
