<?php

namespace App\Controllers\Location;
use App\Controllers\Controller;
use App\Models\Location\LocationCity;
use App\Models\Location\LocationStates;
use App\Models\Location\LocationCountry;
use App\Models\Location\Place;
use App\Models\Location\PlaceCategory;

class LocationServiceController extends Controller {

    private function getCountry($id){

        //cek db
        $data = LocationCountry::where('id', $id)->first();

        //give response message
        return $data->name;

    }

    private function getStates($id){

        //cek db
        $data = LocationStates::where('id', $id)->first();

        //give response message
        return $data->name;

    }

    private function getCity($id){

        //cek db
        $data = LocationCity::where('id', $id)->first();

         //give response message
         return $data->name;

    }

    private function getPlace($id) {

        //cek db
        $data = Place::where('id', $id)->first();

        //give response message
        return $data->name;

    }

    private function getPlaceCategory($id) {

        //cek
        $data = PlaceCategory::where('id', $id)->first();

        //give response message
        return $data->category_name;

    }

    public function getLocation($request, $response){

        $country = $this->getCountry(1);
        $state = $this->getStates(1);
        $city = $this->getCity(1);
        $place = $this->getPlace(1);
        $category_place = $this->getPlaceCategory(2);

        return $response->withJson(array(
            'country' => $country,
            'state' =>  $state,
            'city' => $city,
            'place' => $place,
            'place_category' => $category_place,

        ),200);

    }

 }