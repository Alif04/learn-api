<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Exception;
use App\Models\Item;
use App\Models\Category;
use App\Http\Resources\Item as ItemResource;
   
class ItemController extends BaseController
{
    public function index()
    {
        $items = Item::all();
        return $this->sendResponse(ItemResource::collection($items), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nama' => 'required',
            'harga' => 'required',
            'total' => 'required',
            'warna' => 'required',
            'category_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        
        try{
            $item = Item::create($input);
            $category = Category::find($input['category_id']);
            $item->items()->attach($category); 
        } catch(\Exception $e){
            return $this->sendError( $e->getMessage());
        }


        
        return $this->sendResponse(new ItemResource($item), 'Post created.');
    }
   
    public function show($id)
    {
        $item = Item::find($id);
        if (is_null($item)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ItemResource($item), 'Post fetched.');
    }
    
    public function update(Request $request, Item $item)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'category' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'total' => 'required',
            'warna' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $item->category = $input['category'];
        $item->nama = $input['nama'];
        $item->harga = $input['harga']; 
        $item->save();
        
        return $this->sendResponse(new ItemResource($item), 'Post updated.');
    }
   
    public function destroy(Item $item)
    {
        $item->delete();
        return $this->sendResponse([], 'Post deleted.');
    }

    public function topItem(){
        $top = Item::orderBy('total', 'desc')->paginate(3)->toArray();
        return $this->sendResponse($top);
    }

    public function getItemHasCategory(){
        $items =  Item::with('items')->get();
        return $this->sendResponse($items, 'Success');
    }
    
}