<?php
namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\Collection;
use App\Repositories\ShopRepository;
use App\Entities\ShopAvaibility;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ORM\Table(name: 'shops')]
class Shop
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\OneToMany(targetEntity: ShopAvaibility::class, mappedBy: 'shop')]
  private Collection $availabilities;

  #[ORM\Column(type: 'datetime', name: 'created_at', options: ['default' => 'CURRENT_TIMESTAMP'])]
  private DateTime $createdAt;

  public function __construct(
    #[ORM\Column(type: 'string', name: 'place_name')]
    private string $placeName,

    #[ORM\Column(type: 'integer', unique: true, name: 'place_code')]
    private int $placeCode,

    #[ORM\Column(type: 'string')]
    private string $address,

    #[ORM\Column(type: 'integer', name: 'postal_code')]
    private int $postalCode,

    #[ORM\Column(type: 'string')]
    private string $city,

    #[ORM\Column(type: 'string')]
    private string $country,

    #[ORM\Column(type: 'string', nullable: true)]
    private string $phone,

    #[ORM\Column(type: 'string', unique: true, name: 'visit_code')]
    private string $visitCode,

    #[ORM\Column(type: 'string', name: 'visit_name')]
    private string $visitName,

    #[ORM\Column(type: 'datetime', nullable: true, name: 'start_date')]
    private DateTime|null $startDate,

    #[ORM\Column(type: 'datetime', nullable: true, name: 'end_date')]
    private DateTime|null $endDate,

    #[ORM\Column(type: 'string')]
    private string $type,

    #[ORM\Column(type: 'float')]
    private float $cost,

    #[ORM\Column(type: 'float')]
    private float $lat,

    #[ORM\Column(type: 'float')]
    private float $lng,

    #[ORM\Column(type: 'boolean', name: 'can_be_lunch_break', options: ['default' => false])]
    private bool $canBeLunchBreak = false,

    #[ORM\Column(type: 'boolean', name: 'can_be_morning', options: ['default' => false])]
    private bool $canBeMorning = false,

    #[ORM\Column(type: 'boolean', name: 'can_be_afternoon', options: ['default' => false])]
    private bool $canBeAfternoon = false,

  ) {
    $this->createdAt = new DateTime('now');
    $this->availabilities = new ArrayCollection();
  }

  public function getId(): ?int
  {
      return $this->id;
  }

  public function getAvailabilities(): Collection
  {
      return $this->availabilities;
  }

  public function getCreatedAt(): DateTime
  {
      return $this->createdAt;
  }

  public function getPlaceName(): string
  {
      return $this->placeName;
  }

  public function getPlaceCode(): int
  {
      return $this->placeCode;
  }

  public function getAddress(): string
  {
      return $this->address;
  }

  public function getPostalCode(): int
  {
      return $this->postalCode;
  }

  public function getCity(): string
  {
      return $this->city;
  }

  public function getCountry(): string
  {
      return $this->country;
  }

  public function getPhone(): string
  {
      return $this->phone;
  }

  public function getVisitCode(): string
  {
      return $this->visitCode;
  }

  public function getVisitName(): string
  {
      return $this->visitName;
  }

  public function getStartDate(): ?DateTime
  {
      return $this->startDate;
  }

  public function getEndDate(): ?DateTime
  {
      return $this->endDate;
  }

  public function getType(): string
  {
      return $this->type;
  }

  public function getCost(): float
  {
      return $this->cost;
  }

  public function getLat(): float
  {
      return $this->lat;
  }

  public function getLng(): float
  {
      return $this->lng;
  }

  public function getCanBeLunchBreak(): bool
  {
      return $this->canBeLunchBreak;
  }

  public function getCanBeMorning(): bool
  {
      return $this->canBeMorning;
  }

  public function getCanBeAfternoon(): bool
  {
      return $this->canBeAfternoon;
  }


}
