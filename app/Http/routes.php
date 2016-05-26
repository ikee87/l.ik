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

    $response = Curl::to('https://maps.googleapis.com/maps/api/geocode/json?language=ru_RU&latlng=56.315251444657584,44.20773983001709&key=AIzaSyDDNOw7N1klkn-B0sqipJ4vxcaC9mQhHxc')
        ->asJson()
        ->get();

    if ($response->status === 'OK') {
        $results = $response->results;
        $neededTypes = [
            'country',
            'administrative_area_level_1',
            'administrative_area_level_2',
            'locality',
            'street_address', 'route'
        ];
        foreach ($results as $place) {
            $inspect = array_intersect($neededTypes, $place->types);
            if ($inspect) {
                $type = array_shift($inspect);
                $name = null;
                foreach($place->address_components as $address_component) {
                    if (in_array($type, $address_component->types)) {
                        $name = $address_component->long_name;
                    }
                }
                echo "type: $type \n";
                echo "p_id: $place->place_id \n";
                echo "name: $name \n";
                echo "=================================\n";
            }
        }


    }
    die();
    dd($results);



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