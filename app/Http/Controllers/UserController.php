<?php

namespace App\Http\Controllers;
use App\User as User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
		
		$request->validate([
        'username' => 'required|unique:users',
        'password' => 'required|max:8',
	    'role' => 'required|boolean'
        ]);
            $item = new User;
            $item->username = $request->username;
			$prv = User::All()->max('id');
			$item->id = $prv+1;
			$item->password = bcrypt($request->password);
			$item->role = $request->role;
			$item->save();
            return array('added'=>$request->username);
        
    }
}
