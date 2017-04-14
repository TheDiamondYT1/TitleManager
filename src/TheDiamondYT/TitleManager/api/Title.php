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
 
namespace TheDiamondYT\TitleManager\api;
 
class Title {
    private $text;
    private $fadeIn;
    private $stay;
    private $fadeOut;
    
    /**
     * @param string $text
     * @param int    $fadeIn
     * @param int    $stay
     * @param int    $fadeOut
     */
    public function __construct(string $text, int $fadeIn = -1, int $stay = -1, int $fadeOut = -1) {
        $this->text = $text;
        $this->fadeIn = $fadeIn;
        $this->stay = $stay;
        $this->fadeOut = $fadeOut;
    }
    
    /**
     * @return string 
     */
    public function getText(): string {
        return $this->text;
    }
    
    /**
     * @return int
     */
    public function getFadeInTime(): int {
        return $this->fadeIn;
    }
    
    /**
     * @return int
     */
    public function getStayTime(): int {
        return $this->stay;
    }
    
    /**
     * @return int
     */
    public function getFadeOutTime(): int {
        return $this->fadeOut;
    }
}
