<?php

namespace BoxofDevs\BoxCore;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\tile\Sign;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\entity\Effect;
use pocketmine\event\entity\EntityLevelChangeEvent ; 
use pocketmine\tile\Chest;
use pocketmine\inventory\ChestInventory;
use pocketmine\event\plugin\PluginEvent;

class main extends PluginBase implements Listener {
	
	public $prefix = "";

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$config = $this->getConfig();
		$this->prefix = $config->get("Prefix")." ";
		$this->saveDefaultConfig();
	    	$this->getLogger()->info(C::GREEN."BoxCore has loaded!");
	}
	

	public function onJoin(PlayerJoinEvent $event){
		$config = $this->getConfig();
		#$event->setJoinMessage(""); //This could be useful in the future!
		$player = $event->getPlayer();
		$this->setRank($player);
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$config = $this->getConfig();
		#$event->setQuitMessage(""); //This could be useful in the future!
		$player = $event->getPlayer();
	}

	public function setRank(Player $player){
		$rankyml = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
       		$rank = $rankyml->get($player->getName());
	    	$player = $rankyml->get("RegularPlayerName")." ";
       		if($rank == "Owner"){
			$player->setNameTag(C::DARK_PURPLE."Owner".C::GRAY." | ".C::AQUA. $player->getName());
		}
		if($rank == "Co-Owner"){
			$player->setNameTag(C::GREEN."Co-Owner:".C::GRAY." | ".C::AQUA. $player->getName());
		}
		if($rank == "Admin"){
			$player->setNameTag(C::DARK_BLUE."Admin".C::GRAY." | ".C::AQUA. $player->getName());
		}
		if($rank == "Builder"){
			$player->setNameTag(C::YELLOW."Builder".C::GRAY." | ".C::AQUA. $player->getName());
		}
		if($rank == "VIP"){
			$player->setNameTag(C::GOLD."VIP".C::GRAY." | ".C::AQUA. $player->getName());
		}else{
			$player->setNameTag(C::YELLOW."$player".C::GRAY."| ".C::AQUA. $player->getName());
		}
	}
	public function onDisable(){
		$this->getLogger()->info(C::RED."Shutting down BoxCore!");
	}
}
