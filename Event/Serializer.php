<?php

namespace DesignPatterns\Event;

class Serializer
{

    public function save($obj)
    {
        file_put_contents('obj.txt', serialize($obj));
        var_dump(serialize($obj));

    }

    public function read()
    {
        $obj = file_get_contents('obj.txt');
        var_dump(unserialize($obj));

    }

}
