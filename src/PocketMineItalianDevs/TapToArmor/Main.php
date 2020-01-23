<?php

namespace PocketMineItalianDevs\TapToArmor;

use pocketmine\block\Block;
use pocketmine\item\Armor;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use function in_array;

class Main extends PluginBase implements Listener{

	/** @var int[] */
	public const
		HELMET = [
		Item::LEATHER_HELMET,
		Item::CHAIN_HELMET,
		Item::IRON_HELMET,
		Item::GOLD_HELMET,
		Item::DIAMOND_HELMET,
	],
		CHESTPLATE = [
		Item::LEATHER_CHESTPLATE,
		Item::CHAIN_CHESTPLATE,
		Item::IRON_CHESTPLATE,
		Item::GOLD_CHESTPLATE,
		Item::DIAMOND_CHESTPLATE,
		Item::ELYTRA,
	],
		LEGGINGS = [
		Item::LEATHER_LEGGINGS,
		Item::CHAIN_LEGGINGS,
		Item::IRON_LEGGINGS,
		Item::GOLD_LEGGINGS,
		Item::DIAMOND_LEGGINGS,
	],
		BOOTS = [
		Item::LEATHER_BOOTS,
		Item::CHAIN_BOOTS,
		Item::IRON_BOOTS,
		Item::GOLD_BOOTS,
		Item::DIAMOND_BOOTS,
	];

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @param Item   $armor An Armor or an elytra
	 * @param Player $player
	 */
	private function setArmorByType(Item $armor,Player $player) : void{
		$id = $armor->getId();
		if(in_array($id, self::HELMET, true)){
			$copy = $player->getArmorInventory()->getHelmet();
			$set = $player->getArmorInventory()->setHelmet($armor);
		}
		elseif(in_array($id, self::CHESTPLATE, true)){
			$copy = $player->getArmorInventory()->getChestplate();
			$set = $player->getArmorInventory()->setChestplate($armor);
		}
		elseif(in_array($id, self::LEGGINGS, true)){
			$copy = $player->getArmorInventory()->getLeggings();
			$set = $player->getArmorInventory()->setLeggings($armor);
		}
		elseif(in_array($id, self::BOOTS, true)){
			$copy = $player->getArmorInventory()->getBoots();
			$set = $player->getArmorInventory()->setBoots($armor);
		}
		if(isset($set) and $set){
		    //if $set is defined, $copy is defined too
		    /** @var Item $copy */
			$player->getInventory()->setItemInHand($copy);
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 *
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 */
	public function onInteract(PlayerInteractEvent $event) : void{
		if(($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR or $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) and ($event->getItem() instanceof Armor or $event->getItem()->getId() === Item::ELYTRA) and $event->getBlock()->getId() !== Block::ITEM_FRAME_BLOCK){
			$this->setArmorByType($event->getItem(), $event->getPlayer());
			$event->setCancelled(true);
		}
	}
}
