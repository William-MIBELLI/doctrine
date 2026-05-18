<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class ShopRepository extends EntityRepository
{
  public function getAllShops()
  {
    return parent::findAll();
  }

  public function getShopByCountry(string $country)
  {
    return parent::findBy(['country' => $country], ['id' => 'ASC']);
  }

  public function getShopById(string $id)
  {
    return parent::findOneBy(['id' => $id]);
  }

}