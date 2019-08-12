<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Entity;

use DateTime;
use stdClass;

final class Report
{

	public const FORMAT_PDF  = 'pdf';
	public const FORMAT_XML  = 'xml';
	public const FORMAT_HTML = 'html';
	public const FORMAT_ZIP  = 'zip';

	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var string */
	private $status;

	/** @var string */
	private $format;

	/** @var int|null */
	private $subId;

	/** @var int|null */
	private $masterId;

	/** @var DateTime */
	private $dateRequested;

	/** @var DateTime */
	private $dateStarted;

	/** @var DateTime */
	private $dateCreated;

	/** @var int */
	private $units;

	/** @var int */
	private $pages;

	/** @var string */
	private $price;

	/** @var bool */
	private $electronicMark;

	/** @var string */
	private $content;

	public static function extract(stdClass $data): self
	{
		//basic info
		$r         = new self();
		$r->id     = $data->id ?? 0;
		$r->status = $data->stav ?? '';
		$r->format = $data->format ?? '';
		$r->name   = $data->nazev ?? '';

		// dates
		$r->dateRequested = property_exists($data, 'datumPozadavku') ?
			new DateTime($data->datumPozadavku) : new DateTime();
		$r->dateStarted   = property_exists($data, 'datumSpusteni') ?
			new DateTime($data->datumSpusteni) : new DateTime();
		$r->dateCreated   = property_exists($data, 'datumVytvoreni') ?
			new DateTime($data->datumVytvoreni) : new DateTime();

		// relations
		$r->subId    = $data->idPodrizeneSestavy ?? null;
		$r->masterId = $data->idNadrizeneSestavy ?? null;

		// file info
		$r->units          = $data->pocetJednotek ?? 0;
		$r->pages          = $data->pocetStran ?? 0;
		$r->price          = $data->cena ?? '';
		$r->electronicMark = property_exists($data, 'elZnacka') ? $data->elZnacka === 'a' ? true : false : false;
		$r->content        = $data->souborSestavy ?? '';

		return $r;
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	public function setStatus(string $status): void
	{
		$this->status = $status;
	}

	public function getFormat(): string
	{
		return $this->format;
	}

	public function setFormat(string $format): void
	{
		$this->format = $format;
	}

	public function getSubId(): ?int
	{
		return $this->subId;
	}

	public function setSubId(?int $subId): void
	{
		$this->subId = $subId;
	}

	public function getMasterId(): ?int
	{
		return $this->masterId;
	}

	public function setMasterId(?int $masterId): void
	{
		$this->masterId = $masterId;
	}

	public function getDateRequested(): DateTime
	{
		return $this->dateRequested;
	}

	public function setDateRequested(DateTime $dateRequested): void
	{
		$this->dateRequested = $dateRequested;
	}

	public function getDateStarted(): DateTime
	{
		return $this->dateStarted;
	}

	public function setDateStarted(DateTime $dateStarted): void
	{
		$this->dateStarted = $dateStarted;
	}

	public function getDateCreated(): DateTime
	{
		return $this->dateCreated;
	}

	public function setDateCreated(DateTime $dateCreated): void
	{
		$this->dateCreated = $dateCreated;
	}

	public function getUnits(): int
	{
		return $this->units;
	}

	public function setUnits(int $units): void
	{
		$this->units = $units;
	}

	public function getPages(): int
	{
		return $this->pages;
	}

	public function setPages(int $pages): void
	{
		$this->pages = $pages;
	}

	public function getPrice(): string
	{
		return $this->price;
	}

	public function setPrice(string $price): void
	{
		$this->price = $price;
	}

	public function isElectronicMark(): bool
	{
		return $this->electronicMark;
	}

	public function setElectronicMark(bool $electronicMark): void
	{
		$this->electronicMark = $electronicMark;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function setContent(string $content): void
	{
		$this->content = $content;
	}

}
