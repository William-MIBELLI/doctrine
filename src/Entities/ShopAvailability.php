<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use App\Repositories\ShopAvailabilityRepository;

#[ORM\Entity(repositoryClass: ShopAvailabilityRepository::class)]
#[ORM\Table(name: 'shop_availability')]
class ShopAvailability extends AbstractAvailability
{
  #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'availabilities')]
  private Shop $shop;

}