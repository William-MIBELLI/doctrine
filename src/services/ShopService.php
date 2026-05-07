<?php

class ShopService
{
  private ShopRepository $shopRepository;

  public function __construct(ShopRepository $repo)
  {
    $this->shopRepository = $repo;
  }

  public function getAllShops()
  {
    return $this->getAllShops();
  }
}