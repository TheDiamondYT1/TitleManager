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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use TheDiamondYT\TitleManager\api\Title;
use TheDiamondYT\TitleManager\api\SubTitle;
 
class EventListener implements Listener {
    private $plugin;
    
    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }
    
    /**
     * @priority HIGHEST
     */
    public function onPlayerJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $config = $this->plugin->getConfig();
        
        if($config->get("welcome-title.enabled", true) === true) {
            $title = new Title($config->get("welcome-title.text.title"), $config->get("welcome-title.duration.fadeIn",
                               $config->get("welcome-title.duration.stay"), $config->get("welcome-title.duration.stay")));                       
            $this->plugin->sendTitle($player, $title);
            
            if($subtitle = $config->get("welcome-title.text.subtitle") !== '') {
                $this->plugin->sendSubTitle($player, new SubTitle($subtitle));
            }
        }
    }
}
