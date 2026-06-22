<?php

namespace App\HandLab\Library;

class FlopSpotRepository
{
    public static function all(): array
    {
        $spots = [];

        foreach (glob(app_path('HandLab/Library/Flop/*.php')) as $file) {
            $class = 'App\\HandLab\\Library\\Flop\\' . basename($file, '.php');

            if (class_exists($class) && method_exists($class, 'all')) {
                $spots = array_merge($spots, $class::all());
            }
        }

        return $spots;
    }
}