<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\minions;

use Mcbeany\BetterMinion\entities\types\FarmingMinion;
use Mcbeany\BetterMinion\entities\types\MiningMinion;
use pocketmine\utils\EnumTrait;
use function mb_strtoupper;
use function ucfirst;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see build/generate-registry-annotations.php
 * @generate-registry-docblock
 *
 * @method static MinionType MINING()
 * @method static MinionType FARMING()
 */
final class MinionType{
	use EnumTrait {
		EnumTrait::__construct as private __enumConstruct;
	}

	private string $className;

	private function __construct(string $enumName, string $className){
		$this->__enumConstruct($enumName);
		$this->className = $className;
	}

	protected static function setup() : void{
		self::registerAll(
			new self("mining", MiningMinion::class),
			new self("farming", FarmingMinion::class)
		);
	}

	public static function fromString(string $name) : ?self{
		self::checkInit();
		return self::$members[mb_strtoupper($name)] ?? null;
	}

	public function className() : string{
		return $this->className;
	}

	public function typeName() : string{
		return ucfirst($this->name());
	}

}