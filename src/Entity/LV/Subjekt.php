<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Subjekt
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function vlastnictvi(): VlastnictviIdentifikace
	{
		return new VlastnictviIdentifikace($this->el->getElementsByTagName('VLA_IDENT')[0]);
	}

	public function opravnenySubjektTyp(): string
	{
		return $this->el->getElementsByTagName('OPSUB_TYP')[0]->textContent ?? '';
	}

	public function charOs(): ?CharakteristikaOsoby
	{
		if ($this->el->getElementsByTagName('OPSUB_ZKRATKA')->length === 0) {
			return null;
		}

		/** @var DOMElement $opsub */
		$opsub = $this->el->getElementsByTagName('OPSUB_ZKRATKA')[0];

		return $opsub->getElementsByTagName('char_os')[0] ?
			new CharakteristikaOsoby($this->el->getElementsByTagName('char_os')[0]) : null;
	}

	public function opsubNazev(): ?OpravnenySubjektIdentifikace
	{
		if ($this->el->getElementsByTagName('OPSUB_NAZEV')->length === 0) {
			return null;
		}

		return new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('OPSUB_NAZEV')[0]);
	}

	public function opsubIdentifikace(): ?OpravnenySubjektIdentifikace
	{
		if ($this->el->getElementsByTagName('OPSUB_IDENT')->length === 0) {
			return null;
		}

		return new OpravnenySubjektIdentifikace($this->el->getElementsByTagName('OPSUB_IDENT')[0]);
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
