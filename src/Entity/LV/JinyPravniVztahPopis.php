<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JinyPravniVztahPopis
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function popis(): string
	{
		return $this->el->getElementsByTagName('POPIS_PRAVNIHO_VZTAHU')[0]->textContent;
	}

	/**
	 * @return RizeniIdentifikace[]
	 */
	public function rizeni(): array
	{
		$items = [];
		/** @var DOMElement $jpvr */
		foreach ($this->el->getElementsByTagName('JPV_RIZENI') as $jpvr) {
			/** @var DOMElement $riz */
			foreach ($jpvr->getElementsByTagName('JPV_RIZ') as $riz) {
				$items[] = new RizeniIdentifikace($riz->getElementsByTagName('IDENT_RIZENI')[0]);
			}
		}
		return $items;
	}

}
