<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class OpravnenySubjektIdentifikace
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function id(): string
	{
		return $this->el->getElementsByTagName('id')[0] ?? '';
	}

	public function rc6(): string
	{
		return $this->el->getElementsByTagName('rc6')[0] ?? '';
	}

	public function rc7(): string
	{
		return $this->el->getElementsByTagName('rc7')[0] ?? '';
	}

	public function ico(): string
	{
		return $this->el->getElementsByTagName('ico')[0] ?? '';
	}

	public function icoDoplnek(): string
	{
		return $this->el->getElementsByTagName('ico_doplnek')[0] ?? '';
	}

	public function bsm1Id(): ?string
	{
		return $this->el->getElementsByTagName('bsm1_id')[0] ?
			$this->el->getElementsByTagName('bsm1_id')[0]->textContent : null;
	}

	public function bsm2Id(): ?string
	{
		return $this->el->getElementsByTagName('bsm2_id')[0] ?
			$this->el->getElementsByTagName('bsm2_id')[0]->textContent : null;
	}

	public function prijmeni(): ?string
	{
		return $this->el->getElementsByTagName('prijmeni')[0] ?
			$this->el->getElementsByTagName('prijmeni')[0]->textContent : null;
	}

	public function jmeno(): ?string
	{
		return $this->el->getElementsByTagName('jmeno')[0] ?
			$this->el->getElementsByTagName('jmeno')[0]->textContent : null;
	}

	public function titulPred(): ?string
	{
		return $this->el->getElementsByTagName('titul_pred')[0] ?
			$this->el->getElementsByTagName('titul_pred')[0]->textContent : null;
	}

	public function titulZa(): ?string
	{
		return $this->el->getElementsByTagName('titul_za')[0] ?
			$this->el->getElementsByTagName('titul_za')[0]->textContent : null;
	}

	public function bsm1Prijmeni(): ?string
	{
		return $this->el->getElementsByTagName('bsm1_prijmeni')[0] ?
			$this->el->getElementsByTagName('bsm1_prijmeni')[0]->textContent : null;
	}

	public function bsm1Jmeno(): ?string
	{
		return $this->el->getElementsByTagName('bsm1_jmeno')[0] ?
			$this->el->getElementsByTagName('bsm1_jmeno')[0]->textContent : null;
	}

	public function bsm1Pred(): ?string
	{
		return $this->el->getElementsByTagName('bsm1_pred')[0] ?
			$this->el->getElementsByTagName('bsm1_pred')[0]->textContent : null;
	}

	public function bsm1Za(): ?string
	{
		return $this->el->getElementsByTagName('bsm1_za')[0] ?
			$this->el->getElementsByTagName('bsm1_za')[0]->textContent : null;
	}

	public function bsm2Prijmeni(): ?string
	{
		return $this->el->getElementsByTagName('bsm2_prijmeni')[0] ?
			$this->el->getElementsByTagName('bsm2_prijmeni')[0]->textContent : null;
	}

	public function bsm2Jmeno(): ?string
	{
		return $this->el->getElementsByTagName('bsm2_jmeno')[0] ?
			$this->el->getElementsByTagName('bsm2_jmeno')[0]->textContent : null;
	}

	public function bsm2Pred(): ?string
	{
		return $this->el->getElementsByTagName('bsm2_pred')[0] ?
			$this->el->getElementsByTagName('bsm2_pred')[0]->textContent : null;
	}

	public function bsm2Za(): ?string
	{
		return $this->el->getElementsByTagName('bsm2_za')[0] ?
			$this->el->getElementsByTagName('bsm2_za')[0]->textContent : null;
	}

	public function nazev(): ?string
	{
		return $this->el->getElementsByTagName('nazev')[0] ?
			$this->el->getElementsByTagName('nazev')[0]->textContent : null;
	}

	public function adresa(): ?Adresa
	{
		return $this->el->getElementsByTagName('adresa')[0] ?
			new Adresa($this->el->getElementsByTagName('adresa')[0]) : null;
	}

}
