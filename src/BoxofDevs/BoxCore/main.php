<?php

namespace BoxofDevs\BoxCore;

//Blocks
use pocketmine\block\Block;

//Command
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

//Entity
use pocketmine\entity\Entity;
use pocketmine\entity\Effect;

//Events
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\entity\EntityLevelChangeEvent; 
use pocketmine\event\plugin\PluginEvent;

//Inventory
use pocketmine\inventory\ChestInventory;

//Item
use pocketmine\item\Item;

//Lang

//Level
use pocketmine\level\Level;
use pocketmine\level\Position;

//Math
use pocketmine\math\Vector3;

//Metadata

//Nbt
use pocketmine\nbt\NBT;

//network
use pocketmine\network\Network;

//permission
use pocketmine\permission\Permission;

//Plugin
use pocketmine\plugin\PluginBase;

//resourcepacks

//resources

//scheduler
use pocketmine\scheduler\PluginTask;

//Tile
use pocketmine\tile\Sign;
use pocketmine\tile\Chest;

//Utils
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

//none of the above
use pocketmine\Player;
use pocketmine\Server;


class main extends PluginBase implements Listener {
	
	public $prefix = "";

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this ,$this);
		$config = $this->getConfig();
		$this->prefix = $config->get("Prefix")." ";
		$this->saveDefaultConfig();
		$this->homeData = new Config($this->getDataFolder()."/homes.yml", Config::YAML, array());
		$this->saveResource("/homes.yml");
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
		$rankyml = new Config($this->getDataFolder()."/rank.yml", Config::YAML);
		$rank = $rankyml->get($player->getName());
		$regular = $rankyml->get("RegularPlayerName");
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
			$player->setNameTag($regular.C::GRAY." | ".C::AQUA.$player->getName());
		}
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		$name = $sender->getName();
        switch(strtolower($command->getName())){
            case "home":
				if($sender instanceof Player){
					$home = $this->homeData->get($args[0]);
					if($home["world"] instanceof Level){
						$sender->setLevel($home["world"]);
						$sender->teleport(new Position($home["x"], $home["y"], $home["z"]));
						$sender->sendMessage(C::BLUE."You teleported to your home.");
					}else{
						$sender->sendMessage(C::RED."That world is not loaded or doesn't exist!");
					}
				}else{
					$sender->sendMessage(C::DARK_RED."Please run this command IN-GAME!");
				}
			return true;
            case "sethome":
				if($sender instanceof Player){
					$x = $sender->x;
					$y = $sender->y;
					$z = $sender->z;
					$level = $sender->getLevel();
					$this->homeData->set($args[0], array(
                       "x" => $x,
                       "y" => $y,
                       "z" => $z,
                       "world" => $level,
					));
                    $sender->sendMessage(C::GREEN."Your home is set at coordinates\n"."X:".C::YELLOW.$x.C::GREEN."\nY:".C::YELLOW.$y.C::GREEN."\nZ:".C::YELLOW.$z.C::GREEN."\nUse /home < ".$args[0]." > to teleport to this home!");
                    $this->getLogger()->info($name." has set their home in world: ".$sender->getLevel()->getName());
				}else{
					$sender->sendMessage(C::DARK_RED."Please run this command IN-GAME!");
				}
			return true;
            case "ishome":
				$home = $this->homeData->get($args[0]);
                if($home["world"] instanceof Level){
					$sender->sendMessage(C::BLUE."Yes, ".$args[0]."is a house. It's location is ".$home["x"]." ".$home["y"]." ".$home["z"]."In the world ".$home["world"]);
				}else{
					$sender->sendMessage(C::BLUE."No, -".$args[0]."- is not a house. Use the /sethome command to set a home with this name.");
				}
			return true;
			case "lobby":
				if($sender instanceof Playerr){
					$lobby = $this->getServer()->getDefaultLevel()->getSafeSpawn();
					$sender->teleport($lobby);
				}else{
					$sender->sendMessage(C::DARK_RED."Please run this command IN-GAME!");
				}
			return true;
		}
	}
	
	public function onDisable(){
		$this->saveResource("/homes.yml");
		$this->getLogger()->info(C::RED."Shutting down BoxCore!");
	}
}
