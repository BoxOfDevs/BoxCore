<?php

namespace BoxofDevs\BoxCore;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\scheduler\PluginTask;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\Color;
use pocketmine\utils\TextFormat as C;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class main extends PluginBase implements Listener {
	
	public $prefix = "";
	
	public function onLoad(){
		$this->getLogger()->info(C::YELLOW."Box is opening..");
	}
	
	public function onEnable(){
		$this->getLogger()->info(C::GREEN."Box opened!");
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$config = $this->getConfig();
		$this->prefix = $config->get("Prefix")." ";
		$this->saveDefaultConfig();
	}
	
	public function onJoin(PlayerJoinEvent $event){
		$event->setJoinMessage("");
		$player = $event->getPlayer();
        $this->setRank($player);
	}
	
	public function onQuit(PlayerQuitEvent $event){
		$event->setQuitMessage("");
		$player = $event->getPlayer();
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
			$player->setNameTag(C::DARK_BLUE."Admin".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "Builder"){
			$player->setNameTag(C::YELLOW."Builder".C::GRAY." | ".C::AQUA.$name);
		}
		if($rank == "VIP"){
			$player->setNameTag(C::GOLD."VIP".C::GRAY." | ".C::AQUA.$name);
		}else{
			$player->setNameTag(C::YELLOW."Player".C::GRAY." | ".C::AQUA.$name);
		}
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		$name = $sender->getName();
		if($cmd->getName() == "Lobby"){
			if($sender instanceof Player){
				$sender->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
			}else{
				$sender->sendMessage(C::RED:"You can't use this CMD in Console!");
			}
		}
		switch($cmd->getName()){
			case "BOD":
			$sender->sendMessage(C::GOLD."Visit BoxOfDevs on Github: ".C::GRAY."https://github.com/BoxOfDevs");
		}
	}
	
	public function onDisable(){
		$this->getLogger()->info(C::RED."Closing Box!");
	}
}