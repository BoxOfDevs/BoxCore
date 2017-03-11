<?php

namespace BoxOfDevs\BoxCore\Chat;

use BoxOfDevs\BoxCore\Chat\Classes;

use pocketmine\utils\TextFormat as C;

class Chat {
	
	protected $profanityChecker;
	protected $recentMessages = array();
	protected $enableMessageFrequency;
	protected $recentChat = array();
	
	public function __construct($enableMsgFrequency = true){
		$this->profanityChecker = new ChatClasser();
		$this->enableMessageFrequency = $enableMsgFrequency;
	}
	
	public function clearRecentChat(){
 		$this->recentChat = array();
 	}
	
	public function check($player, $message, $needCheck = true){
		$checkResult = $this->profanityChecker->check($message);
		$errorMessage = $this->getErrorMessage($message, $player);
		if(!empty($errorMessage)){
			$player->sendMessage($errorMessage);
			return false;
		}
		if($needCheck){
			if ($this->enableMessageFrequency){
				$this->recentChat[$player->getID()] = true;
			}
			$this->recentMessages[$player->getID()] = $message;
		}
		return true;
	}
	
	private function getErrorMessage($message, $player){
		$errorMsg = '';
		if(strlen($message) === 0){
			$errorMsg = C::RED.'Your message is too short.';
		}elseif(isset($this->recentChat[$player->getID()])){
 			$errorMsg = C::RED.'Slow down!';
 		}elseif($this->profanityChecker->getIsAdvertising()){
			$errorMsg = C::RED.'Advertising is not allowed.';
		}elseif($this->profanityChecker->getIsProfane()) {
			$errorMsg = C::RED.'That is an innappropriate message!';
		}elseif(isset($this->recentMessages[$player->getID()]) &&
				$this->recentMessages[$player->getID()] === $message){
			$errorMsg = C::RED.'That is a duplicate. Please do not repeat previous messages.';
		}elseif ($this->profanityChecker->getIsDating()) {
			$errorMsg = C::RED.'Dating is not allowed.';
		} 
		return $errorMsg;
	}
}