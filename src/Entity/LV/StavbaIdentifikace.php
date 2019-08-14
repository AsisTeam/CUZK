<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class StavbaIdentifikace
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

	public function typ(): string
	{
		return $this->el->getElementsByTagName('typbud_zkr')[0] ?
			$this->el->getElementsByTagName('typbud_zkr')[0]->textContent : '';
	}

	public function cislaDomovni(): string
	{
		return $this->el->getElementsByTagName('cisla_domovni')[0] ?
			$this->el->getElementsByTagName('cisla_domovni')[0]->textContent : '';
	}

	public function vyuziti(): string
	{
		return $this->el->getElementsByTagName('vyuziti_zkr')[0] ?
			$this->el->getElementsByTagName('vyuziti_zkr')[0]->textContent : '';
	}

	public function telId(): string
	{
		return $this->el->getElementsByTagName('tel_id')[0] ?
			$this->el->getElementsByTagName('tel_id')[0]->textContent : '';
	}

	public function bezLv(): string
	{
		return $this->el->getElementsByTagName('bez_lv')[0] ?
			$this->el->getElementsByTagName('bez_lv')[0]->textContent : '';
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

	public function docasna(): string
	{
		return $this->el->getElementsByTagName('docasna')[0] ?
			$this->el->getElementsByTagName('docasna')[0]->textContent : '';
	}

	public function parIdent(): string
	{
		return $this->el->getElementsByTagName('par_ident')[0] ?
			$this->el->getElementsByTagName('par_ident')[0]->textContent : '';
	}

}
