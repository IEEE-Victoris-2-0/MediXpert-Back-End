<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Whishlist;
use App\Models\Drug;
class WhislistController extends Controller
{

    public function index(Request $request)
    {
        if ($request->user()) {
            try {
                $wishlist = Whishlist::where('user_id', $request->user()->id)->firstOrFail()->get();
                return response()->json($wishlist);
            } catch (ModelNotFoundException $e) {
                return response()->json(['status' => 'you dont have any wishlist']);
            }
        }
        return response()->json(['status' => 'Log In to Add to your Wishlist']);
    }

    public function addwhishlist(Request $request)
    {
        $user = $request->user();
    
        if ($user) {
            $drugId = $request->input('drug_id');
            $drug = Drug::find($drugId);
            
            if (!$drug) {
                return response()->json(['status' => 'Drug does not exist']);
            }
            
            $existingWishlist = Whishlist::where('user_id', $user->id)
                                        ->where('drug_id', $drugId)
                                        ->exists();
            
            if ($existingWishlist) {
                return response()->json(['status' => 'Drug already in wishlist']);
            }
            
            $wishlist = new Whishlist();
            $wishlist->drug_id = $drugId;
            $wishlist->user_id = $user->id;
            $wishlist->save();
            
            return response()->json(['status' => 'Added to wishlist']);
        }
        
        return response()->json(['status' => 'Log in to add to your wishlist']);
    }


    public function remove_item(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['status' => 'Please log in to complete'], 401);
        }
        Whishlist::where('id', $request->input('drug_id'))?->delete();
    
        return response()->json(['status' =>' Deleted Successfully']);
    }
}
