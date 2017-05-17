<?php

namespace DesignPatterns;

/**
 * Interfejs
 */
interface IOffer
{
    public function getPrice();
}

/**
 * Klasa bazowa
 */
final class BaseOffer implements IOffer
{
    public function getPrice()
    {
        return 50;
    }
}

/**
 * Klasa dekoratora rozszerza np. cenę o zdefiniowaną wartość
 */
class EduDecorator implements IOffer
{
    private $offer;
    
    public function __construct(IOffer $offer)
    {
        $this->offer = $offer;
    }
    
    public function getPrice()
    {
        return $this->offer->getPrice() + 10;
    }

}

/**
 * Klasa dekoratora j.w.
 */
class SportDecorator implements IOffer
{
    private $offer;
    
    public function __construct(IOffer $offer)
    {
        $this->offer = $offer;
    }
    
    public function getPrice()
    {
        return $this->offer->getPrice() + 20;
    }        

}

/**
 * Klasa dekoratora j.w.
 */
class CinemaDecorator implements IOffer
{
    private $offer;
    
    public function __construct(IOffer $offer)
    {
        $this->offer = $offer;
    }
    
    public function getPrice()
    {
        return $this->offer->getPrice() + 30;
    }        

}

$baseOffer              = new BaseOffer();
$offerWithEdu           = new EduDecorator($baseOffer);
$offerWithEduAndSport   = new SportDecorator($offerWithEdu);
$fullOffer              = new CinemaDecorator(new SportDecorator(new EduDecorator($baseOffer)));

print_r($fullOffer->getPrice());
exit;


