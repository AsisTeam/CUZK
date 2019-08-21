<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Bpej
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function kod(): string
	{
		return $this->el->getElementsByTagName('BPEJ_KOD')[0]->textContent;
	}

	public function vymera(): int
	{
		return (int) $this->el->getElementsByTagName('BPEJ_VYMERA')[0]->textContent;
	}

}
