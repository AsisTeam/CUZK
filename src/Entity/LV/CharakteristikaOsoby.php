<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class CharakteristikaOsoby
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function kod(): string
	{
		return $this->el->getElementsByTagName('kod')[0]->textContent ?? '';
	}

	public function zkratka(): string
	{
		return $this->el->getElementsByTagName('zkratka')[0]->textContent ?? '';
	}

	public function zkratkaAlv(): string
	{
		return $this->el->getElementsByTagName('zkratka_alv')[0]->textContent ?? '';
	}

}
