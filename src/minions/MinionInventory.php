<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\minions;

use Mcbeany\BetterMinion\entities\BaseMinion;
use pocketmine\inventory\SimpleInventory;
use pocketmine\item\Item;

class MinionInventory extends SimpleInventory{

	protected BaseMinion $minion;

	public function __construct(int $size, BaseMinion $minion){
		$this->minion = $minion;
		parent::__construct($size);
	}

	public function setItem(int $index, Item $item) : void{
		parent::setItem($index, $item);
		$this->getMinion()->updateMenu();
	}

	public function setContents(array $items) : void{
		parent::setContents($items);
		$this->getMinion()->updateMenu();
	}

	public function setSize(int $size) : void{
		$this->slots->setSize($size);
	}

	public function getMinion() : BaseMinion{
		return $this->minion;
	}
}