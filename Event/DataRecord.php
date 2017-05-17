<?php

namespace DesignPatterns\Event;

use DesignPatterns\Event\Event;

class DataRecord
{
    public function save()
    {
        # Wyzwól zdarzenie 'save'
        Event::trigger('save', array('save'));
    }
    
    public function read()
    {
        # Wyzwól zdarzenie 'read'
        Event::trigger('read', array('read'));
    }
}
