<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {

    Log::channel('single')->info('Ceci est un message de journalisation personnalisé.');
    Log::channel('single')->emergency('Ceci est un message d\'urgence.');
    Log::alert('Ceci est un message d\'alerte.');
    Log::critical('Ceci est un message critique.');
    Log::error('Ceci est un message d\'erreur.');
    Log::warning('Ceci est un avertissement.');
    Log::notice('Ceci est une information importante.');
    Log::debug('Ceci est un message de débogage.');

    return view('welcome');

});
