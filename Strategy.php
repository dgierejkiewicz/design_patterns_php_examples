<?php

interface AbstractStrategy
{

    public function task();

}

class ConcreteStrategy1 implements AbstractStrategy
{
    public function task()
    {
        echo __CLASS__;
    }
}

class ConcreteStrategy2 implements AbstractStrategy
{
    public function task()
    {
        echo __CLASS__;
    }
}

class Context
{
    private $strategy;
    
    public function setStrategy(AbstractStrategy $strategy)
    {
        $this->strategy = $strategy;
    }
    
    public function getStrategy()
    {
        return $this->strategy;
    }

}

$context = new Context();
$context->setStrategy(new ConcreteStrategy1());
$context->getStrategy()->task();
echo PHP_EOL;
$context->setStrategy(new ConcreteStrategy2());
$context->getStrategy()->task();
echo PHP_EOL;