<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class ZdrojParcelyZjednoduseneEvidence
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function kodZdroje(): string
	{
		return $this->el->getElementsByTagName('KOD_ZDROJE_ZE')[0]->textContent;
	}

	public function pozemekNazev(): string
	{
		/** @var DOMElement $zdr */
		$zdr = $this->el->getElementsByTagName('ZDROJ_ZE')[0];
		return $zdr->getElementsByTagName('pozemek_nazev')[0]->textContent ?? '';
	}

	public function pozemekZkratka(): string
	{
		/** @var DOMElement $zdr */
		$zdr = $this->el->getElementsByTagName('ZDROJ_ZE')[0];
		return $zdr->getElementsByTagName('pozemek_zkratka')[0]->textContent ?? '';
	}

	/**
	 * @return ParcelaZjednoduseneEvidence[]
	 */
	public function parcely(): array
	{
		$list = [];

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('PARCELY_ZE_A_PK')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('PARCELA_ZE') as $item) {
			$list[] = new ParcelaZjednoduseneEvidence($item);
		}

		return $list;
	}

}
