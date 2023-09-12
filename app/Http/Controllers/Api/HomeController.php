<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DrugResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Drug;
use App\Models\Pharmacy;
use App\Http\Resources\CategoryResource;
class HomeController extends Controller
{
    public function index()
{
        $categories =Category::all(); 
        $Drugs = Drug::all();
        $array = [ 
            'category_key'=> CategoryResource::collection($categories),
            'Drug_key'=>DrugResource::collection($Drugs),
            'msg'=>"okay", 
            'status'=>200
        ];
        return response($array);
 }
 public function product_by_category($id)
{
    $category = Category::with('Drug')->find($id); // Eager load drugs for the category

    if ($category) {
        $drugs = $category->Drug; // Access the eagerly loaded drugs
    } else {
        $drugs = collect(); // Empty collection if category doesn't exist
    }

    $array = [
        'Drug_key' => DrugResource::collection($drugs),
        'msg' => "okay",
        'status' => 200
    ];

    return response($array, 200);
}
}
