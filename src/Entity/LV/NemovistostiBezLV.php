<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class NemovistostiBezLV
{

	/** @var DOMElement */
	private $nemBezLV;

	public function __construct(DOMElement $nemBezLV)
	{
		$this->nemBezLV = $nemBezLV;
	}

	/**
	 * @return Parcela[]
	 */
	public function parcely(): array
	{
		$parNodes = [];
		/** @var DOMElement $nem */
		foreach ($this->nemBezLV->childNodes as $nem) {
			$parBezLV = $nem->getElementsByTagName('PARCELA_BEZ_LV');
			if ($parBezLV->length === 0) {
				/** @var DOMElement $par */
				foreach ($parBezLV as $par) {
					if ($par->getElementsByTagName('parcela')->length > 0) {
						foreach ($par->getElementsByTagName('parcela') as $p) {
							$parNodes[] = $p;
						}
					}
				}
			}
		}

		$parcels = [];
		foreach ($parNodes as $p) {
			$parcels[] = new Parcela($p);
		}

		return $parcels;
	}

}
