<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use stdClass;

class Milhas123{

    private $url;

    public function __construct()
    {
        $this->url = "http://prova.123milhas.net/api/flights";
    }

    public function getFlights()
    {
        $response = Http::get($this->url)->json();

        $flights = collect($response);

        //Group by Fare
        $fareGroups = $this->groupByFare($flights);

        $groups = $fareGroups->map(function ($fareGroup) {

            //Create Outbound and Inbound Groups
            $outBoundGroup = $this->groupByStatus($fareGroup, "outbound");
            $inBoundGroup = $this->groupByStatus($fareGroup, "inbound");

            //Group by Price
            $outBoundPriceGroup = $this->groupByPrice($outBoundGroup);
            $inBoundPriceGroup = $this->groupByPrice($inBoundGroup);

            return $this->getGroups($outBoundPriceGroup, $inBoundPriceGroup); 

        })->flatten(1);
 
        $response = new stdClass();
        $cheapestFlight = $this->getCheapest($groups);
        
        $response->flights = $flights;
        $response->groups = $groups;
        $response->totalGroups = $this->getTotal($groups);
        $response->totalFlights = $this->getTotal($flights);
        $response->cheapestPrice = $cheapestFlight->totalPrice;
        $response->cheapestGroup = $cheapestFlight->uniqueId;

        return $response;
       
    }

    public function groupByFare($flights){
        return $flights->groupBy("fare");
    }

    public function groupByStatus($flights, $status){
        return $flights->where($status);
    }    

    public function groupByPrice($flights){
        return $flights->groupBy("price");        
    }

    public function getGroups($outBoundGroup, $inBoundGroup){
        $i = 1;
        $groups = [];

        foreach($outBoundGroup as $outbound){

            foreach($inBoundGroup as $inbound){
                $totalPrice = $inbound[0]['price'] + $outbound[0]['price'];
                array_push($groups, $this->setGroup($outbound->pluck("id"), $inbound->pluck("id"), $totalPrice, $i++));
            }
        }

        return $groups;
    }

    public function setGroup($outbound, $inbound, $totalPrice, $id){        
        $group = new stdClass;

        $group->uniqueId = $id;
        $group->totalPrice = $totalPrice;
        $group->outbound = $outbound;
        $group->inbound = $inbound;

        return $group;
    }

    public function getTotal($flights){
        return $flights->count();
    }

    public function getCheapest($flight){
        return $flight->sortBy("totalPrice")->first();
    }

}



