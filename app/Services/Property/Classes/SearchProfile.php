<?php

namespace App\Services\Property\Classes;

use App\Models\Property;
use App\Services\Property\Interfaces\SearchProfile as SearchProfileInterface;
use Illuminate\Http\Request;

class SearchProfile implements SearchProfileInterface
{
    private Request $request;

    private Property $property;

    private string $name;

    private string $propertyType;

    private array $searchFields;

    public function __construct(Request $request, Property $property)
    {
        $this->request = $request;

        $this->property = $property;

        $this->setSearchProfileFields();

        $this->setSearchProfilePropertyType();
    }

    protected function setSearchProfilePropertyType()
    {
        $this->propertyType = $this->request->get('propertyType') ?? $this->property->propertyType;

        return $this;
    }

    protected function setSearchProfileFields()
    {
        $columns = $this->request->except(['name', 'address', 'propertyId']);

        $fields = [];

        foreach($columns as $column => $value){
            $fields[$column] = $this->request->{$column};
        }

        $this->searchFields = $fields;

        return $this;
    }

    public function getSearchProfilePropertyType()
    {
        return $this->propertyType;
    }

    public function getSearchProfileFields()
    {
        return $this->searchFields;
    }
}
