<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\utils;

use Mcbeany\BetterMinion\BetterMinion;
use pocketmine\item\Item;
use pocketmine\lang\Language;
use function gettype;
use function is_object;

final class Configuration{

	public static function load(){
		BetterMinion::getInstance()->saveDefaultConfig();
		BetterMinion::getInstance()->getConfig()->setDefaults(self::default());
	}

	private static function default() : array{
		return [
			"language" => Language::FALLBACK_LANGUAGE,
			"minion-spawner" => "nether_star",
			"minion-size" => 0.5,
			"economy-provider" => "bedrockeconomy"
		];
	}

	public static function language() : string{
		return self::get("language");
	}

	public static function minion_spawner() : Item{
		return Utils::parseItem(self::get("minion-spawner"));
	}

	public static function minion_size() : float{
		return self::get("minion-size");
	}

	public static function economy_provider() : string{
		return self::get("economy-provider");
	}

	protected static function get(string $key) : mixed{
		$set = BetterMinion::getInstance()->getConfig()->get($key);
		$default = self::default()[$key];
		$compare = "is_" . (is_object($default) ? "object" : gettype($default));
		if(!$compare($set)){
			// TODO: Warn server's owner that the configuration has an incorrect data type
			BetterMinion::getInstance()->getConfig()->set($key, $default);
			BetterMinion::getInstance()->getConfig()->save();
		}
		return $set;
	}

}