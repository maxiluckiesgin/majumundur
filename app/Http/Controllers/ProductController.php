<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Product as Product;

class ProductController extends Controller
{
	public function index()
	{
		return Product::All();
	}

    public function store(Request $request)
    {
        $item = new Product;
        $item->merchant = Auth::id();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->save();
        return array('added' => $item);
    }

	 function update(Request $request, $id)
     {
         $item = Product::findOrFail($id);
         if ($item->merchant == Auth::id()) {
             $item->name = $request->name;
             $item->price = $request->price;
             $item->stock = $request->stock;
             $item->save();
             return array('updated' => $item);
         }
         return "You're not the owner of the product";

     }

	function destroy($id)
    {
        $item = Product::findOrFail($id);

        if ($item->merchant == Auth::id()) {
            Product::destroy($id);
            return 'deleted';
        }
        return "You're not the owner of the product";
    }
}
