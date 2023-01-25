<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
   
class ProductController extends BaseController
{
    public function index()
    {
        $products = product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $product = Product::create($input);
        return $this->sendResponse(new ProductResource($product), 'Post created.');
    }
   
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ProductResource($product), 'Post fetched.');
    }
    
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $product->title = $input['title'];
        $product->description = $input['description'];
        $product->save();
        
        return $this->sendResponse(new ProductResource($product), 'Post updated.');
    }
   
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}