<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\menus\inventories;

use Mcbeany\BetterMinion\BetterMinion;
use Mcbeany\BetterMinion\entities\BaseMinion;
use Mcbeany\BetterMinion\menus\InventoryMenu;
use Mcbeany\BetterMinion\menus\MinionMenuTrait;
use Mcbeany\BetterMinion\utils\Language;
use Mcbeany\BetterMinion\utils\Utils;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\utils\DyeColor;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use function array_fill;
use function array_map;
use function array_search;
use function floor;
use function in_array;
use function range;

class MinionMainMenu extends InventoryMenu{
	use MinionMenuTrait {
		__construct as private __constructMinionMenu;
	}

	protected const TYPE = InvMenuTypeIds::TYPE_DOUBLE_CHEST;

	protected bool $readonly = true;
	private array $invSlots;

	public function __construct(?BaseMinion $minion = null){
		parent::__construct();
		$this->name = $minion?->getOriginalNameTag() ?? "";
		$this->invSlots = array_map(fn (int $i) => (int) (21 + ($i % 5) + (9 * (floor($i / 5)))), range(0, BaseMinion::MAX_LEVEL));
		$this->__constructMinionMenu($minion);
	}

	public function render() : void{
		$inv = $this->getInvMenu()->getInventory();
		$inv->setContents(array_fill(0, 54, VanillaBlocks::INVISIBLE_BEDROCK()->asItem()->setCustomName("§k"))); //TODO: Hacks (This make item name become empty like "")
		foreach($this->invSlots as $i => $slot){
			$invItem = $this->getMinion()->getMinionInventory()->slotExists($i) ?
				$this->getMinion()->getMinionInventory()->getItem($i) :
				VanillaBlocks::STAINED_GLASS()->setColor(DyeColor::RED())->asItem()->setCustomName("Unlock at level " . Utils::getRomanNumeral($i + 1));
			$inv->setItem($slot, $invItem);
		}
		$info_item = VanillaItems::PLAYER_HEAD()->setCustomName("§r§f" . $this->getMinion()->getOriginalNameTag());
		$info_item->setLore([
			"§r§fTier: " . Utils::getRomanNumeral($this->getMinion()->getMinionInfo()->getLevel()),
			"§r§fCollected Resources: " . $this->getMinion()->getMinionInfo()->getCollectedResources(),
		]);
		$inv->setItem(4, $info_item);
		$inv->setItem(10, VanillaBlocks::FURNACE()->asItem()->setCustomName("AutoSmelter")->setLore(["Comming soon !"]));
		$inv->setItem(19, VanillaBlocks::HOPPER()->asItem()->setCustomName("AutoSell")->setLore(["Comming soon !"]));
		$inv->setItem(28, VanillaBlocks::LEGACY_STONECUTTER()->asItem()->setCustomName("Compactor")->setLore(["Comming soon !"]));
		$inv->setItem(37, BlockFactory::getInstance()->get(BlockLegacyIds::COMMAND_BLOCK, 0)->asItem()->setCustomName("Expander")->setLore(["Comming soon !"]));
		$inv->setItem(48, VanillaBlocks::CHEST()->asItem()->setCustomName("Retrieve all results"));
		$inv->setItem(50, VanillaItems::EXPERIENCE_BOTTLE()->setCustomName("Upgrade Minion"));
		$inv->setItem(53, VanillaBlocks::BEDROCK()->asItem()->setCustomName("Remove your minion"));
	}

	public function onResponse(Player $player, $response){
		$this->getMinion()->continueWorking();
		$slot = $response->getAction()->getSlot();
		switch($slot){
			case 48:
				$player->sendMessage(Language::retrieved_all_results());
				for($i = 0; $i < $this->getMinion()->getMinionInventory()->getSize(); $i++){
					if(!$this->getMinion()->takeStuff($i, $player)){
						$player->sendMessage(Language::inventory_is_full());
						break;
					}
				}
				$this->onUpdate();
				break;
			case 53:
				$info = $this->getMinion()->getMinionInfo();
				$spawner = BetterMinion::getInstance()->createSpawner(
					$info->getType(),
					$info->getTarget(),
					$info->getLevel(),
					$info->getMoneyHeld(),
					$info->getCollectedResources()
				);
				if($player->getInventory()->canAddItem($spawner)){
					$this->getMinion()->flagForDespawn();
					$player->getInventory()->addItem($spawner);
				}else{
					$player->sendMessage(Language::inventory_is_full());
				}
				$this->forceClose($player);
				break;
			case 50:
				//TODO: Upgrade cost
				$this->getMinion()->levelUp();
				$this->onUpdate();
				break;
			default:
				if(in_array($slot, $this->invSlots, true)){
					if(!$this->getMinion()->takeStuff(array_search($slot, $this->invSlots, true), $player)){
						$player->sendMessage(Language::inventory_is_full());
					}
					$this->onUpdate();
				}
				break;
		}
		$this->getMinion()->continueWorking();
	}

	public function onClose(Player $player) : void{
		$this->getMinion()->removeMenu($this);
	}

	public function display(Player $player) : void{
		parent::display($player);
		$this->getMinion()->registerMenu($this);
	}

	public function onUpdate() : void{
		$this->render();
	}

}
