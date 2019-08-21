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
		$this->assertTextBudovy($txt);
		$this->assertTextUkony($txt);
		$this->assertTextNabyvaciTituly($txt);
		$this->assertTextBonity($txt);
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

	private function assertTextBudovy(Text $txt): void
	{
		Assert::count(0, $txt->budovy());
	}

	private function assertTextUkony(Text $txt): void
	{
		Assert::count(0, $txt->ukony());
	}

	private function assertTextNabyvaciTituly(Text $txt): void
	{
		Assert::count(1, $txt->nabyvaciTituly());
		$nt = $txt->nabyvaciTituly()[0];

		Assert::equal('', $nt->polvz());
		Assert::equal('', $nt->rizeniE());

		// nazevList - NAZEV_LIST_E
		Assert::equal('Smlouva', $nt->nazevList()->tlist());
		Assert::equal('kupní, o zřízení věcného břemene - bezúplatná', $nt->nazevList()->dalsiUdaje());
		Assert::equal('', $nt->nazevList()->poradoveCisloZhotoveni());
		Assert::equal('', $nt->nazevList()->popis());
		Assert::equal('ze dne 12.02.2010.', $nt->nazevList()->vystavTxt());
		Assert::equal('', $nt->nazevList()->pravMocTxt());
		Assert::equal('', $nt->nazevList()->vykonatelnostTxt());
		Assert::equal('Právní účinky vkladu práva ke dni 19.02.2010.', $nt->nazevList()->podaniTxt());
		Assert::equal('', $nt->nazevList()->podanizTxt());
		Assert::equal('', $nt->nazevList()->zplatneniTxt());

		// rizeni - IDENT_RIZENI
		Assert::equal('V', $nt->rizeni()->typRizeni());
		Assert::equal('435', $nt->rizeni()->poradoveCislo());
		Assert::equal('2010', $nt->rizeni()->rok());
		Assert::equal('306', $nt->rizeni()->prares());

		// opravneny subjekt - NT_PRO
		Assert::count(1, $nt->pro());
		$os = $nt->pro()[0];
		// opravneny subjekt - OPRAV_SUBJEKT
		Assert::equal('898600307', $os->id());
		Assert::equal('740727', $os->rc6());
		Assert::equal('4919', $os->rc7());
		Assert::equal('Giňa', $os->prijmeni());
		Assert::equal('Jan', $os->jmeno());
		Assert::equal('', $os->titulPred());
		Assert::equal('', $os->titulZa());
		// opravneny subjekt - adresa
		Assert::equal('', $os->adresa()->adresniMisto());
		Assert::equal('Rynky', $os->adresa()->nazevUlice());
		Assert::equal('1', $os->adresa()->cpCe());
		Assert::equal('1224', $os->adresa()->cisloDomovni());
		Assert::equal('', $os->adresa()->cisloOrientacni());
		Assert::equal('Palkovice', $os->adresa()->castObce());
		Assert::equal('Kopřivnice', $os->adresa()->obec());
		Assert::equal('', $os->adresa()->mestskaCast());
		Assert::equal('', $os->adresa()->mestskyObvod());
		Assert::equal('11000', $os->adresa()->psc());
		Assert::equal('Praha 1', $os->adresa()->dodaciPosta());
		// opravneny subjekt - charOs
		Assert::equal('2', $os->charOs()->kod());
		Assert::equal('', $os->charOs()->zkratka());
		Assert::equal('', $os->charOs()->zkratkaAlv());
	}

	private function assertTextBonity(Text $txt): void
	{
		Assert::count(3, $txt->bonity());
		$b = $txt->bonity()[0];
		// bonita - BON_PARCELNI_CISLO
		Assert::equal('3531514306', $b->parcela()->id());
		Assert::equal('', $b->parcela()->zkratka());
		Assert::equal('', $b->parcela()->druhCis());
		Assert::equal(' 1538', $b->parcela()->parCis());
		Assert::equal('6', $b->parcela()->poddCis());
		Assert::equal('807841306', $b->parcela()->telId());
		// bonita - JINE_KU
		Assert::equal('', $b->jineKuKod());
		Assert::equal('', $b->jineKuNazev());
		// bonita - BONITY_BPEJ
		Assert::count(2, $b->bpej());
		Assert::equal('85011', $b->bpej()[0]->kod());
		Assert::equal(2828, $b->bpej()[0]->vymera());
		Assert::equal('85044', $b->bpej()[1]->kod());
		Assert::equal(24200, $b->bpej()[1]->vymera());
	}

}

(new ListVlastnictviTest())->run();
