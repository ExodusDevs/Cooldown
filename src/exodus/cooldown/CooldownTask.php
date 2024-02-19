<?php

namespace exodus\cooldown;

use Closure;

use pocketmine\scheduler\Task;

class CooldownTask extends Task
{
  protected Cooldown $cooldown;
  
  public function __construct(Cooldown $cooldown)
  {
    $this->cooldown = $cooldown;
  }
  
  public function onRun(): void
  {
    $this->cooldown->onStarting();
    if ($this->cooldown->duration === 0) {
      $this->cooldown->onClose();
      $this->getHandler()->cancel();
    }
  }
  
}