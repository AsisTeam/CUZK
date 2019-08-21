<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class UkonKN
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function identifikatorRizeni(): string
	{
		return $this->el->getElementsByTagName('IDENT_RIZENI')[0]->textContent;
	}

	/**
	 * @return string[]
	 */
	public function nazevRizeni(): array
	{
		$names = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('RIZ_TYP_PREDMETU') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('NAZEV_RIZENI') as $n) {
				$names[] = $n->textContent;
			}
		}

		return $names;
	}

}
