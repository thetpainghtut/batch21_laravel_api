<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Http\Resources\ItemResource;

class FrontendController extends Controller
{
    public function getItems($value='')
    {
        $items = Item::all();
        return ItemResource::collection($items);
    }
    
}
