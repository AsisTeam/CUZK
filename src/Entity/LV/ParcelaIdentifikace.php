<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class ParcelaIdentifikace
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
	public function zkratka(): string
	{
		return $this->el->getElementsByTagName('zkratka')[0] ?
			$this->el->getElementsByTagName('zkratka')[0]->textContent : '';
	}

	public function druhCis(): string
	{
		return $this->el->getElementsByTagName('druh_cis')[0] ?
			$this->el->getElementsByTagName('druh_cis')[0]->textContent : '';
	}

	public function parCis(): string
	{
		return $this->el->getElementsByTagName('par_cis')[0] ?
			$this->el->getElementsByTagName('par_cis')[0]->textContent : '';
	}

	public function poddCis(): string
	{
		return $this->el->getElementsByTagName('podd_cis')[0] ?
			$this->el->getElementsByTagName('podd_cis')[0]->textContent : '';
	}

	public function dilParcely(): string
	{
		return $this->el->getElementsByTagName('dil_parcely')[0] ?
			$this->el->getElementsByTagName('dil_parcely')[0]->textContent : '';
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

	public function nazevPuv(): string
	{
		return $this->el->getElementsByTagName('nazev_puv')[0] ?
			$this->el->getElementsByTagName('nazev_puv')[0]->textContent : '';
	}

}
