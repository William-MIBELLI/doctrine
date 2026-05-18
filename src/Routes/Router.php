<?php

namespace App\Routes;

class Router{

  private array $routes = [];

  public function __construct(){}

  public function addRoute(string $method, string $path, $controllerInstance, string $action)
  {
    $this->routes[] = [
      'method' => $method,
      'path' => $path,
      'controller' => $controllerInstance,
      'action' => $action
    ];
  }

  public function dispatch(string $method, string $uri)
  {
    $parsedUrl = parse_url($uri);
    $path = $parsedUrl['path'] ?? '/';

    foreach ($this->routes as $route){
      
      if($route['method'] === $method && $route['path'] === $path){

        $controller = $route['controller'];
        $action = $route['action'];

        if(!class_exists($controller::class, true)){
          echo "Class {$controller} does not exist.";
          return;
        }

        if(!method_exists($controller::class, $action)){
          echo "Method {$action} does not exist within class {$controller}";
          return;
        }

        $controller->$action();
        return;
      }
    }
    http_response_code(404);
    echo "404. This URL is not handled.";
  }
}