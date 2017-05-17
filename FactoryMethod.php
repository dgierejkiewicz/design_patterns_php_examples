<?php

namespace DesignPatterns;

/*
 * Wzorzec Factory method
 * 
 */

interface Product
{

    public function getName();

}

interface Creator
{

    static public function create($type);

}



class ConcreteProduct1 implements Product
{
    public function getName()
    {
        return 'product1';
    }
}

class ConcreteProduct2 implements Product
{
    public function getName()
    {
        return 'product2';
    }
}


/**
 * Factory method
 */
class ConcreteCreator implements Creator
{

    static public function create($type)
    {
                
        
        switch ($type) {
            case 'Produkt1':

                $object = new \DesignPatterns\ConcreteProduct1();

                break;

            case 'Produkt2':
                
                $object = new \DesignPatterns\ConcreteProduct2();
                
                break;
        }

        return $object;

    }

}

$produkt1 = \DesignPatterns\ConcreteCreator::create('Produkt1');
$produkt2 = \DesignPatterns\ConcreteCreator::create('Produkt2');

echo '<pre>';
print_r($produkt1->getName());
print_r($produkt2->getName());
