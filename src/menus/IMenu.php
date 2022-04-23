<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\menus;

use pocketmine\player\Player;

interface IMenu{

	public function render();

	public function onResponse(Player $player, $response);

	public function onClose(Player $player) : void;

	public function forceClose(Player $player) : void;

	public function display(Player $player) : void;

}