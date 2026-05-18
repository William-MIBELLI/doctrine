<?php

namespace App\Repositories;

use App\Entities\Shop;
use Doctrine\ORM\EntityRepository;

class ShopRepository extends EntityRepository
{
  /**
   * @return Shop[]
   */
  public function getAllShops(): array
  {
    return parent::findAll();
  }

  /**
   * Summary of getShopByCountry
   * @param string $country
   * @return Shop[]
   */
  public function getShopByCountry(string $country): array
  {
    return parent::findBy(['country' => $country], ['id' => 'ASC']);
  }

  public function getShopById(string $id): Shop | null
  {
    return parent::findOneBy(['id' => $id]);
  }

}