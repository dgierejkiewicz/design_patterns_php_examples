<?php

namespace DesignPatterns;

/**
 * Wzorzec Singleton
 * Wykorzystanie dla wzorca Rejestr
 * jako trait (cecha)
 */
trait Singleton
{

    protected static $_instance = null;

    final public static function getInstance()
    {
        if (is_null(self::$_instance)) {

            $reflection = new \ReflectionClass(__CLASS__);
            self::$_instance = $reflection->newInstance();
        }

        return self::$_instance;

    }
    
    protected function __clone()
    {
        
    }

}
