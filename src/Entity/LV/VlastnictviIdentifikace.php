<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class VlastnictviIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function opravnenySubjekt(): OpravnenySubjektIdentifikace
	{
		return new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('oprav_subjekt')[0]);
	}

	public function parcela(): ParcelaIdentifikace
	{
		return new ParcelaIdentifikace($this->el->getElementsByTagName('parcela')[0]);
	}

	public function stavba(): StavbaIdentifikace
	{
		return new StavbaIdentifikace($this->el->getElementsByTagName('stavba')[0]);
	}

	public function jednotka(): JednotkaIdentifikace
	{
		return new JednotkaIdentifikace($this->el->getElementsByTagName('jednotka')[0]);
	}

	public function pravoStavby(): PravoStavby
	{
		return new PravoStavby($this->el->getElementsByTagName('pravo_stavby')[0]);
	}

}
