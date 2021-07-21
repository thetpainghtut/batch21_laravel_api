<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands);
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
            "name" => "required|unique:brands|max:191|min:3",
            "photo" => "required|mimes:jpeg,jpg,png"
        ]);

        // upload file
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();

            // categoryimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('brandimg', $fileName, 'public');
        }

        // data insert
        $brand = new Brand; // create new object
        $brand->name = $request->name;
        $brand->photo = $filePath;
        $brand->save();

        // redirect
        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        // dd($request);

        // validation
        $request->validate([
            "name" => "required|max:191|min:3",
            "photo" => "sometimes|mimes:jpeg,jpg,png"
        ]);

        // upload file
        if($request->file()) {
            // 624872374523_a.jpg
            $fileName = time().'_'.$request->photo->getClientOriginalName();

            // categoryimg/624872374523_a.jpg
            $filePath = $request->file('photo')->storeAs('brandimg', $fileName, 'public');
            // Delete old photo (try yourself)
            unlink(public_path('storage/').$brand->photo);
        }else{
            $filePath = $brand->photo;
        }

        // data update
        $brand->name = $request->name;
        $brand->photo = $filePath;
        $brand->save();

        // redirect
        return new BrandResource($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        // redirect
        return new BrandResource($brand);
    }
}
