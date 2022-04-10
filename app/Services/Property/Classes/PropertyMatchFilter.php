<?php

namespace App\Services\Property\Classes;

use App\Models\Property;
use App\Services\Property\Classes\Property as PropertyClass;
use Illuminate\Http\Request;

class PropertyMatchFilter
{
    private $property;

    private $request;

    public function __construct(Property $property, Request $request)
    {
        $this->property = $property;

        $this->request = $request;
    }

    public function handle()
    {
        $propertyClass = new PropertyClass($this->property);

        $searchProfile = new SearchProfile($this->request, $this->property);

        $propertyType = $propertyClass->getPropertyType();

        $searchFields = $searchProfile->getSearchProfileFields();

        return $this->filterMatches($propertyType, $searchFields);
    }

    protected function filterMatches(string $propertyType, array $searchFields)
    {
        if(empty($searchFields)){
            return [];
        }

        $properties = Property::where('propertyType', $propertyType)->cursor();

        $propertyDetails = [];

        foreach($properties as $prop){
            $searchResults = $this->search($searchFields, $prop);

            $propertyDetails[] = [
                'searchProfileId' => $prop->id,
                'score' => $this->calculateScoreAverage($searchResults['matchScore']),
                'strictMatchesCount' => $searchResults['strictMatchesCount'],
                'looseMatchesCount' => $searchResults['looseMatchesCount'],
            ];
        }

        usort($propertyDetails, function ($a, $b) {
            if($a['score']==$b['score']) return 0;
            return $a['score'] < $b['score'] ? 1 : -1;
        });

        return $propertyDetails;
    }


    protected function search($searchFields, Property $property)
    {
        $looseMatchCount = 0;
        $strictMatchCount = 0;
        $details = [];

        foreach($searchFields as $search => $value){
            if(is_null($property->{$search})){
                continue;
            }

            $searchValue = $this->request->get($search);
            $propertyValue = $property->{$search};
            if(! is_array($searchValue)){
                $propertyValueArray = explode(' ', $propertyValue);
                $searchValueArray = explode(' ', $searchValue);

                $exacts = array_intersect($searchValueArray, $propertyValueArray);

                $score = count($exacts) * 100 / count($searchValueArray);

            }else{
                $searchValue[0] = is_null($searchValue[0]) ? 0 : $searchValue[0];

                if(is_null($searchValue[1])){
                    $strict = ($searchValue[0] <= $propertyValue) && ($propertyValue > $searchValue[1]);
                }else{
                    $strict = ($searchValue[0] <= $propertyValue) && ($propertyValue <= $searchValue[1]);
                }

                if($strict){
                    $score = $this->calculateRangePercentageMatchScore($searchValue, $propertyValue, true);
                }else{
                    $deviatedValues = $this->applyDeviation($searchValue);

                    $score = $this->calculateRangePercentageMatchScore($deviatedValues, $propertyValue);
                }
            }

            if($score >= 75 ){
                $strictMatchCount++;
            }

            if(0 < $score && $score < 75 ){
                $looseMatchCount++;
            }

            $details['matchScore'][] = $score;
            $details['strictMatchesCount'] = $strictMatchCount;
            $details['looseMatchesCount'] = $looseMatchCount;
        }

        return $details;
    }

    protected function applyDeviation(array $numbers)
    {
        if(is_null($numbers[1])){
            return [($numbers[0] - ($numbers[0] * 0.25)), null];
        }

        return [($numbers[0] - ($numbers[0] * 0.25)), ($numbers[1] + ($numbers[1] * 0.25))];
    }

    protected function calculateRangePercentageMatchScore(array $numbers, int $value, $strict=false)
    {
        if($strict){
            return 100;
        }

        if(is_null($numbers[1]) && $value > $numbers[0]){
            return 75;
        }

        if(($numbers[0] <= $value) && ($value <= $numbers[1])){
            return 80;
        }

        return 0;
    }

    protected function calculateScoreAverage(array $scores)
    {
        return array_sum($scores)/count($scores);
    }
}
