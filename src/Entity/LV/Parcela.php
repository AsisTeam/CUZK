<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Parcela
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function identifikace(): array
	{
		$ids = [];
		/** @var DOMElement $p */
		foreach ($this->el->getElementsByTagName('PAR_IDENT') as $pi) {
			foreach ($pi->getElementsByTagName('parcela') as $p) {
				$ids[] = new ParcelaIdentifikace($p);
			}
		}

		return $ids;
	}

	public function vymera(): string
	{
		return $this->el->getElementsByTagName('VYMERA_PARCELY')[0]->textContent ?? '';
	}

	public function druh(): string
	{
		return $this->el->getElementsByTagName('DRUH_POZ')[0]->textContent ?? '';
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
		$zpOchr = [];
		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('ZP_OCHRANY') as $item) {
			/** @var DOMElement $textItem */
			foreach ($item->getElementsByTagName('zpochr') as $textItem) {
				$zpOchr[] = $textItem->textContent;
			}
		}

		return $zpOchr;
	}

	public function plomba(): string
	{
		return $this->el->getElementsByTagName('PLOMBA_PARCELY')[0]->textContent ?? '';
	}

	public function soucasti(): string
	{
		return $this->el->getElementsByTagName('SOUCASTI')[0]->textContent ?? '';
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function stavbaNaViceParcelach(): array
	{
		$parcels = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('STAVBA_NA_VICE_PARCELACH') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('parcela') as $p) {
				$parcels[] = new ParcelaIdentifikace($p);
			}
		}

		return $parcels;
	}

	/**
	 * @return StavbaIdentifikace[]
	 */
	public function soucastiStavba(): array
	{
		$buildings = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('SOUCASTI_STAVBA') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('stavba') as $s) {
				$buildings[] = new StavbaIdentifikace($s);
			}
		}

		return $buildings;
	}

	public function stavbaNaParcele(): ?StavbaIdentifikace
	{
		foreach ($this->el->getElementsByTagName('STAVBA_NA_PARCELE') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('stavba') as $s) {
				return new StavbaIdentifikace($s);
			}
		}

		return null;
	}

	public function dalsiUdajeStavbaSoucastiPozemku(): ?StavbaIdentifikace
	{
		foreach ($this->el->getElementsByTagName('DALSI_UDAJE') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('stavba_soucasti_pozemku') as $s) {
				return new StavbaIdentifikace($s);
			}
		}

		return null;
	}

	public function dalsiUdajeStavbaSoucastiPravaStavby(): ?StavbaIdentifikace
	{
		foreach ($this->el->getElementsByTagName('DALSI_UDAJE') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('stavba_soucasti_prava_stavby') as $s) {
				return new StavbaIdentifikace($s);
			}
		}

		return null;
	}

	/**
	 * @return Jednotka[]
	 */
	public function jednotky(): array
	{
		$units = [];
		foreach ($this->el->getElementsByTagName('JEDNOTKY') as $item) {
			/** @var DOMElement $u */
			foreach ($item->getElementsByTagName('JEDNOTKA') as $u) {
				$units[] = new Jednotka($u);
			}
		}

		return $units;
	}

}
