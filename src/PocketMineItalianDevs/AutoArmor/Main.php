<?php

namespace PocketMineItalianDevs\AutoArmor;

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

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @param Item   $armor
	 * @param Player $player
	 */
	public function setArmorByType(Item $armor,Player $player){
		$id = $armor->getId();
		if(in_array($id,self::HELMET,true)){
			$copy = $player->getArmorInventory()->getHelmet();
			$player->getArmorInventory()->setHelmet($armor);
			$player->getInventory()->setItemInHand($copy);
		}
		elseif(in_array($id,self::CHESTPLATE,true)){
			$copy = $player->getArmorInventory()->getChestplate();
			$player->getArmorInventory()->setChestplate($armor);
			$player->getInventory()->setItemInHand($copy);
		}
		elseif(in_array($id,self::LEGGINGS,true)){
			$copy = $player->getArmorInventory()->getLeggings();
			$player->getArmorInventory()->setLeggings($armor);
			$player->getInventory()->setItemInHand($copy);
		}
		else{
			$copy = $player->getArmorInventory()->getBoots();
			$player->getArmorInventory()->setBoots($armor);
			$player->getInventory()->setItemInHand($copy);
		}
	}

	/**
	 * @param PlayerInteractEvent $event
	 *
	 * @priority HIGHEST
	 * @ignoreCancelled true
	 */
	public function onInteract(PlayerInteractEvent $event){
		if(($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR or $event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK) and ($event->getItem() instanceof Armor or $event->getItem()->getId() === Item::ELYTRA)){
			$this->setArmorByType($event->getItem(),$event->getPlayer());
			$event->setCancelled(true);
		}
	}
}
