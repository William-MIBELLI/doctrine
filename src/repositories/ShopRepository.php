<?php

use Doctrine\ORM\EntityRepository;

class ShopRepository extends EntityRepository
{
  public function getAllShop()
  {
    return parent::findAll();
  }

  public function getShopByCountry(string $country)
  {
    return parent::findBy(['country' => $country], ['id' => 'ASC']);
  }
}