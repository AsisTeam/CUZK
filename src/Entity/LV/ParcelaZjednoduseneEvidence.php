<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class ParcelaZjednoduseneEvidence
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function dil(): string
	{
		return $this->el->getElementsByTagName('DIL_PARCELY_ZE')[0]->textContent;
	}

	public function parcela(): ParcelaIdentifikace
	{
		/** @var DOMElement $p */
		$p = $this->el->getElementsByTagName('PARCELNI_CISLO_ZE')[0];
		return new ParcelaIdentifikace($p->getElementsByTagName('parcela')[0]);
	}

	public function kuKod(): string
	{
		/** @var DOMElement $ku */
		$ku = $this->el->getElementsByTagName('PUV_NAZEV_KU')[0];
		return $ku->getElementsByTagName('kod')[0]->textContent ?? '';
	}

	public function kuNazev(): string
	{
		/** @var DOMElement $ku */
		$ku = $this->el->getElementsByTagName('PUV_NAZEV_KU')[0];
		return $ku->getElementsByTagName('nazev')[0]->textContent ?? '';
	}

	public function typ(): string
	{
		return $this->el->getElementsByTagName('TYP_1')[0]->textContent;
	}

	public function vymera(): int
	{
		return (int) $this->el->getElementsByTagName('VYMERA_PARCELY_ZE')[0]->textContent;
	}

	public function plomba(): string
	{
		return $this->el->getElementsByTagName('PLOMBA_PARCELY_1')[0]->textContent;
	}

}
