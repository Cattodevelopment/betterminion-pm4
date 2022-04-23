<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\economy;

use Mcbeany\BetterMinion\BetterMinion;
use Mcbeany\BetterMinion\utils\Configuration;
use function array_keys;
use function in_array;
use function mb_strtolower;

class EconomyProviderManager{

	protected const AVAILABLE_PROVIDERS = [
		"economyapi" => EconomyAPIProvider::class,
		"bedrockeconomy" => BedrockEconomyProvider::class,
		"economy" => EconomyAPIProvider::class,
	];

	protected static ?EconomyProvider $provider = null;

	public static function load(){
		$available = mb_strtolower(Configuration::economy_provider());
		if(!in_array($available, array_keys(self::AVAILABLE_PROVIDERS), true)){
			BetterMinion::getInstance()->getLogger()->error("Economy provider $available is not available.");
			return;
		}
		foreach(self::AVAILABLE_PROVIDERS as $name => $class){
			if($available === $name){
				self::$provider = new $class();
				if (self::$provider->getEconomy() === null){
					BetterMinion::getInstance()->getLogger()->error("Couldn't found selected economy plugin, disabling economy feature...");
					self::$provider = null;
				}
				return;
			}
		}
	}

	public static function getProvider() : ?EconomyProvider{
		return self::$provider;
	}
}