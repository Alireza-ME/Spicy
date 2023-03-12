<?php

namespace spicy\cv_methods;

class Methods
{

    public static function cv_method_exists(string $method_name)
    {
        $methods = scandir(__DIR__.'/methods');
        if (in_array($method_name.'.spicy',$methods)) {
            return true;
        }
    }

}
