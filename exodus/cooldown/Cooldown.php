<?php

namespace exodus\cooldown;

use Closure;

class Cooldown
{
  private CooldownManager $manager;
  
  protected string $name;
  
  protected int $duration;
  
  protected Closure $inCooldown;
  
  protected Closure $noCooldown;
  
  public function __construct(CooldownManager $manager, string $name, int $duration, Closure $inCooldown, ?Closure $noCooldown)
  {
    $this->manager = $manager;
    $this->name = $name;
    $this->duration = $duration;
    $this->inCooldown = $inCooldown;
    if ($noCooldown !== null) {
      $this->noCooldown = $noCooldown;
    }
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getDuration(): int
  {
    return $this->duration;
  }
  
  public function onStarting(): void
  {
    $this->duration--;
    ($this->inCooldown)($this->duration);
  }
  
  public function onClose(): void
  {
    if ($this->noCooldown !== null) {
      ($this->noCooldown);
    }
    $this->manager->delete($this->name);
  }
  
}