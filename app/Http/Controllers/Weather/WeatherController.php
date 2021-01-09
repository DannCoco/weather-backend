<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Weather\Client\Weather;


class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $client = new Weather();
        $data = $client->get($request->city);
        
        $response = [
            'lat' => $data['location']['lat'], 
            'long' => $data['location']['long'],
            'humidity' => $data['current_observation']['atmosphere']['humidity']
        ];

        return response()->json($response);
    }
}
