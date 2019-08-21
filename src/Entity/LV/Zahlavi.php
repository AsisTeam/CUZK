<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Zahlavi
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function ciselnaRada(): string
	{
		return $this->el->getElementsByTagName('CIS_RADA')[0]->textContent;
	}

	public function telId(): string
	{
		return $this->el->getElementsByTagName('TEL_ID')[0]->textContent;
	}

	public function cisloLv(): string
	{
		return $this->el->getElementsByTagName('CISLO_LV')[0]->textContent;
	}

	public function okres(): string
	{
		/** @var DOMElement $okr */
		$okr = $this->el->getElementsByTagName('OKRES')[0];
		return $okr->getElementsByTagName('nazev')[0]->textContent;
	}

	public function okresNuts4(): string
	{
		/** @var DOMElement $okr */
		$okr = $this->el->getElementsByTagName('OKRES')[0];
		return $okr->getElementsByTagName('nuts4')[0]->textContent;
	}

	public function obec(): string
	{
		/** @var DOMElement $obec =  */
		$obec = $this->el->getElementsByTagName('OBEC')[0];
		return $obec->getElementsByTagName('nazev')[0]->textContent;
	}

	public function obecKod(): string
	{
		/** @var DOMElement $obec =  */
		$obec = $this->el->getElementsByTagName('OBEC')[0];
		return $obec->getElementsByTagName('kod')[0]->textContent;
	}

	public function katastralniUzemi(): string
	{
		/** @var DOMElement $ku =  */
		$ku = $this->el->getElementsByTagName('KATASTR_UZEMI')[0];
		return $ku->getElementsByTagName('nazev')[0]->textContent;
	}

	public function katastralniUzemiKod(): string
	{
		/** @var DOMElement $ku =  */
		$ku = $this->el->getElementsByTagName('KATASTR_UZEMI')[0];
		return $ku->getElementsByTagName('kod')[0]->textContent;
	}

	public function katastralniUzemiPuv(): string
	{
		/** @var DOMElement $ku =  */
		$ku = $this->el->getElementsByTagName('KATASTR_UZEMI')[0];
		return $ku->getElementsByTagName('nazev_puv')[0]->textContent ?? '';
	}

}
