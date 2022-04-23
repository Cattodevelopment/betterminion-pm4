<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\menus;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

abstract class InventoryMenu implements IMenu{

	protected const TYPE = InvMenuTypeIds::TYPE_CHEST;

	protected InvMenu $invMenu;

	protected string $name = "";
	protected bool $readonly = false;

	public int $menu_id = 0;

	public function __construct(){
		$onResponse = fn(InvMenuTransaction $transaction) => $this->onResponse($transaction->getPlayer(), $transaction);
		$this->invMenu = InvMenu::create(static::TYPE)
			->setName($this->name)
			->setListener($this->readonly ? InvMenu::readonly($onResponse) : $onResponse);
		$this->getInvMenu()->setInventoryCloseListener(fn(Player $player, Inventory $inventory) => $this->onClose($player));
	}

	public function getInvMenu() : InvMenu{
		return $this->invMenu;
	}

	abstract public function render() : void;

	/**
	 * @param InvMenuTransaction $response
	 *
	 * @return InvMenuTransactionResult|void
	 */
	abstract public function onResponse(Player $player, $response);

	public function onClose(Player $player) : void{
	}

	public function forceClose(Player $player) : void{
		InvMenuHandler::getPlayerManager()->get($player)->removeCurrentMenu();
	}

	public function display(Player $player) : void{
		$this->render();
		$this->getInvMenu()->send($player);
	}

}
