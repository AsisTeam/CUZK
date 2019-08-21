<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class RizeniIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function typRizeni(): string
	{
		return $this->el->getElementsByTagName('typriz_kod')[0]->textContent ?? '';
	}

	public function poradoveCislo(): string
	{
		return $this->el->getElementsByTagName('poradove_cislo')[0]->textContent ?? '';
	}

	public function rok(): string
	{
		return $this->el->getElementsByTagName('rok')[0]->textContent ?? '';
	}

	public function prares(): string
	{
		return $this->el->getElementsByTagName('prares_kod')[0]->textContent ?? '';
	}

}
