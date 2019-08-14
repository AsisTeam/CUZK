<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class PravoStavby
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): ?string
	{
		return $this->el->getElementsByTagName('id')[0] ?
			$this->el->getElementsByTagName('id')[0]->textContent : null;
	}

	public function telId(): ?string
	{
		return $this->el->getElementsByTagName('tel_id')[0] ?
			$this->el->getElementsByTagName('tel_id')[0]->textContent : null;
	}

	public function kuNazev(): ?string
	{
		return $this->el->getElementsByTagName('ku_nazev')[0] ?
			$this->el->getElementsByTagName('ku_nazev')[0]->textContent : null;
	}

	public function cisloTel(): ?string
	{
		return $this->el->getElementsByTagName('cislo_tel')[0] ?
			$this->el->getElementsByTagName('cislo_tel')[0]->textContent : null;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function parcely(): array
	{
		$p = [];
		foreach ($this->el->getElementsByTagName('parcela') as $item) {
			$p[] = new ParcelaIdentifikace($item);
		}

		return $p;
	}

}
