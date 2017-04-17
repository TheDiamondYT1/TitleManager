# TitleManager
An advanced title managing plugin for [PocketMine-MP](http://pmmp.io).

This plugin is based off the [TitleManager plugin](https://www.spigotmc.org/resources/titlemanager.1049/) by [@Puharesource](https://github.com/Puharesource)

[Tesseract Version](https://github.com/TheDiamondYT1/TitleManager/tree/tesseract)

### Features
* Welcome title
* Easy to use API

### TODO
* Animations API
* Placeholders
* Commands
* Tasks

### Stalk me
Stalk my social media, please.  

* [Twitter](https://twitter.com/TheDiamondYT)  
* [PocketMine Forums](https://forums.pmmp.io/members/thediamondyt.622/)  
* [Instagram](https://instagram.com/bruhitzzluke)  
* [Snapchat (lukedabs21)](http://snapchat.com/add/lukedabs21)   
* MCPE Username: TheDiamondYT7

For Developers
--------------

### Getting the plugin instance
I recommend putting this code in your `onEnable` method and storing it in a variable.

##### Example
```php
$this->titleManager = $this->getServer()->getPluginManager()->getPlugin("TitleManager");
```

Or you could use

```php
use TheDiamondYT\TitleManager\TitleManager;

TitleManager::getInstance();
```

#### TODO: finish this.



