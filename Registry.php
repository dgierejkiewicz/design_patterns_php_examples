<?php
/*
 * Singleton
 * Rejestr
 * Obserwator
 * Iterator
 * Strategia--
 * Fasada--
 * Adapter--
 * Metoda fabrykująca--
 * Fabryka obiektów--
 * Budowniczy--
 * 
 */

namespace DesignPatterns;

include_once 'Singleton.php';

use DesignPatterns\Singleton as Singleton;

/*
 * Interfejs rejestru
 */

interface Registrable
{

    public function getElement($key);

    public function addElement($key, $value);

    public function overrideElement($key, $value);

    public function deleteElement($key);

}

/*
 * Klasa rejestru 
 * Wykorzystywany w połączeniu z singleton jako statyczny kontener danych
 * np. do przechowywania konfiguracji aplikacji
 */

class Registry implements Registrable
{

    use Singleton;

    private $_registry = array();

    /*
     * Pobiera element
     */

    public function getElement($key)
    {
        return array_key_exists($key, $this->_registry) ? $this->_registry[$key] : null;

    }

    /*
     * Dodaje element
     * Nie pozwoli na nadpisanie elementu o tym samym kluczu
     */

    public function addElement($key, $value)
    {

        array_key_exists($key, $this->_registry) ? : $this->_registry[$key] = $value;

    }

    /*
     * Nadpisanie elementu
     */

    public function overrideElement($key, $value)
    {
        if (array_key_exists($key, $this->_registry)) {

            $this->_registry[$key] = $value;
        }

    }

    /*
     * Usuwanie elementu
     */

    public function deleteElement($key)
    {
        if (array_key_exists($key, $this->_registry)) {

            unset($this->_registry[$key]);
        }

    }

}

echo '<pre>';
$registry = Registry::getInstance();
//var_dump(get_class_methods($registry));
print $registry->getElement('pi');
$registry->addElement('pi', 3.14);
var_dump($registry);
print PHP_EOL . $registry->getElement('pi') . PHP_EOL;

//$registry->deleteElement('pi');
//var_dump($registry);

$registry->overrideElement('pi', 3.1415);
var_dump($registry);
exit;
