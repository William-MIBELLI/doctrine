<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'shop_avaibility')]
class ShopAvaibility
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\ManyToOne(targetEntity: Shop::class, inversedBy: 'availabilities')]
  private Shop $shop;

  use AvaibilityTrait;
}