<?php

namespace BrunoGrosdidier\Blog\config;

class Parameter
{
    private $parameter;

    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    public function get($name)
    {
        if(isset($this->parameter[$name]))
        {
            return $this->parameter[$name];
        }
        return null;
    }

    public function set($name, $value)
    {
        $this->parameter[$name] = $value;
    }
}
