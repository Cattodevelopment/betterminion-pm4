<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\events;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

class MinionCollectResourcesEvent extends MinionEvent implements Cancellable{
	use CancellableTrait;
}