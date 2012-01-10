<?php

/**
 * Description of db
 *
 * @author Aivaras Voveris <aivaras@activesec.eu>
 * @since Aug 29, 2011
 */
class db
{   
    private static $__instance = null;
    
    public static function getInstance()
    {
        if (self::$__instance === null) {
            require_once BASIC_PATH . '/definitions.php';
            require_once CLASSES . 'database.php';
            self::$__instance = new Database();
            
        }
        return self::$__instance;
    }
}
