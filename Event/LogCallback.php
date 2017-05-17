<?php

namespace DesignPatterns\Event;

class LogCallback
{
    public function __invoke($data)
    {
        echo 'Zarejestrowane dane' . PHP_EOL;
        var_dump($data);
    }
}
