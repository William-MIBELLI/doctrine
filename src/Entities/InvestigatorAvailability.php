<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'investigator_availability')]
class InvestigatorAvailability
{
  #[ORM\Id]
  #[ORM\Column(type: 'integer')]
  #[ORM\GeneratedValue]
  private int|null $id = null;

  #[ORM\ManyToOne(targetEntity: Investigator::class, inversedBy: 'availabilities')]
  private Investigator $investigator;

  use AvaibilityTrait;
}