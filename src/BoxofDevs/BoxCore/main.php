<?php

namespace BoxofDevs\BoxCore;

use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Color;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

class main extends PluginBase implements Listener {
	
	public $prefix = "";
	
	public function onLoad(){
		$this->getLogger()->info(C::YELLOW."Box is opening..");
	}
	
	public function onEnable(){
		$this->getLogger()->info(C::GREEN."Box opened!");
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
        $this->setRank($player);
	}
	
	public function setRank($player){
		$name = $player->getName();
		$rankyml = new Config($this->getDataFolder()."/rank.yml", Config::YAML);
		$rank = $rankyml->get($name);  
		if($rank == "Owner"){
			$player->setNameTag(C::DARK_PURPLE."Owner".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "Co-Owner"){
			$player->setNameTag(C::GREEN."Co-Owner:".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "Admin"){
			$player->setNameTag(C::DARK_BLUE."Administrator".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "Builder"){
			$player->setNameTag(C::YELLOW."Builder".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "VIP"){
			$player->setNameTag(C::GOLD."VIP".C::GRAY ." | ".C::AQUA.$name);
		}else{
			$player->setNameTag(C::YELLOW."Player".C::GRAY." | ".C::AQUA $name);
		}
	}
	
	public function onDisable(){
		$this->getLogger()->info(C::RED."Closing Box!");
	}
}