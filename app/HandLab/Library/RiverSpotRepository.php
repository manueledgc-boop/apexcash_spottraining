<?php

namespace App\HandLab\Library;

class RiverSpotRepository
{
    public static function all(): array
    {
        $spots = [];

        foreach (glob(app_path('HandLab/Library/River/*.php')) as $file) {
            $class = 'App\\HandLab\\Library\\River\\' . basename($file, '.php');

            if (class_exists($class) && method_exists($class, 'all')) {
                $spots = array_merge($spots, $class::all());
            }
        }

        return $spots;
    }
}