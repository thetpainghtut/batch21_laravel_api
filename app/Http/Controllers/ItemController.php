<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return ItemResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        // validation
        $request->validate([
            "codeno" => "required|unique:items",
            "name" => "required|max:191|min:5",
            "brand" => "required|exists:brands,id",
            "subcategory" => "required|exists:subcategories,id",
            "photo" => "required|mimes:jpeg,jpg,png",
            "price" => "required|integer",
            "description" => "required",
        ]);

        // upload file
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();

            // categoryimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('itemimg', $fileName, 'public');
        }

        // data insert
        $item = new Item; // create new object
        $item->codeno = $request->codeno;
        $item->name = $request->name;
        $item->brand_id = $request->brand;
        $item->subcategory_id = $request->subcategory;
        $item->photo = $filePath;
        $item->price = $request->price;
        if ($request->discount) {
            $item->discount = $request->discount;
        }
        $item->description = $request->description;
        $item->save();

        // redirect
        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // dd($request);

        // validation
        $request->validate([
            "codeno" => "required",
            "name" => "required|max:191|min:5",
            "brand" => "required|exists:brands,id",
            "subcategory" => "required|exists:subcategories,id",
            "photo" => "required|mimes:jpeg,jpg,png",
            "price" => "required|integer",
            "description" => "required",
        ]);

        // upload file
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();

            // categoryimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('itemimg', $fileName, 'public');

            // Delete old photo (try yourself)
            // condition file exist
            unlink(public_path('storage/').$item->photo);
        }else{
            $filePath = $item->photo;
        }

        // data insert
        $item = new Item; // create new object
        $item->codeno = $request->codeno;
        $item->name = $request->name;
        $item->brand_id = $request->brand;
        $item->subcategory_id = $request->subcategory;
        $item->photo = $filePath;
        $item->price = $request->price;
        if ($request->discount) {
            $item->discount = $request->discount;
        }
        $item->description = $request->description;
        $item->save();

        // redirect
        return new ItemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return new ItemResource($item);
    }
}
