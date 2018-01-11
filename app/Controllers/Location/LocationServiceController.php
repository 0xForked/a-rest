<?php

namespace App\Controllers\Location;
use App\Controllers\Controller;
use App\Models\Location\LocationCity;
use App\Models\Location\LocationStates;
use App\Models\Location\LocationCountry;
use App\Models\Location\Place;
use App\Models\Location\PlaceCategory;
use App\Models\Location\LocationRelation;
use Respect\Validation\Validator as V;

class LocationServiceController extends Controller {

    //Get country name
    private function getCountryName($id){

        $data = LocationCountry::where('id', $id)->first();
        return $data->name;

    }

    //Get states name
    private function getStatesName($id){

        $data = LocationStates::where('id', $id)->first();
        return $data->name;

    }

    //Get city name
    private function getCityName($id){

        $data = LocationCity::where('id', $id)->first();
        return $data->name;

    }

    //Get category name
    private function getCategoryName($id) {

        $data = PlaceCategory::where('id', $id)->first();
        return $data->category_name;

    }

    //Get place location
    private function getLocation($cityId) {

        $data = LocationRelation::where('city_id', $cityId)->first();
        return $data->id;

    }

    //Get City id
    private function convertCityNameToId($cityName){

        $data = LocationCity::where('name', $cityName)->first();
        return $data->id;

    }

    //Get Category Id
    private function convertCategoryNameToId($categoryName){

        $data = PlaceCategory::where('category_name', $categoryName)->first();
        return $data->id;

    }

    /**
     * getAllPlace function - get all place by category and location
     * @param String city, category
     */
    public function getPlaceByCategory($request, $response) {

         $city = $request->getParam('city');
         $category = $request->getParam('category');

        //validation
        $validation =  $this->validator->validate($request, [
            'city'        => V::CityAvailable($city),
            'category'    => V::PlaceCategoryAvailable($category),
        ]);

        //cek validation
        if($validation->failed()){
            return $response->withJson(array(
                'errors' => $_SESSION['errors']
            ),400);
        }

        if($validation) {
            $cityId = $this->convertCityNameToId($city);
            $categoryId = $this->convertCategoryNameToId($category);

            $location = $this->getLocation($cityId);

            $place = Place::where('category_id', $categoryId)
                            ->where('location_id', $location)
                            ->get();

            return $response->withJson($place, 200);

        }

    }

    public function getPlaceDetail($request, $response){

        $place_id = $request->getParam('id');

        $place = Place::where('id', $place_id)->first();

        if(isset($place)) {
            return $response->withJson(array(
                'status' => 200,
                'error' => false,
                'message' => 'success',
                'detail' => [
                    'name'      => $place->name,
                    'lat'       => $place->lat,
                    'lon'       => $place->lon,
                ]
            ),200);
        }

        return $response->withJson(array(
            'status' => 400,
            'error' => true,
            'message' => 'This place is unavailable',
        ),400);

    }

 }