<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *
 */
trait ApiResponser
{
  protected function successResponse($data, $code)
  {
    return response()->json($data, $code);
  }

  protected function errorResponse($message, $code)
  {
    return response()->json(['data' => $message, 'code' => $code], $code);
  }

  protected function showAll(Collection $collection, $code = 200) {

    if($collection->isNotEmpty()){
      $transformer = $collection->first()->transformer;
      $collection = $this->filterResponse($collection, $transformer);
      $collection = $this->sortResponse($collection, $transformer);
      $collection = $this->paginateResponse($collection);

      $collection = $this->transformResponse($collection, $transformer);

      return $this->successResponse($collection, $code);
    }
    return $this->successResponse(['data' => $collection], $code);
  }

  protected function showOne(Model $model, $code = 200) {
    $transformer = $model->transformer;
    if($transformer) {
      $model = $this->transformResponse($model, $transformer);
      return $this->successResponse($model, $code);
    }
    return $this->successResponse(['data' => $model], $code);
  }
  protected function showMsg($msg, $code = 200) {
    return $this->successResponse($msg, $code);
  }

  protected function transformResponse($data, $transformer) {
    $tran = fractal($data, new $transformer);
    return $tran->toArray();
  }

  protected function sortResponse(Collection $collection, $transformer = null) {
    if(request()->has('sort_by')) {
      $sort = request()->sort_by;
      if($transformer) {
        $sort = $transformer::attributeMap($sort);
      }
      return $collection->sortBy->{$sort};
    }
    return $collection;
  }

  protected function filterResponse(Collection $collection, $transformer = null) {
    foreach (request()->query() as $query => $value) {
      if($transformer) {
        $attribute = $transformer::attributeMap($query);
      }
      else {
        $attribute = $query;
      }

      if(isset($attribute, $value)) {
        $collection = $collection->where($attribute, $value);
      }
    }

    return $collection;
  }

  protected function paginateResponse(Collection $collection) {

    $rules = [
      'per_page' => 'integer|gte:10|lte:100',
    ];
    Validator::validate(request()->all(), $rules);

    $perPage = 20;
    if(request()->has('per_page')) {
      $perPage = request()->per_page;
    }

    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $items = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();
    $total = $collection->count();
    $options = [
      'path' => LengthAwarePaginator::resolveCurrentPath(),
    ];

    $paginated = new LengthAwarePaginator($items, $total, $perPage, $currentPage, $options);

    $paginated->appends(request()->all());
    return $paginated;
  }
}
