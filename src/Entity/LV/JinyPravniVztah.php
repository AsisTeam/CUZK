<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JinyPravniVztah
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function hjpvId(): string
	{
		return $this->el->getElementsByTagName('HJPV_ID')[0]->textContent;
	}

	public function typ(): string
	{
		return $this->el->getElementsByTagName('TYP_PRAVNIHO_VZTAHU')[0]->textContent;
	}

	public function poradiDatum(): string
	{
		if ($this->el->getElementsByTagName('PORADI_K')->length === 0) {
			return '';
		}

		/** @var DOMElement $p */
		$p = $this->el->getElementsByTagName('PORADI_K')[0];
		return $p->getElementsByTagName('datum')[0]->textContent ?? '';
	}

	public function poradiText(): string
	{
		if ($this->el->getElementsByTagName('PORADI_K')->length === 0) {
			return '';
		}

		/** @var DOMElement $p */
		$p = $this->el->getElementsByTagName('PORADI_K')[0];
		return $p->getElementsByTagName('text_o_prednostnim_poradi')[0]->textContent ?? '';
	}

	/**
	 * @return JinyPravniVztahPopis[]
	 */
	public function popisy(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_POPISY') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('JPV_POPIS') as $n) {
				$items[] = new JinyPravniVztahPopis($n);
			}
		}

		return $items;
	}

	/**
	 * @return JinyPravniVztahOpravaProOs[]
	 */
	public function opravyProOs(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_OPRAV_PRO_OS') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('JPV_PRO_OS') as $n) {
				$items[] = new JinyPravniVztahOpravaProOs($n);
			}
		}

		return $items;
	}

	/**
	 * @return OsNemIdentifikace[]
	 */
	public function opravyProNem(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_OPRAV_PRO_NEM') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('JPV_PRO_NEM') as $n) {
				/** @var DOMElement $o */
				foreach ($n->getElementsByTagName('PRO_IDENT_NEM') as $o) {
					$items[] = new OsNemIdentifikace($o);
				}
			}
		}

		return $items;
	}

	/**
	 * @return OsNemIdentifikace[]
	 */
	public function povinOs(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_POVIN_K_OS') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('JPV_K_OS') as $n) {
				/** @var DOMElement $o */
				foreach ($n->getElementsByTagName('K_IDENT_OS') as $o) {
					$items[] = new OsNemIdentifikace($o);
				}
			}
		}

		return $items;
	}

	/**
	 * @return OsNemIdentifikace[]
	 */
	public function povinNem(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_POVIN_K_NEM') as $subj) {
			/** @var DOMElement $n */
			foreach ($subj->getElementsByTagName('JPV_K_NEM') as $n) {
				/** @var DOMElement $o */
				foreach ($n->getElementsByTagName('K_IDENT_NEM') as $o) {
					$items[] = new OsNemIdentifikace($o);
				}
			}
		}

		return $items;
	}

	/**
	 * @return JinyPravniVztahListina[]
	 */
	public function listiny(): array
	{
		$items = [];

		/** @var DOMElement $subj */
		foreach ($this->el->getElementsByTagName('JPV_LISTINY') as $subj) {
			/** @var DOMElement $l */
			foreach ($subj->getElementsByTagName('JPV_LISTINA') as $l) {
				$items[] = new JinyPravniVztahListina($l);
			}
		}

		return $items;
	}

}
