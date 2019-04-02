<?php
declare(strict_types=1);
namespace controllers\service;

class Router {
    
    public static $routes = [];
    private static $route = [];
    
    public static function add(string $regexp, array $route = []):bool{
        self::$routes[$regexp] = $route;
        return true;
    }
    public static function getRoutes():array{
        return self::$routes;
    }
    public static function getRoute():string {
        return self::$route;
    }
    public static function matchRoute(string $url):bool{
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
    public static function dispatch(string $url):bool{
        if(self::matchRoute($url)){
            $controller = 'controllers\\'.ucfirst((self::$route['controller']));
            if(!class_exists($controller)) {
                return false;
            }
            $contr = (new $controller());
            if(isset(self::$route['id'])){
			    if(!$contr->init(self::$route['id'])){
                    return false;
                }
             
            }else{
                if(!$contr->init()){
                    return false;
                }
            }
            $contr->render();
            return true;
        }
        return false;
        
    }
}