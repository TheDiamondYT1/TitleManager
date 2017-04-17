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
 
namespace TheDiamondYT\TitleManager\api;

use TheDiamondYT\TitleManager\api\animation\Animation;
 
class ActionBar {
    private $text;
    private $animation; // TODO: support for multiple animations
 
    /**
     * @param string $text
     */
    public function __construct(string $text = "") {
        $this->text = $text;
    }
     
    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }
    
    /**
     * @return Animation|null
     */
    public function getAnimation() {
        return $this->animation;
    }
    
    /**
     * @param Animation
     */
    public function addAnimation(Animation $animation) {
        $this->animation = $animation;
    }
}
