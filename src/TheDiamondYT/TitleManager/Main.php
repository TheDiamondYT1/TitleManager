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

use TheDiamondYT\TitleManager\api\ActionBar;
use TheDiamondYT\TitleManager\api\Title;
use TheDiamondYT\TitleManager\api\SubTitle;
 
class Main extends PluginBase {

    public function onEnable() {
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
 
    /**
     * Adds an action bar message to the specified players screen.
     *
     * @param Player    $player          
     * @param ActionBar $message
     */
    public function sendActionMessage(Player $player, ActionBar $message) {
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
        $this->sendTitleText($player, $title->getText(), SetTitlePacket::TYPE_SET_TITLE);
    } 
    
    /**
     * Adds a subtitle text to the specified players screen.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitle(Player $player, SubTitle $subtitle) {
        $this->sendTitleText($player, $subtitle->getText(), SetTitlePacket::TYPE_SET_SUBTITLE);
    }
    
    /**
     * Adds a subtitle text to the specified players screen, without a title.
     *
     * @param Player   $player
     * @param SubTitle $subtitle
     */
    public function sendSubTitleWithoutTitle(Player $player, SubTitle $subtitle) {
        $this->sendTitle($player, new Title("", $subtitle->getFadeInTime(), $subtitle->getStayTime(), $subtitle->getFadeOutTime()));
        $this->sendSubTitle($player, $subtitle);
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
   
    private function sendTitleText(Player $player, string $text, int $type) {
        $pk = new SetTitlePacket();
        $pk->type = $type;
        $pk->text = $text;
        $player->dataPacket($pk);
    }
}
