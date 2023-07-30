<?php

namespace Theslowaja\ChatRadius;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class Main extends PluginBase implements Listener {

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    /** Chat Radius Event */

    public function onChatRadius(PlayerChatEvent $event) {
        $player = $event->getPlayer();
        $recipients = $event->getRecipients();
		$config = $this->getConfig();
        if($config->get("mode") == "radius"){
            foreach ($recipients as $num => $recipient) {
                if ($recipient instanceof Player) {
                    if($player->getWorld() == $recipient->getWorld()){
                        if($player->getPosition()->distance($recipient->getPosition()->asVector3()) > $config->get("radius-chat")){
                            unset($recipients[$num]);
                        }
                    } else {
                        unset($recipients[$num]);
                    }
                }
            }
            $event->setRecipients($recipients);
        }
    }
}