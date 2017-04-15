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
 
namespace TheDiamondYT\TitleManager\task;

use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

use TheDiamondYT\TitleManager\api\animation\Animation;
use TheDiamondYT\TitleManager\api\ActionBar;
use TheDiamondYT\TitleManager\Main;
 
class AnimateTask extends PluginTask {
    public $player;
    public $animation;
    
    public function __construct(Main $plugin, Player $player, Animation $animation) {
        parent::__construct($plugin);
        $this->player = $player;
        $this->animation = $animation;
    }
    
    public function onRun($tick) {
        $anim = $this->animation->animate();
        $this->getOwner()->sendActionMessage($this->player, new ActionBar($anim));
    }
}
