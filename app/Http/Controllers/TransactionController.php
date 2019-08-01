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
        $trans->amount = $request->amount;
        if($product->stock >= $trans->amount){
            $product->stock = $product->stock - $trans->amount;
        } else{
            abort(400,"Product stock is less than amount requested");
        }
        $total = $trans->amount * $product->price;
        $user->point = $user->point + 1;
        $user->save();
        $trans->save();
        $product->save();
        return array('success' => array('product' => $product->name, 'ammount' => $trans->amount, 'total' => $total));


    }

    public function buyerList(Request $request)
    {
        $trans = Transaction::whereHas('product', function ($query) {
            $query->where('user_id', Auth::user()->username);
        })->get();

        return $trans;
    }

    protected function getReward($id)
    {
        $user = User::findOrFail(Auth::user()->username);

        //Reward A
        if ($id == 1) {
            return $this->tradePoint($user,20,'Reward A');
        } else if ($id == 2){
            return $this->tradePoint($user,40,'Reward B');
        }
    }

    protected function tradePoint(User $user , int $pointNeeded, string $rewardName){
        $userPoint = $user->point;
        if ($userPoint >= $pointNeeded) {
            $user->point = $userPoint - $pointNeeded;
            $user->save();
            return $rewardName.' acquired';
        } else {
            return abort(400, "Your point is not enough, $rewardName need minimum of $pointNeeded point");
        }
    }
}
