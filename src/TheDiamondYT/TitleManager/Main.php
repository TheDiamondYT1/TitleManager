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
use pocketmine\network\mcpe\protocol\SetTitlePacket;

use TheDiamondYT\TitleManager\task\AnimateTask;
use TheDiamondYT\TitleManager\api\animation\Animation;
use TheDiamondYT\TitleManager\api\ActionBar;
use TheDiamondYT\TitleManager\api\Title;
use TheDiamondYT\TitleManager\api\SubTitle;
use TheDiamondYT\TitleManager\commands\TMCommand;
 
class Main extends PluginBase {
    private $useTip = false;

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("titlemanager", new TMCommand($this));
              
        $this->useTip = !method_exists(Player::class, "addActionBarMessage");
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
        $this->resetTitles($player);
        $player->setTitleDuration($title->getFadeInTime(), $title->getStayTime(), $title->getFadeOutTime());
        $this->sendTitlePacket($player, $title->getText(), SetTitlePacket::TYPE_SET_TITLE);
    } 
    
    /**
     * Adds a subtitle text to the specified players screen.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitle(Player $player, SubTitle $subtitle) {
        $this->resetTitles($player);
        $this->sendTitlePacket($player, $subtitle->getText(), SetTitlePacket::TYPE_SET_SUBTITLE);
    }
    
    /**
     * Adds a subtitle text to the specified players screen, without a title.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitleWithoutTitle(Player $player, SubTitle $subtitle) {
        $this->resetTitles($player);
        $player->setTitleDuration($subtitle->getFadeInTime(), $subtitle->getStayTime(), $subtitle->getFadeOutTime());
        $this->sendSubTitle($player, $subtitle);
        $this->sendTitlePacket($player, "", SetTitlePacket::TYPE_SET_TITLE);
    }
    
    /**
     * Adds a title and subtitle text to the specified players screen.
     *
     * @param Player   $player
     * @param Title    $title
     * @param SubTitle $subtitle
     */
    public function sendTitles(Player $player, Title $title, SubTitle $subtitle) {
        $this->resetTitles($player);
        $player->setTitleDuration($title->getFadeInTime(), $title->getStayTime(), $title->getFadeOutTime());
        $this->sendSubTitle($player, $subtitle);
        $this->sendTitlePacket($player, $title->getText(), SetTitlePacket::TYPE_SET_TITLE); 
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
        $player->removeTitles();
    }
    
    /*
     * Resets the title settings for the specified player.
     *
     * @param Player $player
     */
    public function resetTitles(Player $player) {
        $pk = new SetTitlePacket();
        $pk->type = SetTitlePacket::TYPE_RESET_TITLE;
        $player->dataPacket($pk);
    }
    
   /************** INTERNAL METHODS **************/
   
   /**
    * Internal method for sending the title packet.
    * 
    * @param Player $player
    * @param string $text
    * @param int    $type
    */
    private function sendTitlePacket(Player $player, string $text, int $type) {
        $pk = new SetTitlePacket();
        $pk->type = $type;
        $pk->text = $text;
        $player->dataPacket($pk);
    }
}
