<?php

namespace Xenophilicy\XenoBroadcaster;

use pocketmine\scheduler\Task;

class BroadcastTask extends Task{

	private $plugInstance;

	public function onRun(int $currentTick)
	{
		$this->plugInstance = XenoBroadcaster::getInstance();
		$exp = $this->plugInstance->exp;
		if($this->plugInstance->random)
		{
			foreach($this->plugInstance->getOnlinePlayers() as $hooman)
			{
				$exp = explode(":", $exp);
				$exp = mt_rand($exp[0], $exp[1]);
				if($hooman instanceof Player) $this->plugInstance->core->data->addVal($hooman, "exp", $exp);
			}
		} else {
			foreach($this->plugInstance->getOnlinePlayers() as $hooman)
			{
				if($hooman instanceof Player) $this->plugInstance->core->data->addVal($hooman, "exp", $exp);
			}
		}
		$this->plugInstance->broadcastMessage("§l§cS A K U R A ❯ §7All online players received {$exp} ! Stay online!");
	}
}

?>
