<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JinyPravniVztahListina
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): string
	{
		return $this->el->getElementsByTagName('LISTIN_ID')[0]->textContent;
	}

	public function popis(): string
	{
		return $this->el->getElementsByTagName('POPIS_LIST')[0]->textContent;
	}

	public function rizeni(): RizeniIdentifikace
	{
		return new RizeniIdentifikace($this->el->getElementsByTagName('IDENT_RIZENI')[0]);
	}

	public function nazevList(): NazevListIdentifikace
	{
		return new NazevListIdentifikace($this->el->getElementsByTagName('NAZEV_LIST')[0]);
	}

}
