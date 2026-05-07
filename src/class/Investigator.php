<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'investigators')]
class Investigator
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\Column(type: 'string', unique: true)]
  private string $code;

  #[ORM\Column(type: 'string')]
  private string $lastname;

  #[ORM\Column(type: 'string')]
  private string $firstname;

  #[ORM\Column(type: 'string')]
  private string $address;

  #[ORM\Column(type: 'integer', name: 'postal_code')]
  private int $postalCode;

  #[ORM\Column(type: 'string')]
  private string $city;

  #[ORM\Column(type: 'string')]
  private string $country;

  #[ORM\Column(type: 'string')]
  private string $phone;

  #[ORM\Column(type: 'float')]
  private float $lat;

  #[ORM\Column(type: 'float')]
  private float $lng;

  #[ORM\Column(type: 'datetime', name: 'created_at', options: ['default' => 'CURRENT_TIMESTAMP'])]
  private DateTime $createdAt;

  #[ORM\OneToMany(targetEntity: InvestigatorAvailability::class, mappedBy: 'investigator' )]
  private Collection $availabilities;

  public function __construct()
  {
    $this->createdAt = new DateTime('now');
    $this->availabilities = new ArrayCollection();
  }

}