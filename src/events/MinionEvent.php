<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\events;

use Mcbeany\BetterMinion\entities\BaseMinion;
use pocketmine\event\Event;

abstract class MinionEvent extends Event{

	protected BaseMinion $minion;

	public function __construct(BaseMinion $minion){
		$this->minion = $minion;
	}

	public function getMinion() : BaseMinion{
		return $this->minion;
	}

}