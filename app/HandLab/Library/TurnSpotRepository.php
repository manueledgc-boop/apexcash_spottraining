<?php

namespace App\HandLab\Library;

class TurnSpotRepository
{
    public static function all(): array
    {
        $spots = [];

        foreach (glob(app_path('HandLab/Library/Turn/*.php')) as $file) {
            $class = 'App\\HandLab\\Library\\Turn\\' . basename($file, '.php');

            if (class_exists($class) && method_exists($class, 'all')) {
                $spots = array_merge($spots, $class::all());
            }
        }

        return $spots;
    }
}