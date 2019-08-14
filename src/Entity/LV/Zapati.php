<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity\LV;

use DOMElement;

class Zapati
{

	/** @var string */
	private $code = '';

	/** @var string */
	private $name = '';

	public function __construct(DOMElement $footer)
	{
		$z = $footer->getElementsByTagName('ZAPATI_LV');
		if ($z[0]) {
			/** @var DOMElement $rec */
			$rec = $z[0];
			$this->code = $rec->getElementsByTagName('KODKP')[0]->textContent;
			$this->name = $rec->getElementsByTagName('KP')[0]->textContent;
		}
	}

	public function kodKp(): string
	{
		return $this->code;
	}

	public function kp(): string
	{
		return $this->name;
	}

}
