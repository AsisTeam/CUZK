<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Text
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

	/**
	 * @return ZdrojParcelyZjednoduseneEvidence[]
	 */
	public function parcelyZjednoduseneEvidence(): array
	{
		$list = [];

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('PARCELY_ZE')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('ZDROJ_PARCEL_ZE') as $item) {
			$list[] = new ZdrojParcelyZjednoduseneEvidence($item);
		}

		return $list;
	}

	/**
	 * @return Rizeni[]
	 */
	public function rizeni(): array
	{
		$list = [];

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('D1_UPOZORNENI')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('SEZNAM_RIZENI') as $item) {
			$list[] = new Rizeni($item);
		}

		return $list;
	}

	/**
	 * @return ZmenaPV[]
	 */
	public function zmeny(): array
	{
		$list = [];

		if ($this->el->getElementsByTagName('ZMENY_PV')->length === 0) {
			return $list;
		}

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('ZMENY_PV')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('ZMENA_PV') as $item) {
			$list[] = new ZmenaPV($item);
		}

		return $list;
	}

	/**
	 * @return Vztah[]
	 */
	public function vztahy(): array
	{
		$list = [];

		$properPath = '/VypisZKatastruNemovitosti/LIST_TEXT/TEXTY/VLASTNICI_JINI_OPRAVNENI/TYP_VZTAHU';

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('VLASTNICI_JINI_OPRAVNENI')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('TYP_VZTAHU') as $item) {
			if ($item->getNodePath() !== $properPath) {
				continue;
			}
			$list[] = new Vztah($item);
		}

		return $list;
	}

	/**
	 * @return JinaPravaSekce[]
	 */
	public function jinaPrava(): array
	{
		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('JINA_PRAVA')[0];
		$list = [];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('SEKCE_LIST') as $item) {
			$list[] = new JinaPravaSekce($item);
		}

		return $list;
	}

}
