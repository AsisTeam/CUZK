<?php declare(strict_types = 1);

namespace AsisTeam\CUZK\Tests\Cases\Unit\Entity;

use AsisTeam\CUZK\Entity\ListVlastnictvi;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

final class ListVlastnictviTest  extends TestCase
{

	public function testRead(): void
	{
		$lv = new ListVlastnictvi(file_get_contents(__DIR__ . '/data/lv.xml'));
		Assert::equal('2019-01-01', $lv->getValidity()->format('Y-m-d'));
		Assert::equal('2019-08-12', $lv->getCreatedOn()->format('Y-m-d'));
	}

}

(new ListVlastnictviTest())->run();
