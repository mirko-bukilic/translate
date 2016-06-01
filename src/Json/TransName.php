<?php

namespace G4\Translate\Json;

class TransName
{

    private $name;

    public function __construct($name)
    {
        if(empty($name)){
            throw new \Exception('name is required');
        }
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}