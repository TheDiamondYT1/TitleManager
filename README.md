# TitleManager
An advanced title managing plugin for [PocketMine-MP](http://pmmp.io).

This plugin is based off the [TitleManager plugin](https://www.spigotmc.org/resources/titlemanager.1049/) by [@Puharesource](https://github.com/Puharesource)

### Features
* Welcome title
* Easy to use API

### TODO
* Animations API
* Placeholders
* Commands
* Tasks

For Developers
--------------

### Getting the plugin instance
I recommend putting this code in your `onEnable` method and storing it in a variable.

##### Example
```php
public function onEnable() {
    $this->titleManager = $this->getServer()->getPluginManager()->getPlugin("TitleManager");
}
```

#### TODO: finish this.



