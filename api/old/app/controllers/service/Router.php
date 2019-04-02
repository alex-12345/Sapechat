<?php
namespace controllers\service;

class Router {
    
    public static $routes = [];
    private static $route = [];
    
    public static function add($regexp, $route =[]){
        self::$routes[$regexp] = $route;
    }
    public static function getRoutes(){
        return self::$routes;
    }
    public static function getRoute() {
        return self::$route;
    }
    public static function matchRoute($url){
        foreach (self::$routes as $pattern => $route) {
            if(preg_match("#$pattern#i", $url, $matches)){
                foreach ($matches as $key => $value) {
                    if(is_string($key)){
                        $route[$key] = $value;
                    }
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }
    public static function dispatch($url){
        if(self::matchRoute($url)){
            $controller = 'controllers\\'.ucfirst((self::$route['controller']));
            if(!class_exists($controller)){
				systemError(8, "Ошибка, такого контроллера не существует!");
                exit();
            }
            if(isset(self::$route['action'])) {
                $action = self::$route['action'];
            }
            else {
				systemError(7, "Ошибка такого обработчика не существует!");
                exit(); 
            }  
            if(!method_exists($controller, $action)){
				systemError(7, "Ошибка такого обработчика не существует!");
                exit(); 
            }
			(new $controller())->$action();
            
        }else{
            http_response_code(404);
			systemError(404, "Ошибка такого контролера не существует!");
            exit();
        }
    }
}