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
 
namespace TheDiamondYT\TitleManager\commands;

use TheDiamondYT\TitleManager\Main;
 
abstract class TMSubCommand {
    private $plugin;
    
    private $name;
    
    public function __construct(Main $plugin, string $name, array $aliases = []) {
        $this->plugin = $plugin;
        $this->name = $name;
    }
     
    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
}
