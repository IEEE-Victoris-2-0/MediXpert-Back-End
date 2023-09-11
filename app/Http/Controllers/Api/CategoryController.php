<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Support\Facades\File;
class CategoryController extends Controller
{

    public function index()
    {
        $categories =Category::all(); 
        $array = [ 
            'data'=> CategoryResource::collection($categories) , 
            'msg'=>"okay", 
            'status'=>200
        ];
        return response($array);
    }

    public function show($id)
    {
        $category =  Category::find($id);
        $array = [ 
            'data'=> new CategoryResource($category) , 
            'msg'=>"okay", 
        ];

        if($category){
            return response($array,200);
        }

        $notfound = [
            'data'=>null,
            'msg'=>"the category is not found", 
            'status'=>401   
        ];
        return response($notfound,401);
    }


    public function insert(Request $request)
    {
        $category = new Category();
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().''.$ext;
            $file->move('assets/uploads/category',$filename); 
            $category->image = $filename;
        }
    
        $request->validate([ 
            'category_name' => 'required|string',
            'image' => 'required|string',
        ]);
        
        $category->category_name = $request->category_name;
        
        $category->save(); 
        
        $response = [
            'data' => $category,
            'msg' => "category added successfully", 
            'status' => 200
        ];
    
        return response($response, 200);
    }

    public function edit(Request $request , $id)
{
    $category = Category::find($id);

    if($request->hasFile('image'))
    {
        $path = 'assets/uploads/category' . $category->image; 
        if(File::exists($path))
        {
            File::delete($path);
        }

        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '' . $ext;
        $file->move('assets/uploads/category', $filename); 
        $category->image = $filename;
    }

    $request->validate([ 
        'category_name' => 'required|string',
        'image' => 'required|string',
    ]);

    $category->category_name = $request->category_name;

    $category->save(); 

    $response = [
        'data' => $category,
        'msg' => "category updated successfully", 
        'status' => 200
    ];

    return response($response, 200);
}

public function destroy(Request $request , $id)
{
    $category = Category::find($id);
    
    if($category->image)
    {
        $path = 'assets/uploads/category' . $category->image; 
        if(File::exists($path))
        {
            File::delete($path);
        }
    }

    $category->delete();

    $response = [
        'msg' => "category deleted successfully", 
        'status' => 200
    ];

    return response($response, 200);
}
}
