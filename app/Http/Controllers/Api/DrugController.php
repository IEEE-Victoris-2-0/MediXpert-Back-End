<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DrugResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\Drug;
use Illuminate\Support\Facades\File;
class DrugController extends Controller
{
    //use ApiResponseTrait;

    public function index()
    {
         $Drugs = Drug::all(); 
        $array = [ 
            'data'=> DrugResource::collection($Drugs), 
            'msg'=>"okay", 
            'status'=>200
        ];
        return response($array);
    }

    public function show($id)
    {
        $drug =  Drug::find($id);
        $array = [ 
            'data'=>$drug , 
            'msg'=>"okay", 
        ];

        if($drug){
            return response($array,200);
        }

        $notfound = [
            'data'=> null,
            'msg'=>"the drug is not found", 
            'status'=>401   
        ];
        return response($notfound,401);
    }

    public function insert(Request $request)
    {
        $request->validate([ 
            'drug_name' => 'required|string',
            'description' => 'required|string', 
            'drug_image' => 'required|string|:jpg,png,jpeg,gif,svg|max:2048', // Update the validation rule
            'item_price' => 'required|numeric', 
            'qty' => 'required|integer', 
            'category_id' => 'required|numeric',
            'pharmacy_id'=>'required|numeric'
        ]);
        
         $drug = new Drug();
       // $drug_image = $request->file('drug_image')->getClientOriginalName();;
        $drug->drug_name = $request->drug_name;
        $drug->description = $request->description;
        $drug->drug_image = $request->drug_image;
        $drug->item_price = $request->item_price;
        $drug->qty = $request->qty;
        $drug->category_id = $request->category_id;
        $drug->pharmacy_id = $request->pharmacy_id; // Remove the extra space
        $drug->save(); 
    
        $response = [
            'data' => $drug,
            'msg' => "Drug added successfully", 
            'status' => 200
        ];
    
        return response($response, 200);
    }

public function edit(Request $request , $id)
{
    $drug = Drug::find($id);
    $request->validate([ 
        'drug_name' => 'required|string',
        'description' => 'required|string', 
        'drug_image' => 'required|image|:jpg,png,jpeg,gif,svg|max:2048', 
        'item_price' => 'required|numeric', 
        'qty' => 'required|integer', 
        'category_id' => 'required|numeric',
        'pharmacy_id'=>'required|numeric'
    ]);
    $drug_image = $request->file('drug_image')->store('image', 'public');

    $drug->drug_name = $request->drug_name;
    $drug->description = $request->description;
    $drug->drug_image = $request->drug_image;
    $drug->item_price = $request->item_price;
    $drug->qty = $request->qty;
    $drug->category_id = $request->category_id;     
    $drug->save(); 

    $response = [
        'data' => $drug,
        'msg' => "Drug updated successfully", 
        'status' => 200
    ];

    return response($response, 200);
}

public function destroy($id)
{
    $drug = Drug::find($id);
    if($drug->image)
    {
        $path = 'assets/uploads/drugs' . $drug->image; 
        if(File::exists($path))
        {
            File::delete($path);
        }
    }

    $drug->delete();

    $response = [
        'msg' => "drug deleted successfully", 
        'status' => 200
    ];
    
    return response($response, 200);
}

public function search(Request $request){
    $search = $request->search;
    $drugs=Drug::where( function($query) use($search){
       $query->where('drug_name' , 'like' , "%$search%");
    }) ->get();
    return response()->json($drugs);
}

}
