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
            'data'=> DrugResource::collection($Drugs) , 
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
        'drug_image' => 'required|string', 
        'item_price' => 'required|numeric', 
        'qty' => 'required|integer', 
        'category_id' => 'required|numeric',
        'pharmacy_id'=>'required|numeric'
    ]);
    
    $drug = new Drug();
    
    if($request->hasFile('image'))
    {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time().''.$ext;
        $file->move('assets/uploads/drugs', $filename); 
        $drug->image = $filename;
    }

    $drug->drug_name = $request->drug_name;
    $drug->description = $request->description;
    $drug->item_price = $request->item_price;
    $drug->qty = $request->qty;
    $drug->category_id = $request->category_id;
    $drug-> pharmacy_id = $request->pharmacy_id;    
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
        'drug_image' => 'required|string', 
        'item_price' => 'required|numeric', 
        'qty' => 'required|integer', 
        'category_id' => 'required|numeric',
        'pharmacy_id'=>'required|numeric'
    ]);
    if($request->hasFile('image'))
    {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time().''.$ext;
        $file->move('assets/uploads/drugs', $filename); 
        $drug->image = $filename;
    }

    $drug->drug_name = $request->drug_name;
    $drug->description = $request->description;
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
}
