<?php

namespace DesignPatterns;

/**
 * Klasa reprezentująca pojedynczy byt na liście
 */
class Service
{

    public $service_name;
    public $pricing;

    public function __construct($service_name, $pricing)
    {
        $this->service_name = $service_name;
        $this->pricing = $pricing;

    }

}

/**
 * Obiekt przechowująca jakąś listę
 */
class ServiceList
{

    private $_list = array();

    public function add(\DesignPatterns\Service $service)
    {
        array_push($this->_list, $service);

    }

    public function delete(\DesignPatterns\Service $service)
    {
        $key = array_search($service, $this->_list);
        if (!is_null($key)) {
            unset($this->_list[$key]);
        }

    }

    public function getList()
    {
        return $this->_list;

    }

}

/**
 * Implementacja interfejsu iteratora do przechodzenia po liście
 */
class ServiceIterator implements \Iterator
{

    private $_serviceList;
    private $_pointer = 0;

    public function __construct(\DesignPatterns\ServiceList $serviceList)
    {        
        $this->_serviceList = $serviceList->getList();        
        if (!$this->_serviceList && (!is_array($this->_serviceList))) {
            throw new Exception('Brak listy usług');
        }
        $this->_pointer = 0;

    }

    public function current()
    {        
        return $this->_serviceList[$this->_pointer];

    }

    public function next()
    {
        ++$this->_pointer;

    }

    public function rewind()
    {
        $this->_pointer = 0;

    }

    public function valid()
    {
        return isset($this->_serviceList[$this->_pointer]);

    }

    public function key()
    {
        return $this->_pointer;

    }

}

echo '<pre>';

$serviceList = new ServiceList();
$serviceList->add(new Service('int', 49));
$serviceList->add(new Service('tel', 19));
$serviceList->add(new Service('tv', 59));

$serviceIterator = new ServiceIterator($serviceList);


foreach($serviceIterator as $key => $service) {
    var_dump($key, $service);
    echo "\n";
}





