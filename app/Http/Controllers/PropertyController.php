<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Services\Property\Classes\PropertyMatchFilter;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function match(Property $propertyId, Request $request)
    {
        if(empty($request->all())){
            return $propertyId;
        }

        $propertyMatch = new PropertyMatchFilter($propertyId, $request);

        return $propertyMatch->handle();
    }
}
