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

	/**
	 * @return Parcela[]
	 */
	public function pozemky(): array
	{
		if ($this->el->getElementsByTagName('POZEMKY')->length !== 1) {
			return [];
		}

		/** @var DOMElement $poz */
		$poz = $this->el->getElementsByTagName('POZEMKY')[0];
		$parcels = [];
		foreach ($poz->getElementsByTagName('PARCELA') as $par) {
			$parcels[] = new Parcela($par);
		}

		return $parcels;
	}

}
