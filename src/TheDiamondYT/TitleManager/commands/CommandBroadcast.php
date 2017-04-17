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
 * TitleManager v1.0.1 by Luke (TheDiamondYT)
 * All rights reserved.
 */
 
namespace TheDiamondYT\TitleManager\commands;

use pocketmine\command\CommandSender;

use TheDiamondYT\TitleManager\TitleManager;
 
class CommandBroadcast extends TMSubCommand {
    
    public function __construct(TitleManager $plugin) {
        parent::__construct($plugin, "broadcast", ["bc"]);
    }
    
    public function execute(CommandSender $sender, array $args) {
    
    }
}
