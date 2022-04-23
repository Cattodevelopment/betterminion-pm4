<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\economy;

use onebone\economyapi\EconomyAPI;
use pocketmine\player\Player;
use pocketmine\Server;

use function is_numeric;

class EconomyAPIProvider implements EconomyProvider{

	public function get(Player $player) : ?float{
		$money = $this->getEconomy()->myMoney($player);
		if(is_numeric($money)){
			return $money;
		}
		return null;
	}

	public function add(Player $player, float $amount = 0) : void{
		$this->getEconomy()->addMoney($player, $amount);
	}

	public function reduce(Player $player, float $amount = 0) : void{
		$this->getEconomy()->reduceMoney($player, $amount);
	}

	public function set(Player $player, float $amount = 0) : void{
		$this->getEconomy()->setMoney($player, $amount);
	}

	public function getEconomy() : ?EconomyAPI{
		$economy = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
		if($economy instanceof EconomyAPI) return $economy;
		return null;
	}
}