<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*Route::get('/foo', function () {
    //Passiamo il valore status=1, email promozione inviata
    Artisan::queue('promo:email', ['status' => 1]);

});*/


Route::get('/test', function()
{
    //Passiamo il valore status=1, email promozione inviata
    Artisan::call('promo:email', ['status' => 1]);
    dd(Artisan::output());

  //Passiamo 2 o più valori
    //P Artisan::call('promo:email', ['status' => 1, '--promozione'=>1]);
    //P dd(Artisan::output());
});



Route::auth();

Route::get('/home', 'HomeController@index');
