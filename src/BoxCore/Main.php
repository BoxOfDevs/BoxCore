<?php

namespace BoxCore;

use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\utils\Color;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\tile\Tile;
use pocketmine\item\Item;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

class Main extends PluginBase implements Listener {

public function onEnable(){
       $this->getLogger()->info(C::GREEN ."Starting BoxCore");
  }       
 
 public function onJoin(){
 $this->setRank;
 }
 
  public function setRank($player){
       $rankyml = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
       $rank = $rankyml->get($player->getName());  
       if($rank == "Owner"){
       $player->setNameTag(C::GRAY ."[". C::DARK_PURPLE ."Owner". C::GRAY ."] ". C::AQUA . $player->getName());
  }
  if($rank == "Co-Owner"){
       $player->setNameTag(C::GRAY ."[". C::GREEN ."Co-Owner". C::GRAY ."] ". C::AQUA . $player->getName());
  }  
  if($rank == "Admin"){
       $player->setNameTag(C::GRAY ."[". C::DARK_BLUE ."Administrator". C::GRAY ."] ". C::AQUA . $player->getName());
  }
  if($rank == "Builder"){
       $player->setNameTag(C::GRAY ."[". C::YELLOW ."Builder". C::GRAY ."] ". C::AQUA . $player->getName());
  }
  if($rank == "VIP"){
       $player->setNameTag(C::GRAY ."[". C::GOLD ."VIP". C::GRAY ."] ". C::AQUA . $player->getName());
  }
  else{
       $player->setNameTag(C::GRAY ."[". C::YELLOW ."Player". C::GRAY ."] ". C::AQUA . $player->getName());
   }
  }
  
  public function onDisable(){
       $this->getLogger()->info(C::RED ."Shutting down BoxCore");
  }
}
