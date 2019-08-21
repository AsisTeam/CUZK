<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Jednotka
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function vyuziti(): string
	{
		return $this->el->getElementsByTagName('JED_ZP_VYUZITI')[0]->textContent ?? '';
	}

	/**
	 * @return JednotkaIdentifikace[]
	 */
	public function identifikace(): array
	{
		/** @var DOMElement $u */
		$u = $this->el->getElementsByTagName('CISLO_JEDNOTKY')[0];

		$units = [];
		/** @var DOMElement $item */
		foreach ($u->getElementsByTagName('jednotka') as $item) {
			$units[] = new JednotkaIdentifikace($item);
		}

		return $units;
	}

	public function typ(): string
	{
		return $this->el->getElementsByTagName('TYP_JEDNOTKY')[0]->textContent ?? '';
	}

	public function podil(): string
	{
		/** @var DOMElement $podil */
		$podil = $this->el->getElementsByTagName('PODIL_BA')[0];

		return sprintf(
			'%s/%s',
			$podil->getElementsByTagName('citatel')[0]->textContent ?? '?',
			$podil->getElementsByTagName('jmenovatel')[0]->textContent ?? '?'
		);
	}

	public function popis(): string
	{
		return $this->el->getElementsByTagName('POPIS')[0]->textContent ?? '';
	}

	public function telId(): string
	{
		return $this->el->getElementsByTagName('TEL_ID')[0]->textContent ?? '';
	}

	public function naLvTelId(): string
	{
		$naLv = $this->el->getElementsByTagName('NA_LV')[0];

		return $naLv->getElementsByTagName('tel_id')[0]->textContent ?? '';
	}

	public function naLvCisloTel(): string
	{
		$naLv = $this->el->getElementsByTagName('NA_LV')[0];

		return $naLv->getElementsByTagName('cislo_tel')[0]->textContent ?? '';
	}

	public function naLv(): ?string
	{
		return $this->el->getElementsByTagName('NA_LV')[0]->textContent ?? '';
	}

	/**
	 * @return Vlastnictvi[]
	 */
	public function vlastnictvi(): array
	{
		$own = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('VLASTNICTVI') as $item) {
			$own[] = new Vlastnictvi($item);
		}
		return $own;
	}

}
