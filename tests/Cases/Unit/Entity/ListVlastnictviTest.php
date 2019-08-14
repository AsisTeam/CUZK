<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Unit\Entity;

use AsisTeam\CUZK\Entity\ListVlastnictvi;
use AsisTeam\CUZK\Entity\LV\Text;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

final class ListVlastnictviTest  extends TestCase
{

	public function testRead(): void
	{
		$lv = new ListVlastnictvi(file_get_contents(__DIR__ . '/data/lv.xml'));

		// basic information
		Assert::equal('2019-01-01', $lv->platnost()->format('Y-m-d'));
		Assert::equal('', $lv->bezplatnyPristup());
		Assert::equal('2019-08-12', $lv->vytvoreno()->format('Y-m-d'));
		Assert::equal('', $lv->infoVystup());
		Assert::null($lv->nemovistostiBezLv());

		// footer section
		$this->assertFooter($lv);

		// texts section
		Assert::count(1, $lv->texty());
		$this->assertText($lv->texty()[0]);
	}

	private function assertFooter(ListVlastnictvi $lv): void
	{
		Assert::equal('306', $lv->zapati()->kodKp());
		Assert::equal(
			'Katastrální úřad pro Jihočeský kraj, Katastrální pracoviště Prachatice, kód: 306.',
			$lv->zapati()->kp()
		);
	}

	private function assertText(Text $txt): void
	{
		$this->assertTextHeader($txt);
		$this->assertTextPozemky($txt);
	}

	private function assertTextHeader(Text $txt): void
	{
		Assert::equal(
			'V kat. území jsou pozemky vedeny ve dvou číselných řadách (St. = stavební parcela)',
			$txt->zahlavi()->ciselnaRada()
		);
		Assert::equal('807841306', $txt->zahlavi()->telId());
		Assert::equal('352', $txt->zahlavi()->cisloLv());
		Assert::equal('Prachatice', $txt->zahlavi()->okres());
		Assert::equal('CZ0315', $txt->zahlavi()->okresNuts4());
		Assert::equal('550426', $txt->zahlavi()->obecKod());
		Assert::equal('Mičovice', $txt->zahlavi()->obec());
		Assert::equal('Jáma', $txt->zahlavi()->katastralniUzemi());
		Assert::equal('693936', $txt->zahlavi()->katastralniUzemiKod());
		Assert::equal('', $txt->zahlavi()->katastralniUzemiPuv());
	}

	private function assertTextPozemky(Text $txt): void
	{
		Assert::count(6, $txt->pozemky());
		$parcel = $txt->pozemky()[0];

		// parcel identification
		Assert::count(1, $parcel->identifikace());
		$pId = $parcel->identifikace()[0];
		Assert::equal('2850901306', $pId->id());
		Assert::equal('', $pId->zkratka());
		Assert::equal('St.', $pId->druhCis());
		Assert::equal('807841306', $pId->telId());
		Assert::equal('', $pId->cisloTel());

		// parcel details
		Assert::equal('893', $parcel->vymera());
		Assert::equal('zastavěná plocha a nádvoří', $parcel->druh());
		Assert::equal('', $parcel->zpusobVyuziti());
		Assert::equal([], $parcel->zpusobOchrany());
		Assert::equal('', $parcel->plomba());
		Assert::equal('a', $parcel->soucasti());

		// buildings on multiple parcels - STAVBA_NA_VICE_PARCELACH
		Assert::count(1, $parcel->stavbaNaViceParcelach());
		$building = $parcel->stavbaNaViceParcelach()[0];
		Assert::equal('2850901306', $building->id());
		Assert::equal('St.', $building->druhCis());
		Assert::equal('807841306', $building->telId());

		// buildings as a part of parcel - SOUCASTI_STAVBA
		Assert::count(1, $parcel->soucastiStavba());
		$building = $parcel->soucastiStavba()[0];
		Assert::equal('293229306', $building->id());
		Assert::equal('Jáma', $building->caObce());
		Assert::equal('č.p.', $building->typ());
		Assert::equal('25', $building->cislaDomovni());
		Assert::equal('bydlení', $building->vyuziti());
		Assert::equal('807841306', $building->telId());
		Assert::equal('', $building->docasna());

		// buildings on parcel - STAVBA_NA_PARCELE
		Assert::null($parcel->stavbaNaParcele());

		// additionalInfo - DALSI_UDAJE
		Assert::null($parcel->dalsiUdajeStavbaSoucastiPozemku());
		Assert::null($parcel->dalsiUdajeStavbaSoucastiPravaStavby());

		// units - JEDNOTKY
		Assert::equal([], $parcel->jednotky());
	}

}

(new ListVlastnictviTest())->run();
