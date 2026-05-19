<?php

namespace App\Entities;

use App\Entities\AbstractAvailability;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'investigator_availability')]
class InvestigatorAvailability extends AbstractAvailability
{
  #[ORM\ManyToOne(targetEntity: Investigator::class, inversedBy: 'availabilities')]
  private Investigator $investigator;

}