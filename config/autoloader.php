<?php

namespace BrunoGrosdidier\Blog\config;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace('BrunoGrosdidier\Blog\\', '', $class);
        //$class = str_replace('\', '/', $class);
        $class = str_replace("\\", '/', $class);
        //require ('../'.$class.'.php');
        require ($class.'.php');
    }
}