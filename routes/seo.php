<?php

use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => 'https://apexcashtrainer.com/', 'priority' => '1.0'],
        ['loc' => 'https://apexcashtrainer.com/login', 'priority' => '0.7'],
        ['loc' => 'https://apexcashtrainer.com/register', 'priority' => '0.8'],
        ['loc' => 'https://apexcashtrainer.com/hand-lab', 'priority' => '0.9'],
        ['loc' => 'https://apexcashtrainer.com/spot-training', 'priority' => '0.9'],
        ['loc' => 'https://apexcashtrainer.com/cookies', 'priority' => '0.3'],
        ['loc' => 'https://apexcashtrainer.com/privacy', 'priority' => '0.3'],
        ['loc' => 'https://apexcashtrainer.com/terms', 'priority' => '0.3'],
        ['loc' => 'https://apexcashtrainer.com/contact', 'priority' => '0.4'],
    ];

    $xml = view('seo.sitemap', compact('urls'))->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
});