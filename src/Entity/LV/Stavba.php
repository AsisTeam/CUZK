<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Stavba
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): ?string
	{
		return $this->el->getElementsByTagName('id')[0]->textContent ?? null;
	}

	public function castObce(): ?string
	{
		return $this->el->getElementsByTagName('caobce')[0]->textContent ?? null;
	}

	public function typBudovy(): ?string
	{
		return $this->el->getElementsByTagName('typbud_zkr')[0]->textContent ?? null;
	}

	public function cislaDomovni(): ?string
	{
		return $this->el->getElementsByTagName('cisla_domovni')[0]->textContent ?? null;
	}

	public function vyuziti(): ?string
	{
		return $this->el->getElementsByTagName('vyuziti_zkr')[0]->textContent ?? null;
	}

	public function telId(): ?string
	{
		return $this->el->getElementsByTagName('tel_id')[0]->textContent ?? null;
	}

	public function bezLv(): ?string
	{
		return $this->el->getElementsByTagName('bez_lv')[0]->textContent ?? null;
	}

	public function cisloTel(): ?string
	{
		return $this->el->getElementsByTagName('cislo_tel')[0]->textContent ?? null;
	}

	public function kuNazev(): ?string
	{
		return $this->el->getElementsByTagName('ku_nazev')[0]->textContent ?? null;
	}

	public function docasna(): ?string
	{
		return $this->el->getElementsByTagName('docasna')[0]->textContent ?? null;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function identifikaceParcely(): array
	{
		$parcels = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('par_ident') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('parcela') as $p) {
				$parcels[] = new ParcelaIdentifikace($p);
			}
		}

		return $parcels;
	}

}
