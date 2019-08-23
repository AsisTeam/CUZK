<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class ZmenaPV
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function plombaRizeni(): RizeniIdentifikace
	{
		return new RizeniIdentifikace($this->el->getElementsByTagName('PLOMBA')[0]);
	}

}
