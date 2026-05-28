<?php
namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use DateTime;
use App\Repositories\InvestigatorRepository;

#[ORM\Entity(repositoryClass: InvestigatorRepository::class)]
#[ORM\Table(name: 'investigators')]
class Investigator
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'datetime', name: 'created_at', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTime $createdAt;

    #[ORM\OneToMany(
        targetEntity: InvestigatorAvailability::class,
        mappedBy: 'investigator',
        cascade: ['persist', 'remove']
    )]
    private Collection $availabilities;

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

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
        $this->availabilities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Summary of getAvailabilities
     * @return InvestigatorAvailability[]
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
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

    public function getLat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }


    public function setLng(float $value)
    {
        $this->lng = $value;
    }


    public function setLat(float $value)
    {
        $this->lat = $value;
    }


    public function setPhone(string $value)
    {
        $this->phone = $value;
    }


    public function setCountry(string $value)
    {
        $this->country = $value;
    }


    public function setCity(string $value)
    {
        $this->city = $value;
    }


    public function setPostalCode(int $value)
    {
        $this->postalCode = $value;
    }


    public function setAddress(string $value)
    {
        $this->address = $value;
    }


    public function setFirstname(string $value)
    {
        $this->firstname = $value;
    }


    public function setLastname(string $value)
    {
        $this->lastname = $value;
    }


    public function setCode(string $value)
    {
        $this->code = $value;
    }


    public function setAvailabilities(Collection $value)
    {
        $this->availabilities = $value;
    }
}