<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function showGeocode()
    {
        $locations = Location::all();
        return view('backend.merchant.sample_geo', compact('locations'));
    }

    public function geocode(Request $request)
    {
        $address = $request->input('address');

        // Replace 'YOUR_GOOGLE_MAPS_API_KEY' with your actual API key
        $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY';

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $address,
            'key' => $apiKey,
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['results']) && count($data['results']) > 0) {
            $latitude = $data['results'][0]['geometry']['location']['lat'];
            $longitude = $data['results'][0]['geometry']['location']['lng'];

            Location::create([
                
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            return view('backend.merchant.sample_geo', compact('latitude', 'longitude'));
        } else {
            return redirect()->back()->with('error', 'Failed to geocode the address or no results found.');
        }


    // public function convertAddressToCoordinates(Request $request)
    // {
    //     $address = $request->query('address');
    //     $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY';
    //     $client = new Client();
    //     $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
    //         'query' => [
    //             'address' => $address,
    //             'key' => $apiKey,
    //         ],
    //     ]);

    //     $data = json_decode($response->getBody());

    //     if ($data->status === 'OK') {
    //         $latitude = $data->results[0]->geometry->location->lat;
    //         $longitude = $data->results[0]->geometry->location->lng;

    //         return response()->json(['latitude' => $latitude, 'longitude' => $longitude]);
    //     } else {
    //         return response()->json(['error' => 'Geocoding error'], 400);
    //     }
    // }

    // //
    // public function setShopAddress(Request $request)
    // {
    //     // $address = $request->input('address');
    //     $postcode = $request->input('postcode');
    //     $apiKey = env('GEOCODING_API_KEY'); // Use environment variable for API key

    //     $response = Http::get("https://api.postcodes.io?postcode={$postcode}&key={$apiKey}");

    //     if ($response->successful()) {
    //         $data = $response->json();

    //         // Check if 'latitude' and 'longitude' keys exist in the response data
    //         if (isset($data['latitude']) && isset($data['longitude'])) {
    //             $latitude = $data['latitude'];
    //             $longitude = $data['longitude'];

    //             Location::create([
    //                 'latitude' => $latitude,
    //                 'longitude' => $longitude,
    //             ]);

    //             // Continue with any other logic you have
    //         } else {
    //             // Handle missing data structure here
    //             $errorMessage = 'Latitude or longitude data is missing.';
    //             return redirect()->back()->with('error', $errorMessage);
    //         }
    //     } else {
    //         // Handle API error
    //         $errorMessage = $response->json()['error'] ?? 'An error occurred.';
    //         return redirect()->back()->with('error', $errorMessage);
    //     }

    // }




    // public function index(Request $request)
    // {
    //     $lat = YOUR_CURRENT_LATITUDE;
    //     $lon = YOUR_CURRENT_LONGITUDE;

    //     $users = User::select("users.id",
    //         DB::raw("6371 * acos(cos(radians(" . $lat . "))
    //             * cos(radians(users.lat))
    //             * cos(radians(users.lon) - radians(" . $lon . "))
    //             + sin(radians(" . $lat . "))
    //             * sin(radians(users.lat))) AS distance"))
    //         ->groupBy("users.id")
    //         ->get();

    //     dd($users);
    // }
    }
}
