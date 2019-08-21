<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class Text
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function zahlavi(): Zahlavi
	{
		return new Zahlavi($this->el->getElementsByTagName('ZAHLAVI_LV')[0]);
	}

	public function upozorneni1(): string
	{
		return $this->el->getElementsByTagName('UPOZORNENI1')[0]->textContent;
	}

	public function upozorneni2(): string
	{
		return $this->el->getElementsByTagName('UPOZORNENI2')[0]->textContent;
	}

	public function castecny(): string
	{
		return $this->el->getElementsByTagName('CASTECNY')[0]->textContent;
	}

	/**
	 * @return Parcela[]
	 */
	public function pozemky(): array
	{
		$parcels = [];

		/** @var DOMElement $poz */
		$poz = $this->el->getElementsByTagName('POZEMKY')[0];
		foreach ($poz->getElementsByTagName('PARCELA') as $par) {
			$parcels[] = new Parcela($par);
		}

		return $parcels;
	}

	/**
	 * @return Budova[]
	 */
	public function budovy(): array
	{
		$bud = [];

		/** @var DOMElement $stav */
		$stav = $this->el->getElementsByTagName('STAVBY')[0];
		/** @var DOMElement $b */
		foreach ($stav->getElementsByTagName('BUDOVA') as $b) {
			$bud[] = new Budova($b);
		}

		return $bud;
	}

	/**
	 * @return UkonKN[]
	 */
	public function ukony(): array
	{
		$list = [];

		/** @var DOMElement $u */
		$u = $this->el->getElementsByTagName('UKONY_KN')[0];
		/** @var DOMElement $item */
		foreach ($u->getElementsByTagName('UKON_KN') as $item) {
			$list[] = new UkonKN($item);
		}

		return $list;
	}

	/**
	 * @return NabyvaciTitul[]
	 */
	public function nabyvaciTituly(): array
	{
		$list = [];

		/** @var DOMElement $nt */
		$nt = $this->el->getElementsByTagName('E_NABYVACI_TITULY')[0];
		/** @var DOMElement $item */
		foreach ($nt->getElementsByTagName('E_NABYVACI_TITUL') as $item) {
			$list[] = new NabyvaciTitul($item);
		}

		return $list;
	}

	/**
	 * @return Bonita[]
	 */
	public function bonity(): array
	{
		$list = [];

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('F_BONITY')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('F_BONITA') as $item) {
			$list[] = new Bonita($item);
		}

		return $list;
	}

}
