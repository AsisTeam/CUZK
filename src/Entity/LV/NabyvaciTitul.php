<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

final class NabyvaciTitul
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function polvz(): string
	{
		return $this->el->getElementsByTagName('POLVZ')[0]->textContent ?? '';
	}

	public function rizeniE(): string
	{
		return $this->el->getElementsByTagName('RIZENI_E')[0]->textContent ?? '';
	}

	public function nazevList(): NazevListIdentifikace
	{
		return new NazevListIdentifikace($this->el->getElementsByTagName('NAZEV_LIST_E')[0]);
	}

	public function rizeni(): RizeniIdentifikace
	{
		return new RizeniIdentifikace($this->el->getElementsByTagName('IDENT_RIZENI')[0]);
	}

	/**
	 * @return OpravnenySubjektIdentifikace[]
	 */
	public function pro(): array
	{
		/** @var DOMElement $ntPro */
		$ntPro = $this->el->getElementsByTagName('NT_PRO')[0];
		$list = [];

		/** @var DOMElement $subj */
		foreach ($ntPro->getElementsByTagName('OPRAV_SUBJEKT') as $subj) {
			/** @var DOMElement $item */
			foreach ($subj->getElementsByTagName('oprav_subjekt') as $item) {
				$list[] = new OpravnenySubjektIdentifikace($item);
			}
		}

		return $list;
	}

}
