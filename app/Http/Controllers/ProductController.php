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

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 0])) {
            $item = new Product;
            $item->merchant = Auth::id();
			$prv = Product::All()->max('id');
			$item->id = $prv+1;
			$item->name = $request->input("product.name");
			$item->price = $request->input("product.price");
			$item->stock = $request->input("product.stock");
			$item->save();
            return array('added'=>$request->input("product"));;
        }
		
        return "failed";
        
    }
	
	 function update(Request $request, $id)
    {
		$item = Product::findOrFail($id);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 0])) {
			
            if ($item->merchant == Auth::id()){
			    $item->name = $request->input("product.name");
			    $item->price = $request->input("product.price");
			    $item->stock = $request->input("product.stock");
			    $item->save();
                return array('updated'=>$request->input("product"));	
			 }
			return "authenticated but not the owner";
        }
        return "failed";
        
    }
	
	function destroy(Request $request, $id){
		$item = Product::findOrFail($id);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password, 'role' => 0])) {
			
            if ($item->merchant == Auth::id()){
			    Product::destroy($id);
                return 'deleted';	
			 }
			return "authenticated but not the owner";
        }
        return "failed";
	}
}
