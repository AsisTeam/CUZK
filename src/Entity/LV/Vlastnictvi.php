<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Vlastnictvi
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function vlastnictviIdentifikace(): VlastnictviIdentifikace
	{
		return new VlastnictviIdentifikace($this->el->getElementsByTagName('VLA_IDENT')[0]);
	}

	public function opravnenySubjektIdentifikace(): ?OpravnenySubjektIdentifikace
	{
		return $this->el->getElementsByTagName('OPSUB_IDENT')[0] ?
			new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('OPSUB_IDENT')[0]) : null;
	}

	public function opravnenySubjektNazev(): ?OpravnenySubjektIdentifikace
	{
		return $this->el->getElementsByTagName('OPSUB_NAZEV')[0] ?
			new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('OPSUB_NAZEV')[0]) : null;
	}

	public function podil(): string
	{
		/** @var DOMElement $podil */
		$podil = $this->el->getElementsByTagName('PODIL')[0];

		return sprintf(
			'%s/%s',
			$podil->getElementsByTagName('citatel')[0]->textContent ?? '?',
			$podil->getElementsByTagName('jmenovatel')[0]->textContent ?? '?'
		);
	}

}
