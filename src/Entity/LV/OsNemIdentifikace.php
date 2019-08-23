<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class OsNemIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function jpvId(): string
	{
		return $this->el->getElementsByTagName('jpv_id')[0]->textContent ?? '';
	}

	public function telId(): string
	{
		return $this->el->getElementsByTagName('tel_id')[0]->textContent ?? '';
	}

	public function cisloTel(): string
	{
		return $this->el->getElementsByTagName('cislo_tel')[0]->textContent ?? '';
	}

	public function opravnenySubjekt(): ?OpravnenySubjektIdentifikace
	{
		if ($this->el->getElementsByTagName('oprav_subjekt')->length === 0) {
			return null;
		}

		return new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('oprav_subjekt')[0]);
	}

	public function parcela(): ?ParcelaIdentifikace
	{
		if ($this->el->getElementsByTagName('parcela')->length === 0) {
			return null;
		}

		return new ParcelaIdentifikace($this->el->getElementsByTagName('parcela')[0]);
	}

	public function stavba(): ?StavbaIdentifikace
	{
		if ($this->el->getElementsByTagName('stavba')->length === 0) {
			return null;
		}

		return new StavbaIdentifikace($this->el->getElementsByTagName('stavba')[0]);
	}

	public function jednotka(): ?JednotkaIdentifikace
	{
		if ($this->el->getElementsByTagName('jednotka')->length === 0) {
			return null;
		}

		return new JednotkaIdentifikace($this->el->getElementsByTagName('jednotka')[0]);
	}

	public function pravosStavby(): ?PravoStavbyIdentifikace
	{
		if ($this->el->getElementsByTagName('pravo_stavby')->length === 0) {
			return null;
		}

		return new PravoStavbyIdentifikace($this->el->getElementsByTagName('pravo_stavby')[0]);
	}

}
