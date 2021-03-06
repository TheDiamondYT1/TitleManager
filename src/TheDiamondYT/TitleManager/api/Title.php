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
     * @param string $text
     */
    public function setText(string $text) {
        $this->text = $text;
    }
    
    /**
     * @return int
     */
    public function getFadeIn(): int {
        return $this->fadeIn;
    }
    
    /**
     * @return int
     */
    public function getStay(): int {
        return $this->stay;
    }
    
    /**
     * @return int
     */
    public function getFadeOut(): int {
        return $this->fadeOut;
    }
}
