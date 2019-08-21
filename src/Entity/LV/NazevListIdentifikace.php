<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class NazevListIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function tlist(): string
	{
		return $this->el->getElementsByTagName('tlist')[0]->textContent ?? '';
	}

	public function dalsiUdaje(): string
	{
		return $this->el->getElementsByTagName('dalsi_udaje')[0]->textContent ?? '';
	}

	public function poradoveCisloZhotoveni(): string
	{
		return $this->el->getElementsByTagName('por_cis_zhot')[0]->textContent ?? '';
	}

	public function popis(): string
	{
		return $this->el->getElementsByTagName('popis')[0]->textContent ?? '';
	}

	public function vystavTxt(): string
	{
		return $this->el->getElementsByTagName('vystav_txt')[0]->textContent ?? '';
	}

	public function pravMocTxt(): string
	{
		return $this->el->getElementsByTagName('prav_moc_txt')[0]->textContent ?? '';
	}

	public function podaniTxt(): string
	{
		return $this->el->getElementsByTagName('podani_txt')[0]->textContent ?? '';
	}

	public function vykonatelnostTxt(): string
	{
		return $this->el->getElementsByTagName('vykonatelnost_txt')[0]->textContent ?? '';
	}

	public function podanizTxt(): string
	{
		return $this->el->getElementsByTagName('podani_z_txt')[0]->textContent ?? '';
	}

	public function zplatneniTxt(): string
	{
		return $this->el->getElementsByTagName('zplatneni_txt')[0]->textContent ?? '';
	}

	public function praresNazev(): string
	{
		return $this->el->getElementsByTagName('prares_nazev')[0]->textContent ?? '';
	}

}
