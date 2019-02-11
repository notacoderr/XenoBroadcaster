<?php

namespace Xenophilicy\XenoBroadcaster;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\config;


class XenoBroadcaster extends PluginBase implements Listener{

	private $config;
	public $random = false;
	public $exp;
	public static $serverInstance;

    	public function onLoad()
    	{
		$this->saveDefaultConfig();
		$this->config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$this->config->getAll();
		$this->getLogger()->info("§eLoading......");
    	}
	
	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		self::$serverInstance = $this;
		$this->hasValidInterval();
	}
	
	public function onDisable()
	{
		$this->getLogger()->info("§6XenoBroadcaster§c has been disabled!");   
	}

	private function hasValidInterval() : bool
	{
		if(!is_integer($this->config->get("Interval"))){
			$this->getLogger()->critical("Invalid interval in the config! Plugin Disabling...");
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return false;
		}
		elseif(is_integer($this->config->get("Interval"))){
			$this->getLogger()->Info("§6AutoEXP§a has been enabled!");
			$this->getScheduler()->scheduleRepeatingTask(new BroadcastTask(), $this->config->get("Interval") * 1200);
			if($this->config->getNested("Experience.type") == "random")
			{
				$this->random = true;
				$this->exp = $this->config->getNested("Experience.amount_random");
			} else {
				$this->exp = $this->config->getNested("Experience.amount_fixed");
			}
			return true;
		}
		return true;
	}

	public static function getInstance(){
		return self::$serverInstance;
	}
}
?>
