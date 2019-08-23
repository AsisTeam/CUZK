<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JinaPravaSekce
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function typ(): string
	{
		return $this->el->getAttribute('SEKCE');
	}

	/**
	 * @return JinyPravniVztah[]
	 */
	public function jinePravniVztahy(): array
	{
		$items = [];

		/** @var DOMElement $list */
		foreach ($this->el->getElementsByTagName('JPV_LIST') as $list) {
			/** @var DOMElement $jpv */
			foreach ($list->getElementsByTagName('JPV') as $jpv) {
				$items[] = new JinyPravniVztah($jpv);
			}
		}

		return $items;
	}

}
