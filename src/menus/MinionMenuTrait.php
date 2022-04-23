<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\menus;

use Mcbeany\BetterMinion\entities\BaseMinion;

trait MinionMenuTrait{

	public function __construct(
		protected ?BaseMinion $minion = null
	){
	}

	public function getMinion() : ?BaseMinion{
		return $this->minion;
	}

}