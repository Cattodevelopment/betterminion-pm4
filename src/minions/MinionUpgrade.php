<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\minions;

use pocketmine\nbt\tag\CompoundTag;

class MinionUpgrade implements MinionNBT{

	public function __construct(
		protected bool $autoSmelter = false,
		protected bool $autoSeller = false,
		protected bool $compactor = false,
		protected bool $expander = false
	){
	}

	public static function nbtDeserialize(CompoundTag $nbt) : self{
		return new self(
			(bool) $nbt->getByte(MinionNBT::AUTO_SMELTER),
			(bool) $nbt->getByte(MinionNBT::AUTO_SELLER),
			(bool) $nbt->getByte(MinionNBT::COMPACTOR),
			(bool) $nbt->getByte(MinionNBT::EXPANDER)
		);
	}

	public function nbtSerialize() : CompoundTag{
		return CompoundTag::create()
			->setByte(MinionNBT::AUTO_SMELTER, (int) $this->hasAutoSmelter())
			->setByte(MinionNBT::AUTO_SELLER, (int) $this->hasAutoSeller())
			->setByte(MinionNBT::COMPACTOR, (int) $this->hasCompactor())
			->setByte(MinionNBT::EXPANDER, (int) $this->hasExpander());
	}

	public function setAutoSmelter($autoSmelter = true) : void{
		$this->autoSmelter = $autoSmelter;
	}

	public function setAutoSeller($autoSeller = true) : void{
		$this->autoSeller = $autoSeller;
	}

	public function setCompactor($compactor = true) : void{
		$this->compactor = $compactor;
	}

	public function setExpander($expander = true) : void{
		$this->expander = $expander;
	}

	public function hasAutoSmelter() : bool{
		return $this->autoSmelter;
	}

	public function hasAutoSeller() : bool{
		return $this->autoSeller;
	}

	public function hasCompactor() : bool{
		return $this->compactor;
	}

	public function hasExpander() : bool{
		return $this->expander;
	}

}