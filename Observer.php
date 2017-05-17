<?php

namespace DesignPatterns;

/*
 * Wzorzec Observer (Obserwator)
 * Krótki opis
 * Pod obiekt klasy, która zmienia swój stan podpinamy obiekty obserwujące zmiany
 * Jeśli obiekt obserwowany zmienia swój stan, odpalamy metodę notify (SplSubject)
 * która odpala na każdym obserwującym obiekcie metodę update (SplObserver)
 * w ten sposób następuje propagacja informacji o zmianie
 * bez konieczności wiązania ścisłego między klasami obiektów
 * 
 * (Możliwy do wykorzystania jako wzorzec do event driven application)
 * 
 */

// Klasa obiektu obserwowanego
class Subject implements \SplSubject
{

    private $_subjectName;
    private $_observers = array();

    public function __construct($name)
    {        
        $this->_subjectName = $name;

    }
    
    /**
     * Dodaje obiekt obserwatora
     * @param \SplObserver $observer
     */
    public function attach(\SplObserver $observer)
    {
        $this->_observers[] = $observer;

    }

    /**
     * Usuwa obiekt z listy obserwatorów
     * @param \SplObserver $observer
     */
    public function detach(\SplObserver $observer)
    {
        $key = array_search($observer, $this->_observers, true);

        if (false !== $key) {

            unset($this->_observers[$key]);
        }

    }
    
    /**
     * Odpalenie update'u na wszystkich zaejestrowanych obserwatorach
     * każdy obserwator musi mieć zaimplementowaną metodę update 
     * (wymusza to interfejs SplObserver)
     */
    public function notify()
    {
        
        foreach ($this->_observers as $observer) {
            
            $observer->update($this);
            
        }

    }

}


// Klasa Obserwatora 
class Observer implements \SplObserver
{

    private $_observerName;

    public function __construct($name)
    {
        $this->_observerName = $name;

    }

    public function update(\SplSubject $subject)
    {
        return $subject;
    }

}


/****************************************/

/*
 * Przedmiot obserwacji
 */
class RejestrUslug implements \SplSubject
{
    private $uslugi = array();
    
    private $_subjectName;
    private $_observers = array();

    public function __construct($name)
    {        
        $this->_subjectName = $name;

    }

    /**
     * Dodaje obiekt obserwatora
     * @param \SplObserver $observer
     */    
    public function attach(\SplObserver $observer)
    {
        $this->_observers[] = $observer;

    }

    /**
     * Usuwa obiekt z listy obserwatorów
     * @param \SplObserver $observer
     */
    public function detach(\SplObserver $observer)
    {
        
        $key = array_search($observer, $this->_observers, true);

        if (false !== $key) {

            unset($this->_observers[$key]);
        }

    }
    
    /**
     * Odpalenie update'u na wszystkich zaejestrowanych obserwatorach
     * każdy obserwator musi mieć zaimplementowaną metodę update 
     * (wymusza to interfejs SplObserver)
     */
    public function notify()
    {
        
        foreach ($this->_observers as $observer) {
            
            $observer->update($this);
            
        }

    }
    
    public function dodajUsluge($nazwaUslugi)
    {
        $this->uslugi[] = $nazwaUslugi;
        $this->notify();
    }
    
    public function dajNowaUsluge()
    {
        return end($this->uslugi);
    }

}

/*
 * Obserwuje zmiany w klasie Usługa
 */
class CacheObserwator implements \SplObserver
{
    public function update(\SplSubject $usluga)
    {
        echo PHP_EOL . "[Cache]:Pojawiła się nowa usługa: {$usluga->dajNowaUsluge()} - zmieniam cache usług";
        // np. logowanie zmiany stanu obiektu obserwowanego 
        // (a także, że obiekt Cache otrzymał wiadomość) oraz 
        // zmiana całego cache'u
    }
}

/**
 * Klasa obserwuje zmiany w rejestrze usług
 * i ew. aktualizuje kanał RSS
 */
class RssObserwator implements \SplObserver
{
    public function update(\SplSubject $usluga)
    {
        echo PHP_EOL . "[RSS]:Pojawiła się nowa usługa: {$usluga->dajNowaUsluge()} - zmieniam wiadomość RSS dotyczącą usług";
        // 
        // np. logowanie zmiany stanu obiektu obserwowanego 
        // (a także, że obiekt Rss otrzymał wiadomość)
        // oraz zmiana danych Rss-u
    }
}

echo '<pre>';
echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >';


$uslugi = new RejestrUslug('Uslugi');


$uslugi->attach(new CacheObserwator('Cache'));
$uslugi->attach(new RssObserwator('Rss'));

//print_r($uslugi);
//exit;

$uslugi->dodajUsluge('Internet Za Darmo');

