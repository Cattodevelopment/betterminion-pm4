<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\utils;

use Mcbeany\BetterMinion\BetterMinion;
use Mcbeany\BetterMinion\minions\MinionInfo;
use Mcbeany\BetterMinion\minions\MinionType;
use pocketmine\block\Block;
use pocketmine\lang\Language as PMLang;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use function explode;
use function var_export;

final class Language extends PMLang{
	use SingletonTrait {
		setInstance as private;
		getInstance as private;
	}

	public const AVAILABLE_LANGS = [
		"eng" //TODO: Custom Language Config
	];

	public static function load(){
		foreach(self::AVAILABLE_LANGS as $lang){
			BetterMinion::getInstance()->saveResource("langs" . DIRECTORY_SEPARATOR . "$lang.ini");
		}
		$instance = new self(
			Configuration::language(),
			BetterMinion::getInstance()->getDataFolder() . "langs"
		);
		self::setInstance($instance);
	}

	public static function type_not_found(string $input) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.type.notfound"),
			[
				"type" => $input
			]
		));
	}

	public static function target_not_found(string $input) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.target.notfound"),
			[
				"target" => $input
			]
		));
	}

	public static function player_not_found(string $input) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.player.notfound"),
			[
				"player" => $input
			]
		));
	}

	public static function no_selected_player() : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.no.player")));
	}

	public static function gave_player_spawner(Player $player, MinionType $type, Block $target) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.success"),
			[
				"player" => $player->getName(),
				"type" => $type->typeName(),
				"target" => $target->getName()
			]
		));
	}

	public static function received_minion_spawner(MinionType $type, Block $target) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.give.received"),
			[
				"type" => $type->typeName(),
				"target" => $target->getName()
			]
		));
	}

	public static function toggled_remove_mode(bool $mode) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("command.remove.toggle"),
			[
				"mode" => self::toggle_mode_name($mode)
			]
		));
	}

	private static function toggle_mode_name(bool $mode) : string{
		return $mode
			? self::getInstance()->translate(new Translatable(self::getInstance()->get("misc.enable")))
			: self::getInstance()->translate(new Translatable(self::getInstance()->get("misc.disable")));
	}

	public static function minion_spawner_name(MinionInfo $info) : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("misc.spawner.name"),
			[
				"type" => $info->getType()->typeName(),
				"target" => $info->getRealTarget()->getName(),
				"level" => $info->getLevel(),
				"romanLevel" => Utils::getRomanNumeral($info->getLevel())
			]
		));
	}

	public static function minion_spawner_lore(MinionInfo $info) : array{
		$contents = explode(PHP_EOL, self::getInstance()->get("misc.spawner.lore"), 4); // Max lines limit?
		$lores = [];
		foreach($contents as $content){
			$lores[] = self::getInstance()->translate(new Translatable($content,
				[
					"type" => $info->getType()->typeName(),
					"target" => $info->getRealTarget()->getName(),
					"level" => $info->getLevel(),
					"romanLevel" => Utils::getRomanNumeral($info->getLevel()),
					"autoSmelter" => var_export($info->getUpgrade()->hasAutoSmelter(), true),
					"autoSeller" => var_export($info->getUpgrade()->hasAutoSeller(), true),
					"compactor" => var_export($info->getUpgrade()->hasCompactor(), true),
					"expander" => var_export($info->getUpgrade()->hasExpander(), true)
				]
			));
		}
		return $lores;
	}

	public static function inventory_is_full() : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("misc.inventory.full")));
	}

	public static function retrieved_all_results() : string{
		return self::getInstance()->translate(new Translatable(self::getInstance()->get("misc.inventory.retrieved")));
	}

}