<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Category;

class CategoryController extends ApiController
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
      $categories = Category::all();
      return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)   //admin only method
    {
      Gate::authorize('make-admin-action');

      $rules = [
        'name' => 'required|min:3|max:32',
        'description' => 'min:3',
      ];

      $data = $request->validate($rules);
      $category = ['name' => $data['name'], 'description' => $data['description']];

      $category = Category::create($category);

      return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) //admin only method
    {
      Gate::authorize('make-admin-action');

      $rules = [
        'name' => 'min:3|max:32',
        'description' => 'min:3',
      ];

      $request->validate($rules);

      if($request->filled('name')) {
        $category->name = $request->name;
      }
      if($request->filled('description')) {
        $category->description = $request->description;
      }
      if($category->isClean()) {
        return $this->errorResponse('Nothing has changed', 422);
      }

      $category->save();

      return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) //admin only method
    {
      Gate::authorize('make-admin-action');

        $category->delete();

        return $this->showOne($category);
    }
}
