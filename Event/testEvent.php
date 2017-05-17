<?php

use DesignPatterns\Event\Event;
use DesignPatterns\Event\DataRecord;
//use DesignPatterns\Event\LogCallback;
use DesignPatterns\Event\Serializer;

require_once 'Event.php';
require_once 'DataRecord.php';
require_once 'LogCallback.php';
require_once 'Serializer.php';

echo '<pre>';
error_reporting(E_ALL | E_STRICT);
error_reporting(-1);

$obj = new stdClass();
$obj->property = '@testowany_obiekt!';

$serializer = new Serializer();
//$callbackSaveEvent = function () use ($serializer, $obj) {
//    $serializer->save($obj);
//};
//
//$callbackReadEvent = function () use ($serializer) {
//    $serializer->read();
//};

try {
    
    # save
    Event::registerCallback('save', $serializer->save($obj));

    # read
    Event::registerCallback('read', $serializer->read());
    
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}



$dataRecorder = new DataRecord();
$dataRecorder->save();
$dataRecorder->read();

