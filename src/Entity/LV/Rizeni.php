<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Rizeni
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function datumPodani(): string
	{
		return $this->el->getElementsByTagName('DATUM_PODANI')[0]->textContent ?? '';
	}

	public function rizeniIdentifikace(): RizeniIdentifikace
	{
		return new RizeniIdentifikace($this->el->getElementsByTagName('IDENT_RIZENI')[0]);
	}

	/**
	 * @return Nemovitost[]
	 */
	public function nemovitosti(): array
	{
		$list = [];

		/** @var DOMElement $b */
		$b = $this->el->getElementsByTagName('NEMOVITOSTI')[0];
		/** @var DOMElement $item */
		foreach ($b->getElementsByTagName('NEMOVITOST') as $item) {
			$list[] = new Nemovitost($item);
		}

		return $list;
	}

}
