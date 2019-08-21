<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Bonita
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function parcela(): ParcelaIdentifikace
	{
		return new ParcelaIdentifikace($this->el->getElementsByTagName('BON_PARCELNI_CISLO')[0]);
	}

	public function jineKuKod(): string
	{
		/** @var DOMElement $ku */
		$ku = $this->el->getElementsByTagName('JINE_KU')[0];
		return $ku->getElementsByTagName('kod')[0]->textContent ?? '';
	}

	public function jineKuNazev(): string
	{
		/** @var DOMElement $ku */
		$ku = $this->el->getElementsByTagName('JINE_KU')[0];
		return $ku->getElementsByTagName('nazev')[0]->textContent ?? '';
	}

	/**
	 * @return Bpej[]
	 */
	public function bpej(): array
	{
		/** @var DOMElement $bonBpej */
		$bonBpej = $this->el->getElementsByTagName('BONITY_BPEJ')[0];

		$list = [];
		foreach ($bonBpej->getElementsByTagName('BPEJ') as $item) {
			$list[] = new Bpej($item);
		}

		return $list;
	}

}
