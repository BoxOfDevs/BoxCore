<?php

namespace BoxOfDevs\BoxCore\Chat;

use pocketmine\utils\TextFormat as C;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\Utils;
use pocketmine\Player;

class ChatTask extends PluginTask {
	
    public function __construct($owner){
        $this->owner = $owner;
    }
	
    public function onRun($currentTick){
        $this->filter = new \ChatTask\Chat();
        $this->filter->clearRecentChat();
    }
}