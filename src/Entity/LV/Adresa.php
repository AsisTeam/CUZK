<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class Adresa
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function adresniMisto(): ?string
	{
		return $this->el->getElementsByTagName('adresni_misto')[0] ?
			$this->el->getElementsByTagName('adresni_misto')[0]->textContent : null;
	}

	public function nazevUlice(): ?string
	{
		return $this->el->getElementsByTagName('nazev_ulice')[0] ?
			$this->el->getElementsByTagName('nazev_ulice')[0]->textContent : null;
	}

	public function cisloDomovni(): ?string
	{
		return $this->el->getElementsByTagName('cislo_domovni')[0] ?
			$this->el->getElementsByTagName('cislo_domovni')[0]->textContent : null;
	}

	public function cisloOrientacni(): ?string
	{
		return $this->el->getElementsByTagName('cislo_orientacni')[0] ?
			$this->el->getElementsByTagName('cislo_orientacni')[0]->textContent : null;
	}

	public function castObce(): ?string
	{
		return $this->el->getElementsByTagName('cast_obce')[0] ?
			$this->el->getElementsByTagName('cast_obce')[0]->textContent : null;
	}

	public function obec(): ?string
	{
		return $this->el->getElementsByTagName('obec')[0] ?
			$this->el->getElementsByTagName('obec')[0]->textContent : null;
	}

	public function mestskaCast(): ?string
	{
		return $this->el->getElementsByTagName('mestska_cast')[0] ?
			$this->el->getElementsByTagName('mestska_cast')[0]->textContent : null;
	}

	public function mestskyObvod(): ?string
	{
		return $this->el->getElementsByTagName('mestsky_obvod')[0] ?
			$this->el->getElementsByTagName('mestsky_obvod')[0]->textContent : null;
	}

	public function psc(): ?string
	{
		return $this->el->getElementsByTagName('psc')[0] ?
			$this->el->getElementsByTagName('psc')[0]->textContent : null;
	}

	public function dodaciPosta(): ?string
	{
		return $this->el->getElementsByTagName('dod_posta')[0] ?
			$this->el->getElementsByTagName('dod_posta')[0]->textContent : null;
	}

	public function stat(): ?string
	{
		return $this->el->getElementsByTagName('stat')[0] ?
			$this->el->getElementsByTagName('stat')[0]->textContent : null;
	}

}
