<?php

namespace App\Http\Controllers\Brand;

use App\Brand;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Gate;

class BrandTransactionController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Brand $brand)
    {
        Gate::authorize('make-admin-action');
        $transactions = $brand->products()->with('transactions')->get()->pluck('transactions')->collapse();
        return $this->showAll($transactions);
    }
}
