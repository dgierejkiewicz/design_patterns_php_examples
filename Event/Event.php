<?php

namespace DesignPatterns\Event;

class Event
{

    static protected $callbacks = array();

    /**
     * Rejestracja funkcji
     * @param string $eventName
     * @param callable $callback
     * @throws Exception
     */
    static public function registerCallback($eventName, callable $callback)
    {        
                
        if(!is_callable($callback)) {
            throw new Exception('Nieprawidlowa funkcja zwrotna');
        }
        
        $eventName = strtolower($eventName);
        
        # rejestracja funkcji dla zdarzenia $eventName
        self::$callbacks[$eventName][] = $callback;
        
    }        
    
    /**
     * Wyzwolenie zdarzenia i podpiętych metod bądź funkcji z danymi
     * @param string $eventName
     * @param mixed $data
     */
    static public function trigger($eventName, $data)
    {
        $eventName = strtolower($eventName);
        
        # odpalenie podpiętych funkcji
        if(isset(self::$callbacks[$eventName])) {
            foreach (self::$callbacks[$eventName]as $callback) {                                
                
                call_user_func($callback, $data);
                
            }
        }
        
    }

}
