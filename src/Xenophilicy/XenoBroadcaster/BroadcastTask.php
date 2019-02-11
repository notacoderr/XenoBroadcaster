<?php

namespace Xenophilicy\XenoBroadcaster;

use pocketmine\Server;
use pocketmine\scheduler\Task;

class BroadcastTask extends Task{


	public function onRun(int $currentTick)
	{
		Server::getInstance()->getPluginManager()->getPlugin("AutoExperience")->timeCheck();
		$this->plugInstance->broadcastMessage("§l§cS A K U R A ❯ §7All online players received {$exp} ! Stay online!");
	}
}

?>
