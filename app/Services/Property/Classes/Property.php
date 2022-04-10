<?php

namespace App\Services\Property\Classes;

use App\Models\Property as PropertyModel;
use App\Services\Property\Interfaces\Property as PropertyInterface;
use Illuminate\Support\Facades\Schema;

class Property implements PropertyInterface
{
    private PropertyModel $property;

    private string $name;

    private string $address;

    private string $propertyType;

    private array $fields;

    public function __construct(PropertyModel $property)
    {
        $this->property = $property;

        $this->setPropertyType();

        $this->setFields();
    }

    protected function setPropertyType()
    {
        $this->propertyType = $this->property->propertyType;

        return $this;
    }

    protected function setFields()
    {
        $columns = Schema::getColumnListing('properties');
        $columns = array_diff($columns, ['name', 'address', 'propertyType', 'created_at', 'updated_at', 'id']);

        foreach($columns as $column){
            $fields[$column] = $this->property->{$column};
        }

        $this->fields = $fields;

        return $this;
    }

    public function getPropertyType()
    {
        return $this->propertyType;
    }

    public function getPropertyFields()
    {
        return $this->fields;
    }
}
