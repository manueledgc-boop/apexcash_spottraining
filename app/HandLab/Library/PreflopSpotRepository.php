<?php

namespace App\HandLab\Library;

class PreflopSpotRepository
{
    public static function all(): array
    {
        $spots = [];

        foreach (glob(app_path('HandLab/Library/Preflop/*.php')) as $file) {
            $class = 'App\\HandLab\\Library\\Preflop\\' . basename($file, '.php');

            if (class_exists($class) && method_exists($class, 'all')) {
                $spots = array_merge($spots, $class::all());
            }
        }

        return $spots;
    }
}