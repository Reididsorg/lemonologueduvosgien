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
        //var_dump($class);
        $class = str_replace('BrunoGrosdidier\Blog\\', '', $class);
        $class = str_replace("\\", '/', $class);
        //var_dump($class);
        require ($class.'.php');
    }
}
