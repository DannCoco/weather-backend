<?php

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Services\Weather\Client\Weather;

class WeatherHistoryController extends Controller
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

        return response()->json($data['forecasts']);
    }
}
