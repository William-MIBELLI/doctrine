<?php

namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'stops')]
class Stop
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\Column(type: 'integer', name: 'detour_sec')]
  private int $detourSec;

  #[ORM\Column(type: 'string')]
  private string $label;

  #[ORM\Column(
    type: 'datetime',
    name: 'start_time',
  )]
  private DateTime $startTime;

  #[ORM\Column(
    type: 'datetime',
    name: 'created_at',
    options: [
      'default' => 'CURRENT_TIMESTAMP'
    ]
  )]
  private DateTime $createdAt;

  #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'stops')]
  #[ORM\JoinColumn(nullable: false)]
  private Shop $shop;

  #[ORM\ManyToOne(targetEntity: Circuit::class, inversedBy: 'stops')]
  #[ORM\JoinColumn(nullable: false)]
  private Circuit $circuit;
  
  public function __construct()
  {
    $this->createdAt = new DateTime('now');
  }


	public function getId() : int|null {
		return $this->id;
	}

	public function getDetourSec() : int {
		return $this->detourSec;
	}

	public function setDetourSec(int $value) {
		$this->detourSec = $value;
	}

	public function getLabel() : string {
		return $this->label;
	}

	public function setLabel(string $value) {
		$this->label = $value;
	}

	public function getStartTime() : DateTime {
		return $this->startTime;
	}

	public function setStartTime(DateTime $value) {
		$this->startTime = $value;
	}

	public function getCreatedAt() : DateTime {
		return $this->createdAt;
	}

	public function getShop() : Shop {
		return $this->shop;
	}

	public function setShop(Shop $value) {
		$this->shop = $value;
	}

	public function getCircuit() : Circuit {
		return $this->circuit;
	}

	public function setCircuit(Circuit $value) {
		$this->circuit = $value;
	}
}