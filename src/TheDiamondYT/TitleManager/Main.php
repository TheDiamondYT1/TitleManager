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
 
class Main extends PluginBase {

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new AnimateTask($this, null, new \TheDiamondYT\TitleManager\api\animation\FlashingAnimation(["Lmfao", "dude", "hey", "ha", "§cMINEPLEX", "§bMINEPLEX"], 20)), 20);
    }
 
    /**
     * Adds an action bar message to the specified players screen.
     *
     * @param Player    $player          
     * @param ActionBar $message
     * @param Animation $animation
     */
    public function sendActionMessage(Player $player, ActionBar $message, Animation $animation = null) {
        if($animation !== null) {
            $this->getServer()->getScheduler()->scheduleRepeatingTask(new AnimateTask($this, $player, $animation), $animation->getInterval());
            return;
        } 
        $player->addActionBarMessage($message->getText());
    }
    
    /**
     * Adds a title text to the specified players screen.
     *
     * @param Player $player
     * @param Title  $title
     */
    public function sendTitle(Player $player, Title $title) {
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
        $this->sendTitlePacket($player, $subtitle->getText(), SetTitlePacket::TYPE_SET_SUBTITLE);
    }
    
    /**
     * Adds a subtitle text to the specified players screen, without a title.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitleWithoutTitle(Player $player, SubTitle $subtitle) {
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
        $player->setTitleDuration($title->getFadeInTime(), $title->getStayTime(), $title->getFadeOutTime());
        $this->sendSubTitle($player, $subtitle);
        $this->sendTitlePacket($player, $title->getText(), SetTitlePacket::TYPE_SET_TITLE); // TODO: uneeded?
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
   
   /**
    * Internal method for sending the title packet.
    * Taken from the player class, because that method is inaccessible.
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
