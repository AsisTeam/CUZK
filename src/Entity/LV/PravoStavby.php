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

	public function id(): string
	{
		return $this->el->getElementsByTagName('id')[0]->textContent ?? '';
	}

	public function plomba(): string
	{
		return $this->el->getElementsByTagName('PLOMBA_PRAVA_STAVBY')[0]->textContent ?? '';
	}

	/**
	 * @return string[]
	 */
	public function zpusobyOchrany(): array
	{
		$p = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('ZP_OCHRANY') as $item) {
			/** @var DOMElement $zp */
			foreach ($item->getElementsByTagName('zpochr') as $zp) {
				$p[] = $zp->textContent;
			}
		}

		return $p;
	}

	public function platnostDo(): string
	{
		return $this->el->getElementsByTagName('PLATNOST_DO')[0]->textContent ?? '';
	}

	public function soucastiStavbaIdentifikace(): ?StavbaIdentifikace
	{
		/** @var DOMElement $ss */
		$ss = $this->el->getElementsByTagName('SOUCASTI_STAVBA')[0];
		if ($ss->getElementsByTagName('stavba')->length === 1) {
			return new StavbaIdentifikace($ss->getElementsByTagName('stavba')[0]);
		}

		return null;
	}

	public function soucastiStavbaDocasna(): string
	{
		/** @var DOMElement $ss */
		$ss = $this->el->getElementsByTagName('SOUCASTI_STAVBA')[0];

		return $ss->getElementsByTagName('docasna')[0]->textContent ?? '';
	}

	/**
	 * @return string[]
	 */
	public function ucelyPravaStavby(): array
	{
		$p = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('UCELY_PRAVA_STAVBY') as $item) {
			/** @var DOMElement $zp */
			foreach ($item->getElementsByTagName('UCEL') as $zp) {
				$p[] = $zp->textContent;
			}
		}

		return $p;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function parcely(): array
	{
		$p = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('PARCELY') as $item) {
			/** @var DOMElement $pi */
			foreach ($item->getElementsByTagName('PAR_IDENT') as $pi) {
				/** @var DOMElement $pa */
				foreach ($pi->getElementsByTagName('parcela') as $pa) {
					$p[] = new ParcelaIdentifikace($pa);
				}
			}
		}

		return $p;
	}

	/**
	 * @return Jednotka[]
	 */
	public function jednotky(): array
	{
		$p = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('JEDNOTKY') as $item) {
			/** @var DOMElement $j */
			foreach ($item->getElementsByTagName('JEDNOTKA') as $j) {
				$p[] = new Jednotka($j);
			}
		}

		return $p;
	}

}
