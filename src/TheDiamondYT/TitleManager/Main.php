<?php
/*
 *  _______ _ _   _      __  __                                   
 * |__   __(_) | | |    |  \/  |                                  
 *    | |   _| |_| | ___| \  / | __ _ _ __   __ _  __ _  ___ _ __ 
 *    | |  | | __| |/ _ \ |\/| |/ _` | '_ \ / _` |/ _` |/ _ \ '__|
 *    | |  | | |_| |  __/ |  | | (_| | | | | (_| | (_| |  __/ |   
 *    |_|  |_|\__|_|\___|_|  |_|\__,_|_| |_|\__,_|\__, |\___|_|   
 *                                                __/ |                                                            |___/      
 *                                               |___/
 * TitleManager v1.0.0 by Luke (TheDiamondYT)
 * All rights reserved.
 */
 
namespace TheDiamondYT\TitleManager;
 
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use TheDiamondYT\TitleManager\task\AnimateTask;
use TheDiamondYT\TitleManager\api\animation\Animation;
use TheDiamondYT\TitleManager\api\ActionBar;
use TheDiamondYT\TitleManager\api\Title;
use TheDiamondYT\TitleManager\api\SubTitle;
 
class Main extends PluginBase {
    /* @feeling hatred */
    const TYPE_CLEAR_TITLE = 0;
    const TYPE_SET_TITLE = 2;
    const TYPE_SET_SUBTITLE = 3;
    const TYPE_SET_TIMES = 5;
    
    private $pmmp = true;
    private $useTip = false;
    
    private $setTitlePacket;

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        
        $this->pmmp = method_exists(Player::class, "removeTitles");
        $this->useTip = method_exists(Player::class, "addActionBarMessage");
        if(class_exists("\\pocketmine\\network\\mcpe\\protocol\\SetTitlePacket")) {
            $this->setTitlePacket = new \pocketmine\network\mcpe\protocol\SetTitlePacket();
        } else {
            $this->setTitlePacket = new \pocketmine\network\protocol\SetTitlePacket();
        }
    }
 
    /**
     * Adds an action bar message to the specified players screen.
     *
     * @param Player    $player          
     * @param ActionBar $message
     * @param Animation $animation
     */
    public function sendActionBarMessage(Player $player, ActionBar $message) {
        if($message->getAnimation() !== null) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new AnimateTask($this, $player, $message->getAnimation()), $message->getAnimation()->getInterval());
            return;
        } 
        if($this->useTip === true) {
            $player->sendTip($message->getText());
        } else {
            $player->addActionBarMessage($message->getText());
        }
    }
    
    /**
     * Adds a title text to the specified players screen.
     *
     * @param Player $player
     * @param Title  $title
     */
    public function sendTitle(Player $player, Title $title) {
        $this->sendTitleDuration($player, $title->getFadeInTime(), $title->getStayTime(), $title->getFadeOutTime());
        $this->sendTitlePacket($player, $title->getText(), self::TYPE_SET_TITLE);
    } 
    
    /**
     * Adds a subtitle text to the specified players screen.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitle(Player $player, SubTitle $subtitle) {
        $this->sendTitlePacket($player, $subtitle->getText(), self::TYPE_SET_SUBTITLE);
    }
    
    /**
     * Adds a subtitle text to the specified players screen, without a title.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitleWithoutTitle(Player $player, SubTitle $subtitle) {
        $this->sendTitleDuration($player, $subtitle->getFadeInTime(), $subtitle->getStayTime(), $subtitle->getFadeOutTime());
        $this->sendSubTitle($player, $subtitle);
        $this->sendTitlePacket($player, "", self::TYPE_SET_TITLE);
    }
    
    /**
     * Adds a title and subtitle text to the specified players screen.
     *
     * @param Player   $player
     * @param Title    $title
     * @param SubTitle $subtitle
     */
    public function sendTitles(Player $player, Title $title, SubTitle $subtitle) {
        $this->sendTitleDuration($player, $title->getFadeInTime(), $title->getStayTime(), $title->getFadeOutTime());
        $this->sendSubTitle($player, $subtitle);
        $this->sendTitlePacket($player, $title->getText(), self::TYPE_SET_TITLE); // TODO: uneeded?
    }
    
    /**
     * Removes the title text from the specified players screen.
     *
     * @param Player $player
     */
    public function clearTitle(Player $player) {
        $this->sendTitle($player, new Title(""));
    }
    
    /**
     * Removes the subtitle text from the specified players screen.
     *
     * @param Player $player
     */
    public function clearSubtitle(Player $player) {
        $this->sendSubtitle($player, new SubTitle(""));
    }
    
    /**
     * Removes the title and subtitle text from the specified players screen.
     *
     * @param Player $player
     */
    public function clearTitles(Player $player) {
        if($this->pmmp === true) {
            $player->removeTitles();
        } else {
            $pk = $this->setTitlePacket;
            $pk->type = self::TYPE_CLEAR_TITLE;
            $player->dataPacket($pk);
        }
    }
    
   /************** INTERNAL METHODS **************/
   
   /**
    * Internal method for sending the title packet.
    * Provided for Tesseract compatibility.
    * 
    * @param Player $player
    * @param string $text
    * @param int    $type
    */
    private function sendTitlePacket(Player $player, string $text, int $type) {
        $pk = $this->setTitlePacket;
        $pk->type = $type;
        $pk->text = $text;
        $player->dataPacket($pk);
    }
    
    /**
     * Internal method for sending the title duration packet.
     * Provided for Tesseract compatibility.
     *
     * @param Player $player
     * @param int    $fadeIn
     * @param int    $stay
     * @param int    $fadeOut
     */
    private function sendTitleDuration(Player $player, int $fadeIn, int $stay, int $fadeOut) {
        if($fadeIn >= 0 and $stay >= 0 and $fadeOut >= 0) {
            $pk = $this->setTitlePacket;
            $pk->type = self::TYPE_SET_TIMES;
            $pk->fadeInTime = $fadeIn;
            $pk->stayTime = $stay;
            $pk->fadeOutTime = $fadeOut;
            $player->dataPacket($pk);
        }
    }
}
