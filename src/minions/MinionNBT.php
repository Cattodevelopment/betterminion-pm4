<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\minions;

use pocketmine\nbt\tag\CompoundTag;

interface MinionNBT{

	// Info
	public const INFO = "minionInfo";
	public const TYPE = "type";
	public const TARGET = "target";
	public const UPGRADE = "upgrade";
	public const LEVEL = "level";
	public const MONEY_HELD = "moneyHeld";
	public const COLLECTED_RESOURCES = "collectedResources";

	// Target
	public const BLOCK_ID = "blockId";
	public const VARIANT = "variant";

	// Owner
	public const OWNER = "owner";
	public const OWNER_NAME = "ownerName";

	// Inv
	public const INV = "minionInv";

	// Upgrade
	public const AUTO_SMELTER = "autoSmelter";
	public const AUTO_SELLER = "autoSeller";
	public const COMPACTOR = "compactor";
	public const EXPANDER = "expander";

	public static function nbtDeserialize(CompoundTag $nbt);

	public function nbtSerialize() : CompoundTag;

}