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
 
namespace TheDiamondYT\TitleManager\api\animation;
 
class FlashingAnimation extends Animation {
 
    /**
     * @param string $text
     * @param int    $interval
     */
    public function __construct(array $text, int $interval) {
        $this->text = $text;
        $this->interval = $interval;
    }
    
    private $i = 0;
    
    public function animate() { 
        $this->i++; 
        if($this->i >= count($this->text)) {
            $this->i = 0; 
        }
        return $this->text[$this->i];
    }
}
