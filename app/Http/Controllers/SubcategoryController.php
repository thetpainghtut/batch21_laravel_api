<?php

namespace App\Http\Controllers;

use App\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryResource;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::all();
        return SubcategoryResource::collection($subcategories);
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
            "name" => "required|unique:subcategories|max:191|min:5",
            // filter only category table id validation rule (try yourself)
            "category" => "required"
        ]);

        // upload file

        // data insert
        $subcategory = new Subcategory; // create new object
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category;
        $subcategory->save();

        // redirect
        return new SubcategoryResource($subcategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        // dd($request);

        // validation
        $request->validate([
            "name" => "required|max:191|min:5",
            // filter only category table id validation rule (try yourself)
            "category" => "required"
        ]);

        // upload file

        // data insert
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category;
        $subcategory->save();

        // redirect
        return new SubcategoryResource($subcategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();

        // redirect
        return new SubcategoryResource($subcategory);
    }
}
