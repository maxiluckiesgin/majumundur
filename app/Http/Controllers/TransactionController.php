<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction as Transaction;
use App\User as User;

use App\Product as Product;

class TransactionController extends Controller
{
    public function store(Request $request, $id)
    {
			$user = User::findOrFail(Auth::user()->username);
			$product = Product::findOrFail($id);
            $trans = new Transaction;
			$trans->product = $id;
            $trans->customer = Auth::user()->username;
			$trans->ammount = $request->ammount;
			$product->stock = $product->stock - $trans->ammount;
			$total = $trans->ammount * $product->price;
			$rewardAdded = $this->addReward($user,$total);
			$trans->save();
			$product->save();
            return array('success'=>array('product'=>$product->name,'ammount'=>$trans->ammount,'total'=>$total,'reward'=>$rewardAdded));


    }

	public function buyerList(Request $request){
        $trans = Transaction::whereHas('product', function ($query) {
            $query->where('user_id', Auth::user()->username);
        })->get();

        return $trans;
	}

	protected function addReward(User $user,$total){
        $reward = 0;
		if($total > 1000){
			$user->reward = $user->reward + 40;
			$user->save();
			$reward = 40;
		} else if($total > 500){
			$user->reward = $user->reward + 20;
			$user->save();
			$reward = 20;
		}
		return $reward;
	}

}
