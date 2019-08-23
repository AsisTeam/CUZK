<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JednotkaInfo
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function plomba(): string
	{
		return $this->el->getElementsByTagName('PLOMBA_JEDNOTKY')[0]->textContent ?? '';
	}

	public function zpusobVyuziti(): string
	{
		return $this->el->getElementsByTagName('ZP_VYUZITI')[0]->textContent ?? '';
	}

	/**
	 * @return JednotkaIdentifikace[]
	 */
	public function cisloJednotky(): array
	{
		$parcels = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('CISLO_JEDNOTKY') as $item) {
			/** @var DOMElement $p */
			foreach ($item->getElementsByTagName('jednotka') as $p) {
				$parcels[] = new JednotkaIdentifikace($p);
			}
		}

		return $parcels;
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

	public function typJednotky(): string
	{
		return $this->el->getElementsByTagName('TYP_JEDNOTKY')[0]->textContent ?? '';
	}

	public function podil(): string
	{
		/** @var DOMElement $podil */
		$podil = $this->el->getElementsByTagName('PODIL_B')[0];

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

	/**
	 * @return StavbaIdentifikace[]
	 */
	public function budovyStavby(): array
	{
		$stavby = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('BUDOVY') as $item) {
			/** @var DOMElement $b */
			foreach ($item->getElementsByTagName('BUDOVA') as $b) {
				/** @var DOMElement $op */
				foreach ($b->getElementsByTagName('JED_OPSUB') as $op) {
					/** @var DOMElement $s */
					foreach ($op->getElementsByTagName('stavba') as $s) {
						$stavby[] = new StavbaIdentifikace($s);
					}
				}
			}
		}

		return $stavby;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function budovyParcely(): array
	{
		$parcely = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('BUDOVY') as $item) {
			/** @var DOMElement $b */
			foreach ($item->getElementsByTagName('BUDOVA') as $b) {
				/** @var DOMElement $op */
				foreach ($b->getElementsByTagName('PARCELY') as $op) {
					/** @var DOMElement $s */
					foreach ($op->getElementsByTagName('PAR_IDENT') as $s) {
						/** @var DOMElement $par */
						foreach ($s->getElementsByTagName('parcela') as $par) {
							$parcely[] = new ParcelaIdentifikace($par);
						}
					}
				}
			}
		}

		return $parcely;
	}

}
