<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Exception;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends BaseController
{
    public function store(Request $request){
        $request->validate([
           'category' => 'required' 
        ]);

        $category = Category::create([
            'category' => $request->category,
        ]);

        return $this->sendResponse(new CategoryResource($category), 'Category Create');

    }
}
