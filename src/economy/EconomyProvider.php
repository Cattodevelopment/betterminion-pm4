<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\economy;

use pocketmine\player\Player;

interface EconomyProvider{

	public function get(Player $player) : ?float;

	public function add(Player $player, float $amount = 0) : void;

	public function reduce(Player $player, float $amount = 0) : void;

	public function set(Player $player, float $amount = 0) : void;

	public function getEconomy();
}