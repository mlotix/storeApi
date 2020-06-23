<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;

class BrandController extends ApiController
{

    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
      return $this->showAll($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('make-admin-action');

        $rules = [
          'name' => 'required|min:3|max:64',
          'description' => 'min:3',
        ];

        $request->validate($rules);

        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $brand = Brand::create($data);

        return $this->showOne($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return $this->showOne($brand);
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
      Gate::authorize('make-admin-action');

      $rules = [
        'name' => 'min:3|max:64',
        'description' => 'min:3',
      ];

      $request->validate($rules);

      if($request->filled('name')) {
        $brand->name = $request->name;
      }
      if($request->filled('description')) {
        $brand->description = $request->description;
      }
      if($brand->isClean()) {
        return $this->errorResponse('Nothing has changed', 422);
      }

      $brand->save();

      return $this->showOne($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
      Gate::authorize('make-admin-action');

        $brand->delete();

        return $this->showOne($brand);
    }
}
