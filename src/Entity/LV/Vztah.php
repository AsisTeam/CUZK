<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Vztah
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function typ(): string
	{
		return $this->el->getElementsByTagName('TYP_VZTAHU')[0]->textContent;
	}

	/**
	 * @return Subjekt[]
	 */
	public function subjekty(): array
	{
		$names = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('SUBJEKTY') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('SUBJEKT') as $n) {
				$names[] = new Subjekt($n);
			}
		}

		return $names;
	}

}
