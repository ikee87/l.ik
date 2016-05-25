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

use Illuminate\Http\Request;
use App\Place;

Route::get('/', function () {
//    $place = Place::find(5);
//    $data = (object) $place->data;
//    echo $data->name;
    return view('welcome');
});

Route::get('create', function() {
    return view('create');
});

Route::post('create', function(Request $request) {
    $data = json_decode($request->get('data'), true);
    Place::create(['data' => $data]);
    return redirect('create');
});

Route::get('p', function(){
    $places_moscow = Place::moscow()->get();
    $places_type = Place::ofType('type_2')->get();
    dd($places_moscow, $places_type);
});