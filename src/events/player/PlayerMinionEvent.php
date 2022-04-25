<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\events\player;

use Mcbeany\BetterMinion\entities\BaseMinion;
use pocketmine\event\player\PlayerEvent;
use pocketmine\player\Player;

class PlayerMinionEvent extends PlayerEvent{

	protected BaseMinion $minion;

	public function __construct(Player $player, BaseMinion $minion){
		$this->player = $player;
		$this->minion = $minion;
	}

	public function getMinion() : BaseMinion{
		return $this->minion;
	}
}