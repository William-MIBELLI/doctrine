<?php

namespace App\Entities;

use App\Repositories\CircuitRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CircuitRepository::class)]
#[ORM\Table(name: 'circuits')]
class Circuit
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\Column(type: 'string')]
  private string $label;

  #[ORM\Column(type: 'text')]
  private string $polyline;

  #[ORM\Column(
    type: 'datetime',
    name: 'created_at',
    options: [
      'default' => 'CURRENT_TIMESTAMP'
    ]
  )]
  private DateTime $createdAt;

  #[ORM\Column(type: 'datetime', name: 'start_time')]
  private DateTime $startTime;

  #[ORM\Column(type: 'datetime', name: 'end_time')]
  private DateTime $endTime;

  #[ORM\Column(type: 'integer', name: 'travel_duration_sec')]
  private int $travelDurationSec;

  #[ORM\Column(type: 'integer', name: 'visit_duration_sec')]
  private int $visitDurationSec;

  #[ORM\Column(type: 'integer', name: 'total_duration_sec')]
  private int $totalDurationSec;

  #[ORM\Column(type: 'integer', name: 'travel_distance_meters')]
  private int $travelDistanceMeters;

  #[ORM\ManyToOne(targetEntity: Investigator::class, inversedBy: 'circuits')]
  #[ORM\JoinColumn(nullable: false)]
  private Investigator $investigator;

  #[ORM\OneToMany(
    targetEntity: Stop::class,
    mappedBy: 'circuit',
    cascade: ['persist', 'remove'],
    orphanRemoval: true
  )]
  private Collection $stops;

  public function __construct()
  {
    $this->createdAt = new DateTime('now');
    $this->stops = new ArrayCollection();
  }


  public function getId(): int|null
  {
    return $this->id;
  }

  public function getLabel(): string
  {
    return $this->label;
  }

  public function setLabel(string $value)
  {
    $this->label = $value;
  }

  public function getPolyline(): string
  {
    return $this->polyline;
  }

  public function setPolyline(string $value)
  {
    $this->polyline = $value;
  }

  public function getCreatedAt(): DateTime
  {
    return $this->createdAt;
  }

  public function getStartTime(): DateTime
  {
    return $this->startTime;
  }

  public function setStartTime(DateTime $value)
  {
    $this->startTime = $value;
  }

  public function getEndTime(): DateTime
  {
    return $this->endTime;
  }

  public function setEndTime(DateTime $value)
  {
    $this->endTime = $value;
  }

  public function getTravelDurationSec(): int
  {
    return $this->travelDurationSec;
  }

  public function setTravelDurationSec(int $value)
  {
    $this->travelDurationSec = $value;
  }

  public function getVisitDurationSec(): int
  {
    return $this->visitDurationSec;
  }

  public function setVisitDurationSec(int $value)
  {
    $this->visitDurationSec = $value;
  }

  public function getTotalDurationSec(): int
  {
    return $this->totalDurationSec;
  }

  public function setTotalDurationSec(int $value)
  {
    $this->totalDurationSec = $value;
  }

  public function getTravelDistanceMeters(): int
  {
    return $this->travelDistanceMeters;
  }

  public function setTravelDistanceMeters(int $value)
  {
    $this->travelDistanceMeters = $value;
  }


  public function getInvestigator(): Investigator
  {
    return $this->investigator;
  }

  public function setInvestigator(Investigator $value)
  {
    $this->investigator = $value;
  }

  public function getStops(): Collection
  {
    return $this->stops;
  }

  public function addStop(Stop $stop)
  {
    $this->stops->add($stop);
    $stop->setCircuit($this);
  }
}