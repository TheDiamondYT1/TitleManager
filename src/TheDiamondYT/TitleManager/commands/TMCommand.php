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
use pocketmine\command\PluginCommand;

use TheDiamondYT\TitleManager\TitleManager;
 
class TMCommand extends PluginCommand {

    public function __construct(TitleManager $plugin) {
        parent::__construct("titlemanager", $plugin);
        $this->setAliases(["tm"]);
        $this->setDescription("Main command for TitleManager.");
        $this->registerCommand(new CommandBroadcast($plugin));
    }
    
    private function registerCommand(TMSubCommand $command) {
        $this->subCommands[$command->getName()] = $command;
    }
    
    public function execute(CommandSender $sender, $label, array $args) {
        if(count($args) > 0) {
            $subcommand = array_shift($args);
            if(isset($this->subCommands[$subcommand])) {
                $command = $this->subCommands[$subcommand];
            }
            $command->execute($sender, $args);
        }
    }
}
