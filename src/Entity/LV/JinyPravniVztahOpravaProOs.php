<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class JinyPravniVztahOpravaProOs
{

	/** @var DOMElement */
	private $el;

	public function __construct(DOMElement $el)
	{
		$this->el = $el;
	}

	public function podilPohledavka(): string
	{
		return $this->el->getElementsByTagName('PODIL_POHLEDAVKA')[0]->textContent;
	}

	public function proIdentOs(): ?OsNemIdentifikace
	{
		if ($this->el->getElementsByTagName('PRO_IDENT_OS')->length === 0) {
			return null;
		}

		return new OsNemIdentifikace($this->el->getElementsByTagName('PRO_IDENT_OS')[0]);
	}

}
