<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\utils;

use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\LegacyStringToItemParserException;
use pocketmine\item\StringToItemParser;

final class Utils{

	/**
	 * @throws LegacyStringToItemParserException
	 */
	public static function parseItem(string $item) : Item{
		return StringToItemParser::getInstance()->parse($item)
			?? LegacyStringToItemParser::getInstance()->parse($item);
	}

	public static function getRomanNumeral(int $integer) : string{
		$romanNumeralConversionTable = [
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1,
		];
		$romanString = '';
		while($integer > 0){
			foreach($romanNumeralConversionTable as $rom => $arb){
				if($integer >= $arb){
					$integer -= $arb;
					$romanString .= $rom;

					break;
				}
			}
		}
		return $romanString;
	}

}