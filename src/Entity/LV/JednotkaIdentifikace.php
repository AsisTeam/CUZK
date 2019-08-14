<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JednotkaIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): string
	{
		return $this->el->getElementsByTagName('id')[0] ?
			$this->el->getElementsByTagName('id')[0]->textContent : '';
	}
	public function caObce(): string
	{
		return $this->el->getElementsByTagName('caobce')[0] ?
			$this->el->getElementsByTagName('caobce')[0]->textContent : '';
	}

	public function cpIdent(): string
	{
		return $this->el->getElementsByTagName('cp_ident')[0] ?
			$this->el->getElementsByTagName('cp_ident')[0]->textContent : '';
	}

	public function jedIdent(): string
	{
		return $this->el->getElementsByTagName('jed_ident')[0] ?
			$this->el->getElementsByTagName('jed_ident')[0]->textContent : '';
	}

	public function telId(): string
	{
		return $this->el->getElementsByTagName('tel_id')[0] ?
			$this->el->getElementsByTagName('tel_id')[0]->textContent : '';
	}

	public function cisloTel(): string
	{
		return $this->el->getElementsByTagName('cislo_tel')[0] ?
			$this->el->getElementsByTagName('cislo_tel')[0]->textContent : '';
	}

	public function kuNazev(): string
	{
		return $this->el->getElementsByTagName('ku_nazev')[0] ?
			$this->el->getElementsByTagName('ku_nazev')[0]->textContent : '';
	}

}
