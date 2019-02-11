<?php

namespace Xenophilicy\XenoBroadcaster;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\config;

class XenoBroadcaster extends PluginBase implements Listener{

	public $random = false;
	public $exp;
	public $core;
	public $config;
	private $players = [];

    	public function onLoad()
    	{
		$this->getLogger()->info("§eLoading......");
    	}
	
	public function onEnable()
	{
		$this->saveDefaultConfig();
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$this->config->getAll();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->hasValidInterval();
		$this->core = Server::getInstance()->getPluginManager()->getPlugin("CoreX2");
	}
	
	public function onDisable()
	{
		$this->getLogger()->info("§6XenoBroadcaster§c has been disabled!");   
	}

	private function hasValidInterval() : bool
	{
		if(!is_integer($this->config->get("interval"))){
			$this->getLogger()->critical("Invalid interval in the config! Plugin Disabling...");
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return false;
		}
		elseif(is_integer($this->config->get("interval"))){
			$this->getLogger()->Info("§6AutoEXP§a has been enabled!");
			
			$this->getScheduler()->scheduleRepeatingTask(new BroadcastTask(), $this->config->get("interval") * 1200);
			if($this->config->getNested("experience.type") == "random")
			{
				$this->random = true;
				$this->exp = $this->config->getNested("experience.amount_random");
			} else {
				$this->exp = $this->config->getNested("experience.amount_fixed");
			}
			return true;
		}
		return false;
	}
	
	public function onLine(PlayerJoinEvent $event) : void
	{
		$player = $event->getPlayer()->getName();
		if(!in_array($player, $this->players))
		{
			$this->players[] =  $player ;
			var_dump($this->players[$name]);
		}
	}
	
	public function offLine(PlayerQuitEvent $event) : void
	{
		$player = $event->getPlayer()->getName();
		if(in_array($player, $this->players))
		{
			unset($this->players[$name]);
		}
	}
	
	public function timeCheck() : void
	{
		$time = $this->config->get("interval");
		foreach($this->players as $name)
		{
			$this->players[$name] += 1;
			var_dump($this->players[$name]);
			if($this->players[$name] >= $time)
			{
				$hooman = $this->getServer()->getPlayerExact($name);
				if($hooman instanceof Player) $this->core->data->addVal($hooman, "exp", $this->exp);
				//unset( $this->players[$name] );
				$this->players[] =  $name;
				var_dump($this->players[$name]);
			}
		}
	}
}
?>
