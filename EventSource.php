<?php

namespace DesignPatterns;

class EventSource
{
    /*
     * Lista zarejestrowanych funkcji zwrotnych
     */
    protected $_callbacks = array();

    /**
     * Rejestracja funkcji zwrotnej
     * @param type $event
     * @param type $callback
     */
    public function registerEventCallback($event, $callback)
    {
        $this->_callbacks[$event][] = is_callable($callback) ? $callback : null;

    }

    /**
     * Uruchomienie funkcji przy okazji wystąpienia zdarzenia
     * @param type $event
     */
    public function fireEvent($event)
    {
//        print_r(isset(array_key_exists($event, $this->_callbacks)));
//        exit;
        if (array_key_exists($event, $this->_callbacks)) {
            foreach ($this->_callbacks[$event] as $callback) {

                call_user_func($callback);
            }
        }

    }

}

$source = new \DesignPatterns\EventSource();

$callback = function() {
    echo 'Callback event:test2';
};

$source->registerEventCallback('test', function(){
    echo 'Callback event:test';
});

$source->registerEventCallback('test2', $callback);
//print_r($source);exit;

$source->fireEvent('test');
$source->fireEvent('test2');
