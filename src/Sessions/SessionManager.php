<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\sessions;

use pocketmine\player\Player;

class SessionManager{

	/** @var Session[] $sessions */
	protected static array $sessions = [];

	public static function createSession(Player $player) : void{
		self::$sessions[$player->getId()] = new Session();
	}

	public static function getSession(Player $player) : ?Session{
		return self::$sessions[$player->getId()] ?? null;
	}

	public static function destroySession(Player $player) : void{
		unset(self::$sessions[$player->getId()]);
	}

}