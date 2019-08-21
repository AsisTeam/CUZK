<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Nemovitost
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	/**
	 * @return ParcelaIdentifikace[]
	 */
	public function parcely(): array
	{
		$list = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('parcela') as $item) {
			$list[] = new ParcelaIdentifikace($item);
		}

		return $list;
	}

	/**
	 * @return StavbaIdentifikace[]
	 */
	public function stavby(): array
	{
		$list = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('stavba') as $item) {
			$list[] = new StavbaIdentifikace($item);
		}

		return $list;
	}

	/**
	 * @return JednotkaIdentifikace[]
	 */
	public function jednotky(): array
	{
		$list = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('jednotka') as $item) {
			$list[] = new JednotkaIdentifikace($item);
		}

		return $list;
	}

	/**
	 * @return PravoStavbyIdentifikace[]
	 */
	public function pravaStaveb(): array
	{
		$list = [];

		/** @var DOMElement $item */
		foreach ($this->el->getElementsByTagName('pravo_stavby') as $item) {
			$list[] = new PravoStavbyIdentifikace($item);
		}

		return $list;
	}

}
