<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PharmacyResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\File;
class PharamcyController extends Controller
{

    public function index()
    {
        $pharm = Pharmacy::all();
        $array = [ 
            'data'=> PharmacyResource::collection($pharm) , 
            'msg'=>"okay", 
            'status'=>200
        ];
        return response($array);
    }


    public function show($id)
    {
        $pharm =  Pharmacy::find($id);
        $array = [ 
            'data'=>$pharm, 
            'msg'=>"okay", 
        ];

        if($pharm){
            return response($array,200);
        }

        $notfound = [
            'data'=> null,
            'msg'=>"this pharmacy is not here", 
            'status'=>401   
        ];
        return response($notfound,401);
    }
    public function insert(Request $request)
    {
        $pharm = new Pharmacy();
        
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().''.$ext;
            $file->move('assets/uploads/pharmacy',$filename); 
            $pharm->image = $filename;
        }
        $request->validate([ 
            'pharmacy_name' => 'required|string',
            'pharmacy_address' => 'required|string',
            'pharmacy_image' => 'required|string',
            'pharmacy_phone' => 'required|numeric',
        ]);
        $pharm->pharmacy_name = $request->pharmacy_name;
        $pharm->pharmacy_address = $request->pharmacy_address;
        $pharm->pharmacy_image = $request->pharmacy_image;
        $pharm->pharmacy_phone = $request->pharmacy_phone;
        $pharm->save(); 
        $response = [
            'data' => $pharm,
            'msg' => "pharamcy added successfully", 
            'status' => 200
        ];
        return response($response, 200);
    }


    public function edit(Request $request,$id)
    {
        $pharm = Pharmacy::find($id);
        $request->validate([ 
            'pharmacy_name' => 'required|string',
            'pharmacy_address' => 'required|string',
            'pharmacy_image' => 'required|string',
            'pharmacy_phone' => 'required|numeric',
        ]);
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().''.$ext;
            $file->move('assets/uploads/pharamcy', $filename); 
            $pharm->image = $filename;
        }
    
        $pharm->pharmacy_name = $request->pharmacy_name;
        $pharm->pharmacy_address = $request->pharmacy_address;
        $pharm->pharmacy_image = $request->pharmacy_image;
        $pharm->pharmacy_phone = $request->pharmacy_phone;
        $pharm->save(); 
        $response = [
            'data' => $pharm,
            'msg' => "pharamcy data Updated successfully", 
            'status' => 200
        ];
        return response($response, 200);
    }
    public function destroy($id)
    {
        $pharam = Pharmacy::find($id);
        if($pharam->image)
    {
        $path = 'assets/uploads/pharmacy' . $pharam->image; 
        if(File::exists($path))
        {
            File::delete($path);
        }
    }
    $pharam->delete();
    $response = [
        'msg' => "pharmacy deleted successfully", 
        'status' => 200
    ];

    return response($response, 200);
    }
}
