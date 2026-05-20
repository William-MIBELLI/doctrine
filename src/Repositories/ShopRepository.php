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
    return $this->findAll();
  }

  /**
   * Summary of getShopByCountry
   * @param string $country
   * @return Shop[]
   */
  public function getShopByCountry(string $country): array
  {
    return $this->findBy(['country' => $country], ['id' => 'ASC']);
  }

  public function getShopById(string $id): Shop | null
  {
    return $this->findOneBy(['id' => $id]);
  }

}