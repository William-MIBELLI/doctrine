<?php

namespace App\Routes;

use App\Controllers\CircuitController;
use Bramus\Router\Router as BRouter;
use App\Controllers\ShopController;
use App\Controllers\InvestigatorController;

class AppRouter
{
    private BRouter $router;
    private ShopController $shopController;
    private InvestigatorController $investigatorController;
    private CircuitController $circuitController;

    public function __construct(
        ShopController $shopController, 
        InvestigatorController $investigatorController,
        CircuitController $circuitController
    ) {
        $this->router = new BRouter();
        $this->shopController = $shopController;
        $this->investigatorController = $investigatorController;
        $this->circuitController = $circuitController;

        $this->router->set404(function () {
            http_response_code(404);
            echo "404, This route is not handled 😥";
        });
    }

    private function registerRoutes(): void
    {
        $this->router->get('/', function () {
            echo "Visit builder API";
        });

        $shopController = $this->shopController;
        
        $this->router->mount("/shops", function () use ($shopController) {
            $this->router->get('/', [$shopController, 'list']);
            $this->router->get('/{id}', [$shopController, 'show']);
            $this->router->post('/', [$shopController, 'create']);
            $this->router->delete('/{id}', [$shopController, 'delete']);
            $this->router->put('/{id}', [$shopController, 'update']);
        });

        $investigatorController = $this->investigatorController;
        
        $this->router->mount('/investigators', function () use ($investigatorController) {
            $this->router->get('/', [$investigatorController, 'list']);
            $this->router->get('/{id}', [$investigatorController, 'show']);
            $this->router->post('/', [$investigatorController, 'create']);
            $this->router->delete('/{id}', [$investigatorController, 'delete']);
            $this->router->put('/{id}', [$investigatorController, 'update']);
        });

        $circuitController = $this->circuitController;

        $this->router->mount('/circuit', function () use ($circuitController) {
            $this->router->get('/', [$circuitController, 'list']);
            $this->router->get('/{id}', [$circuitController, 'show']);
            $this->router->get('/byInvestigatorId/{id}', [$circuitController, 'showByInvestigator']);
            $this->router->get('/byShopId/{id}', [$circuitController, 'showByShop']);
            $this->router->post('/', [$circuitController, 'create']);
            $this->router->delete('/{id}', [$circuitController, 'delete']);
        });
    }

    public function run(): void
    {
        $this->registerRoutes();
        $this->router->run();
    }
}