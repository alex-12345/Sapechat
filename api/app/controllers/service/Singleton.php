<?php 
declare(strict_types=1);
namespace app\controllers\service;

trait Singleton{
	private static $instance = null;

    private function __construct() {  }  
    private function __clone() { }  
    private function __wakeup() {  }  

    public static function getInstance():self {
		return (self::$instance===null) ? self::$instance = new static() : self::$instance;  
    }
	
	
}